<?php

namespace App\Http\Controllers;

use App\Mail\ContactSupport;
use App\Mail\EmailVerification;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{

    public function __construct(){

        $this->middleware('auth',['except'=>['contactMail']]);

    }

    public function show() {

        $notifications = auth()->user()->notifications()->where('status',0)->get();
        return [
            'success'=>true,
            'result'=> $notifications,
            'error'=>null,
        ];
    }

    public function update(Notification $notification){
        $user_id = auth()->user()->id;

        if($notification->user_id == $user_id) {
            $notification->status = 1;
            $notification->save();

            return  [
                'success'=>true,
                'result'=>'',
                'error'=>null
            ];

        }else {

            return [
                'success' => false,
                'result' => '',
                'error' => null
            ];
        }
    }

    public function emailResend(){

        $user = User::find(auth()->user()->id);
        if($user->email_verification_count > 3) {
            return [
                'success' => false,
                'result' => '',
                'error' => trans('defaults.email_count')
            ];
        }

        $notification = $user->notifications()->where('button_action','resend_verification_email')->orWhere('button_2_action','resend_verification_email')->first();

        Mail::to($user->email)->send(new EmailVerification($user, $notification));

        $user->email_verification_count += 1;
        $user->save();

        return [
            'success' => true,
            'result' => '',
            'error' => null
        ];


    }

    public function contactMail(Request $request){
        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            'title' => 'required',
            'message' => 'required',
            'country' => 'required'
        ];

        $validator = \Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return $this->failure($validator->messages());

        } else {

            $data = [
                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'title'=>$request->get('title'),
                'text'=>$request->get('message'),
            ];

            $mail_to = $request->get('country') == 'UK' ? 'info@kiwipost.co.uk' : 'info@kiwipost.ge';
            
            Mail::to($mail_to)->send(new ContactSupport($data));
            return $this->success(['message sent']); // todo translate

        }



    }


}
