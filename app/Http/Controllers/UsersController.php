<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\PasswordField;
use App\Mail\PasswordRecovery;
use App\Notification;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \Validator;
use App\Http\Controllers\UnicardController;
use App\Currency;
class UsersController extends Controller
{
    //

    public function __construct(){

        $this->middleware('auth',['except'=>['verification','passwordRecovery','pswdByOwner']]);

    }
    // email verification
    public function verification(Notification $notification, $token){
        if($notification->user->email_token == $token ){
            if($notification->user->email_verified == 1){
                $notifications = Notification::query()->where('user_id', $notification->user->id)->where('button_action', 'resend_verification_email')->where('status', 0)->get();
                if (count($notifications) > 0) {
                    foreach ($notifications as $not) {
                        $not->status = 1;
                        $not->save();
                    }
                }

                return redirect('/dashboard');
            }
            $notification->user->email_verified = 1;
            $notification->user->email_token = 0;
            $notification->status = 1;
            $notification->user->save();
            $notification->save();


            $notification->user->notifications()->save(new Notification(config('defaults.notifications.email_verified')));
            return redirect('/dashboard');
            //
        }else{
            dd('link expired, please resend it');

            //todo /link expired 404 error page
        }

    }


    public function passwordRecovery(Request $request) {
        $rules = [
            'email' => 'required'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;
        }else{

            $email = $request->input('email');
            $user = User::query()->where('email',$email)->first();
            if($user->email_verified == 1 ) {
                $token= str_random('25');
                $data = $user->passwordResets()->save(new PasswordReset(['email'=>$email,'token'=>$token,'created_at'=>Carbon::now()]));
                Mail::to($user->email)->send(new PasswordRecovery($user,$data));
                $result = ['success'=>true, 'result'=>trans('mail.sent'),'error'=>''];
                return $result;
            }
            $result = ['success'=>false, 'result'=>'','error'=>['alert'=>trans('defaults.user_not_found')]];
            return $result;
        }
    }

    public function pswdByOwner(User $user, $token) { // password recovery

        $TFHoursBefore = Carbon::now()->subHours(1);
        $passReset = $user->passwordResets()->where('created_at', '>' ,$TFHoursBefore)->where('token',$token)->first();

        if($passReset->count()) {

            // todo generate new password for user and send to mail
            $password = str_random('10');
            $password_hashed = bcrypt($password);
            $data = (object)['password'=>$password];

            Mail::to($user->email)->send(new PasswordField($user,$data));

            $user->password = $password_hashed;
            $user->save();


            // todo create notification to change password
//            return redirect('/')->with(['success'=>true,'alert'=>trans('mail.password_recovery_success')]);
            return redirect('/?alert='.trans('mail.password_recovery_success'));
        }

//        return redirect('/')->with(['alert'=>trans('mail.password_recovery_fail')]);
        return redirect('/?alert='.trans('mail.password_recovery_fail'));
    }


    public function updateAddress(Request $request) {
        $rules = [
            'country_id' => 'required',
            'city_town' => 'required',
            'postcode' => 'required',
            'address_1' => 'required',
            'password' =>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;

        } else {

            $user_password = auth()->user()->password;
            if(Hash::check($request->input('password'), $user_password)) {

                auth()->user()->update($request->only(['country_id','city_town','postcode','address_1','address_2']));

                return [
                    'success'=>true,
                    'result'=>true
                ];
            } else {
                return [
                    'success'=>false,
                    'error'=>[
                        'password'=>trans('defaults.wrong_password')
                    ]
                ];
            }
        }
    }


