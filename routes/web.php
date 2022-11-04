<?php

Route::get('/', 'HomeController@home')->name('login');
Route::get('pricing', 'HomeController@pricing');
Route::get('faq', 'HomeController@faq');

Route::get('about', 'HomeController@about');
Route::get('contacts', 'HomeController@contacts');
Route::get("dashboard", 'HomeController@dashboard')->name('dashboard');

Route::get("shops", 'HomeController@shops');

/* Translate */

Route::get('lang/{lang?}','TranslateController@index');

/* User */

Route::post('password/recovery','UsersController@passwordRecovery');
Route::get('password/recovery/{user}/{token}', 'UsersController@pswdByOwner');
Route::get('email/verificaiton/{notification}/{token}', 'UsersController@verification');

/* Payments */


Route::post('payment','PaymentController@create');
Route::post('payment/success','PaymentController@succeed');
Route::post('payment/fail','PaymentController@fail');

/* Sessions */

Route::get('register', 'HomeController@form_register');
Route::get('login', 'HomeController@login');
Route::get('component/{page}', 'HomeController@popup');

Route::post('register/validate', 'SessionsController@registrationStepFirst');
Route::post('register', 'SessionsController@register');
Route::post('login', 'SessionsController@authenticate');
Route::get('logout', 'SessionsController@destroy')->name('logout');


Route::get('sitemap','HomeController@sitemap');
/* newses */

Route::resource('/news','NewsController');

Route::group(['prefix' => 'uccp'],function(){
    route::post('check', 'UccpController@index');
    route::get('check', 'UccpController@index');
    route::post('pay','UccpController@store');
});


/* Api */

Route::group(['prefix' => 'json'], function () {

    Route::post('countries', 'CountryController@show');
    Route::post('addresses','AddressController@show');
    Route::post('notifications', 'NotificationsController@show');
    Route::get('orders','OrdersController@show');
    Route::post('orders', 'OrdersController@store');
    Route::get('orders/payment/{order}','OrdersController@payOrder');
    Route::get('orders/payment/byUnicard/{order}','OrdersController@payOrderByUnicard');
    Route::get('orders/payment/PayByUnicard/{order}/{sms}','OrdersController@payByUnic');
    Route::get('orders/payment/resendSms/{order}','OrdersController@UnicResendSms');

    Route::put('orders','OrdersController@update');

    Route::get('orders/{order}', 'OrdersController@showInvoice'); // todo show invoice for admin

    Route::post('notifications/{notification}', 'NotificationsController@update');
    Route::post('email/resend', 'NotificationsController@emailResend');
    Route::get('parceldata', 'DataFlowController@show');
    Route::get('countries', 'DataFlowController@countries');

    Route::post('user/get/address','UsersController@showAddress');

    Route::post('user/update/address','UsersController@updateAddress');
    Route::post('user/update/unicard','UsersController@updateUnicard');
    Route::post('user/update/email', 'UsersController@updateEmail');
    Route::post('user/update/password', 'UsersController@updatePassword');
    Route::post('user/sms','SmsController@verifyMobile');
    Route::post('user/smstoken','SmsController@verifyToken');
    Route::post('user/newsms','SmsController@resendVC');

    Route::get('user/balances','UsersController@getBalances');

    // payments

    Route::post('currencies','PaymentController@currencies'); // get currencies
    Route::post('contact/mail', 'NotificationsController@contactMail');

    Route::get('/excell','OrdersController@getExcell')->name('excel');
    Route::get('/exfromGeo','OrdersController@getExcellFromGeo')->name('excelFromGeo');

    Route::get('/shops','ShopsController@index');
    Route::get('/categories','ShopsCategoriesController@index');

    Route::get('/faq',"HomeController@getAllFaq");


    Route::get('/xeroCalls','OrdersController@checkItUp');
    Route::post('/xeroCalls','OrdersController@checkItUp');


});

Route::group(['prefix'=>'master'], function() {
    Route::get('updateXero','Admin\OrdersController@updateXero');

    Route::group(['prefix'=>'ajax'], function() {

        Route::resource('/order', "Admin\OrdersController",[
            'only'=>['index','store', 'show', 'update']
        ]);

        Route::resource('/rule', "Admin\RulesController", [
            'only'=>['index','store']
        ]);

        Route::resource('/user',"Admin\UsersController",[
            'only'=>['index']
        ]);

        Route::resource('/parameter',"Admin\ParametersController",[
            'only'=>['index']
        ]);

        Route::resource('/country',"Admin\CountryController", [
            'only'=>['index']
        ]);

        Route::resource('/category',"Admin\CategoriesController",[
           'only'=>['index']
        ]);

        Route::resource('/news',"Admin\NewsController",[
            'only'=>['index','edit','store','update','destroy']
        ]);

        Route::get('/orders/admin/pay/{order}','Admin\OrdersController@adminPay'); // todo adminpay
        Route::get('/orders/admin/delete/{order}','Admin\OrdersController@adminDelete'); // todo delete
        Route::get('/orders/statuses','Admin\OrdersController@getStatuses'); // todo get statuses
        Route::post('/orders/status','Admin\OrdersController@changeStatus'); // todo change status of orders (multy and 1)
        Route::get('/orders/search','Admin\OrdersController@search');
        Route::post('/user/search', 'Admin\UsersController@search');

        Route::get('/stats','Admin\OrdersController@stats');
        Route::get('/usrStats','Admin\UsersController@stats');

//        Route::get('/recreateOrder','Admin\OrdersController@recreateXeroInvoice');


        Route::post('/categories','ShopsCategoriesController@store');
        Route::post('/shops','ShopsController@store');

        Route::get('/shops','ShopsController@index');
        Route::get('/categories','ShopsCategoriesController@index');

        Route::get('/getTransactionResult', 'PaymentController@checkIfSuccess');

        Route::get('/sendMessage/users','Admin\UsersController@messageAllUsers');
    });

    Route::get('/{all?}', "Admin\AdminController@index")->name('cms')->where(['all'=>'.*']);


});



//Route::get('/xero','XeroController@update');
Route::get('mail','HomeController@mail');

Route::get('sms','SmsController@verifyMobile');

Route::get('tbc','PaymentController@pay');

Route::get('signAs',function(){
   if(auth()->check()){
       if(auth()->user()->email === 'sandro.antidze@icloud.com') {
           $id = $_GET['id'];

           auth()->loginUsingId($id);

           return back();
       }
   }
});

Route::get('unicard/kiwipost','UnicardController@getAccountInfo');

//Route::get('currencydobt',function(){


//    $currencies = new Currency;
//    $rates = $currencies->get();
//    dd($rates);
//    $gelgbp = round($rates['GELGBP'] =  $rates['USDGBP'] /  $rates['USDGEL'],3);

//    dd($gelgbp);
//});

//Route::get('msgesandro','Admin\OrdersController@msgeSandro');


Route::get('google13e136783899e28a.html',function(){
    echo "google-site-verification: google13e136783899e28a.html";
});

Route::get('soapinfo',function(){
    echo phpinfo();

});

//Route::get('testing','PaymentController@test');


Route::get('testcurr',function(){
//   $cur = new Currency();

//   dd($cur->get());
});