<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XeroPHP\Models\Accounting\Account;
use XeroPHP\Models\Accounting\Invoice;
use XeroPHP\Remote\URL;
use \XeroPrivate;
use \SimpleXMLElement;
use File;


use Storage;
class XeroController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth');
        $this->middleware('roles');
    }
    public static function create($data,$user) {


        $contact = app()->make('XeroContact');
        $xero = app()->make('XeroPrivate');
        $invoice = app()->make('XeroInvoice');
        $line1 = app()->make('XeroInvoiceLine');


        $contact->setContactStatus('ACTIVE');
        $contact->setName($user->name.' '.$user->surname); // user name and lastname
        $contact->setFirstName($user->name); // another name
        $contact->setLastName($user->surname); // lastname
        $contact->setEmailAddress($user->email); // user email
        $contact->setDefaultCurrency('GBP');


        $invoice->setContact($contact);



        $invoice->setType('ACCREC');

        $dateInstance = new \DateTime();
        $invoice->setDate($dateInstance);
        $invoice->setDueDate($dateInstance);



        $invoice->setCurrencyCode('GBP');
        $invoice->setStatus('AUTHORISED');
        $line1->setDescription('SHIPMENT');
        $line1->setQuantity(1);

        $whole_cost =  (double)$data['parcel_cost'] + (double)$data['from_delivery_cost'] + (double)$data['to_delivery_cost'] ;
        $line1->setUnitAmount($whole_cost);
        $line1->setTaxAmount(0);
        $line1->setAccountCode(1);
        $line1->setLineAmount($whole_cost);
        $line1->setDiscountRate(0);

        $invoice->addLineItem($line1);



        $saved_data = $xero->save($invoice)->getElements();


        $url = new URL($xero, sprintf('%s/%s/%s', $invoice::getResourceURI(), $invoice->getGUID(), 'OnlineInvoice'));
        $request = new \XeroPHP\Remote\Request($xero, $url, Request::METHOD_GET);

        $request->send();

        $response = $request->getResponse();
//        $payment_url = $response->getElements();

        $xml_result = new SimpleXMLElement($response->getResponseBody());

        $payment_url = $xml_result->OnlineInvoices->OnlineInvoice->OnlineInvoiceUrl; // payment url
        $invoice_number = $saved_data[0]['InvoiceNumber']; // invoice number of request

        return [
            'success'=>true,
            'invoice_number'=>$invoice_number,
            'payment_url' => $payment_url,
            'xero_guid'=>$xml_result->Id
        ];

    }

    public static function update($data){
        $invoice =  XeroPrivate::load(Invoice::class)->where('InvoiceNumber',$data->xero_invoice_number)->execute()[0];

        $invoice = app()->make('XeroInvoice');

//
//        if($invoice['Status']=='PAID'){
//            return [
//                'success'=>false
//            ];
//        }
        return [
            'inv'=>$invoice
        ];



        return [
            'success'=>true,
            'data'=>$xero
        ];

    }

    public static function pay($data) {


        $invoice =  XeroPrivate::load(Invoice::class)->where('InvoiceNumber',$data['invoice_number'])->execute()[0];

        if($invoice['Status']=='PAID'){
            return [
                'success'=>false
            ];
        }
        $xero = app()->make('XeroPrivate');

//        $invoice = XeroPrivate::load(Invoice::class)->where('InvoiceNumber',$data['invoice_number'])->execute()[0];
//        $account = XeroPrivate::loadByGUID(Account::class, 'C901BA44-22F3-45CF-8541-775B921E7302');

        $account = new Account();
        $account->setCode(692);
        $account->setName('Business Bank Account');
        $account->setType('BANK');
        $account->setBankAccountNumber('40010682739801');
        $account->setStatus('ACTIVE');
        $account->setBankAccountType('BANK');
        $account->setCurrencyCode('GBP');
        $account->setTaxType('NONE');
        $account->setEnablePaymentsToAccount(false);
        $account->setShowInExpenseClaim(false);
        $account->setAccountID('c901ba44-22f3-45cf-8541-775b921e7302');
//        $account->setClass('ASSET');
//        $account->setReportingCode('ASS');
//        $account->setReportingCodeName('Assets');
        $account->setApplication(app()->make('XeroPrivate'));



        $payment = new \XeroPHP\Models\Accounting\Payment($xero);
        $payment->setInvoice($invoice)
            ->setAccount($account)
            ->setAmount($data['amount'])
            ->setDate(new \DateTime())
            ->setIsReconciled(1)
            ->setStatus(\XeroPHP\Models\Accounting\Payment::PAYMENT_STATUS_AUTHORISED);

        $r = $payment->save();

//        return $r->getElements();
        return [
            'success'=>true
        ];
    }

    public static function resource($guid) {
        if($guid) {
            $xero = XeroPrivate::loadByGUID(Invoice::class, $guid)->jsonSerialize();

//            if ($xero['Status'] == 'PAID') {
            return [
                'success' => true,
                'data' => $xero
            ];
//            }
        }
        return [
            'success'=>false,
            'data'=>[]
        ];



    }

    public static function check($data){
        $check =  XeroPrivate::load(Invoice::class)->where('InvoiceNumber',$data['invoice_number'])->execute()[0];


        return [
            'success'=>$check['Status']=='PAID'
        ];

    }

}