    public function updateUnicard(Request $request) {
        $rules = [
            'unicard' => 'sometimes',
            'password' =>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;

        } else {

            $user_password = auth()->user()->password;
            if(Hash::check($request->input('password'), $user_password)) {

                if($request->get('unicard')) {
                    if (strpos(str_replace(' ', '', $request->get('unicard')), '119911') == 0) {
                        $unicard = UnicardController::getAccountInfo($request->get('unicard'));

                        if ($unicard['success']) {
                            auth()->user()->update($request->only("unicard"));
                            return $this->success(trans('defaults.op_success'));
                        } else {
                            return $this->failure(['unicard' => trans('defaults.unicard.not_exists'), 'message' => trans('defaults.unicard.not_exists')]); // todo translate
                        }

                    }
                    return $this->failure('defaults.op_failure');
                }else{
                    auth()->user()->update(["unicard"=>'']);
                    return $this->success(trans('defaults.op_success'));
                }
            } else {
               return $this->failure(['password'=>trans('defaults.wrong_password'),'message'=>trans('defaults.wrong_password')]);
            }
        }
    }


    public function showAddress() {
        $result = User::query()->select(['email','mobile','country_id','city_town','address_1','address_2','postcode','unicard'])->with('country')->find(auth()->user()->id);

        return [
          'success'=>true,
          'result'=>$result,
          'error'=>''
        ];

    }
    public function updateEmail(Request $request) {

        $rules = [
            'email' => 'required',
            'password' =>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;

        } else {


            $user_password = auth()->user()->password;
            if(Hash::check($request->input('password'), $user_password)) {

                if(auth()->user()->email_verified) {
                    $notiffication = new Notification(config('defaults.notifications.email_verification'));
                }else{
                    $notiffication = auth()->user()->notifications()->where('button_action','resend_verification_email')->where('status','0')->first();
                }

                $all = [
                    'email'=>$request->get('email'),
                    'email_verified'=>0,
                    'email_verification_count'=>0,
                    'email_token'=>str_random(25)
                ];

//                dd($all);
                auth()->user()->update($all);

//                dd(auth()->user());

                $user = auth()->user();
                $user->notifications()->save($notiffication);
                Mail::to($user->email)->send(new EmailVerification($user,$notiffication));

                return [
                    'success'=>true,
                    'result'=>true
                ];

            } else {
                return [
                    'success'=>false,
                    'error'=>[
                        'password'=>trans('defaults.wrong_password')
                    ]
                ];
            }


        }

    }

    public function updatePassword(Request $request) {
        $rules = [
            'password' => 'required|confirmed|min:6',
            'current_password' =>'required'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;

        } else {


            $user_password = auth()->user()->password;
            if(Hash::check($request->input('current_password'), $user_password)) {
                $all = ['password'=>bcrypt($request->get('password'))];

                auth()->user()->update($all);

                return [
                    'success'=>true,
                    'result'=>trans('defaults.passResetSuccess'),
                    'error'=>''
                ];
            } else {
                return [
                    'success'=>false,
                    'error'=>[
                        'password'=>trans('defaults.wrong_password')
                    ]
                ];
            }


        }
    }

    public function getBalances() {
        if(auth()->check()){

            $balance = "(". auth()->user()->balance ." GBP)";
            
            $unicardInGBP = ''; 
            $unicardBalance= ''; 
            if(auth()->user()->unicard != '') {
                $unicardNumber = auth()->user()->unicard;
                $unicard = UnicardController::getAccountInfo($unicardNumber);
                if($unicard['success']){

                    $unicardBonus = $unicard['data']['bonus'];
                    $unicardGel = $unicard['data']['amount'];
                    // $unicardInGBP = ;


                    $currencies = Currency::query()->where('id',1)->first()->toArray();
                    $rates = $currencies;
                    // $rates['GBPGEL'] = $rates['USDGEL'] / $rates['USDGBP'];
                    // $rates['EURGEL'] = $rates['USDGEL'] / $rates['USDEUR'];
                    $gelGBP = round($rates['GELGBP'],3);
                    $bonusToGbp = round($unicardGel * $gelGBP,3);
                    $unicardBalance = "( $unicardBonus ".trans('defaults.points'). " = $bonusToGbp GBP)";
                }
            }


            

            return $this->success([
                'balance'=>$balance,
                'unicard'=>$unicardBalance
            ]);
        }
        return $this->permissionDenied();
    }
}
