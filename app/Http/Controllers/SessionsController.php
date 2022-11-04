<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Http\Controllers\UnicardController;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \Validator;
use Mail;
use Carbon\Carbon;
use App\Unicard;



class SessionsController extends Controller
{

    public function authenticate(Request $request){

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $result = ['success'=>true, 'result'=>'Auth success', 'error'=>''];
            return $result;

        }else{

            $result = ['success'=>false, 'result'=>'', 'error'=>'wrong email/password'];
            return $result;

        }

    }

    public function registrationStepFirst(Request $request) {

        $rules = [
            'country_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'terms'=>'accepted'

        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            $result = ['success'=>false, 'result'=>'','error'=>$validator->messages()];
            return $result;
        }else{
            $result = ['success'=>true, 'result'=>'','error'=>''];
            return $result;
        }
    }

    public function register(Request $request) {

        $rules = [
            'country_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'address_1' => 'required',
            'personal_number' => 'required|unique:users',
            'postcode' => 'required',
            'city_town' => 'required',
            'mobile' => 'required|unique:users',
            'g-recaptcha-response' => 'required|recaptcha',
            'unicard'=>'sometimes',
        ];
        $setBonusPoints = false;

        if($request->get('unicard')){

            $unicard['success'] = true;
//            return $this->failure(['unicard'=>$request->get('unicard')]);

            if (strpos(str_replace(' ', '', $request->get('unicard')), '119911') == 0) {

                if(user::query()->where('unicard',str_replace(' ', '', $request->get('unicard')))->count()){
                    return $this->failure(['unicard'=>[trans('defaults.unicard.already_exists')]]);
                }

                if(Unicard::query()->where('unicardNumber',str_replace(' ', '', $request->get('unicard')))->count()){
                    return $this->failure(['unicard'=>[trans('defaults.unicard.already_rewarded')]]);
                }
                $unicard = UnicardController::getAccountInfo(str_replace(' ', '', $request->get('unicard')));

//                return $this->failure([
//                    'unicard'=>$unicard,
//                    'request'=>str_replace(' ', '', $request->get('unicard'))
//                ]);

                if ($unicard['success']){
                    // todo enter date from tomorrow till 28th of february
                    $first = Carbon::create(2018, 1, 26, 0, 0, 0);
                    $second = Carbon::create(2018, 2, 28, 0, 0, 0);
                    $bonusableDay = (Carbon::now()->between($first, $second));
                    if($bonusableDay) {
                        $setBonusPoints = true;
                    }
                }else{
                    return $this->failure(['unicard'=>[trans('defaults.unicard.not_exists')]]);
                }
            }
            if(!$unicard['success']){                
                return $this->failure(['unicard'=>[trans('defaults.unicard.not_exists')]]);
            }
        
        }

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return $this->failure($validator->messages());

        } else {
            //edit mobile number format
            $nmber = str_replace(' ','',$request->get('mobile'));
//            if (strlen($nmber) == 9) {
//                $nmber = '995' . $nmber;
//            } elseif (strlen($nmber) == '13') {
//                $nmber = substr($nmber, 1);
//            }
            if (strpos($nmber,'995') == 0) {
                $num = User::query()->where('mobile', $nmber)->where('temp','0')->get();

                if ($num->count()) {
                    return $this->failure(['mobile' => [trans('defaults.numberExists')]]);
                }
            }else{
                if($request->get('country_id') == 1) {
                    return $this->failure(['mobile' => [trans('defaults.wrongNumber')]]);
                }
            }
            $all = $request->only([ 'country_id','email', 'password', 'name','surname','address_1','address_2','personal_number','postcode','city_town','newsletter']);
            $all['password'] = bcrypt($all['password']);
            $all['mobile_2'] = $nmber;
            $all['unicard'] = str_replace(' ', '', $request->get('unicard'));
            $user = User::create($all);

            $user->email_token = str_random('25');

            $notiffication = new Notification(config('defaults.notifications.email_verification'));
            $notiffication2 = new Notification(config('defaults.notifications.mobile_verification'));
            $user->notifications()->save($notiffication);
            $user->notifications()->save($notiffication2);

            Mail::to($user->email)->send(new EmailVerification($user,$notiffication));
            $user->email_verification_count += 1;
            $user->save();

            if($setBonusPoints){
//                $connect = UnicardController::setBonuse(str_replace(' ', '', $request->get('unicard')));
//                return $this->failure([
//                    'connect'=>$connect
//                ]);
                    $Ucard = new Unicard();
                    $Ucard->transporting_cost = "20";
                    $Ucard->user_id = $user->id;
                    $Ucard->trans_id_stan = "Ttr - $user->id";
                    $Ucard->amount = "20";
                    $Ucard->status = 1;
                    $Ucard->message = "bonus operation-manual success!";
                    $Ucard->unicardNumber = str_replace(' ', '', $request->get('unicard'));
                    $Ucard->save();
            }

            Auth::login($user,true);

            if ($request->get('country_id') == 1) {
                SmsController::sendSmsVerification($request);
            }
            $result = ['success'=>'true', 'result'=>'','error'=>''];
//return $this->failure(['rter']);
            return $result;
        }

    }

    public function destroy()
    {

        if(auth()->check()) {
            Auth::logout();
        }
        return redirect()->route('login');

    }


}
