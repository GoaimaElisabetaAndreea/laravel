<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    public function getSignIn()
    {
        return view('account.sign-in');
    }
    public function getCreate()
    {
        return view('account.create');
    }

    public function getSignOut()
    {
        Auth::logout();
        return Redirect::route('home');
    }
    public function getActivate($code){
        $user = User::where('code','=',$code)->where('active','=',0);

        if($user->first())
        {
            $user = $user->first();
            $user->active = 1;
            $user->code = '';

            if($user->save())
            {
                return Redirect::route('home')->with('global', 'Your account has been activated.');
            }
        }

        return Redirect::route('home')->with('global', 'Your activation code is invalid.');
    }

    public function getChangePassword()
    {
        return view('account.change-password');
    }

    public function getForgotPassword(){
        return view('account.forgot-password');
    }
    public function postSignIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return Redirect::route('account-sign-in')->withErrors($validator)->withInput();
        }
        else
        {
            $auth = Auth::attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'active' => 1
            ]);

            if($auth)
            {
                return Redirect::intended('/');
            }
            return Redirect::route('account-sign-in')->with('global','There was a problem signing you in. Have you activated your account?');
        }
    }

    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(),array(
            'email' => 'required|max:50|unique:users',
            'username' => 'required|max:20|min:3|unique:users',
            'password' => 'required|min:6',
            'password_again'=>'required|same:password'
        ));

        if($validator->fails())
        {
            return Redirect::route('account-create')
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $email = $request->get('email');
            $username = $request->get('username');
            $password = $request->get('password');

            //Activation code
            $code = Str::random(60);

            $user = User::create(array(
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'code' => $code,
                'active' => 0
            ));

            if($user){

                Mail::send('emails.auth.activate', array(
                    'link' => URL::route('account-activate',$code),
                    'username' => $username), function($message) use ($user) {
                    $message->to($user['email'], $user['username'])->subject('Activate your account');
                });
                return Redirect::route('home')->with('global', 'Your account has been created. We have sent you an activation code. Please check your email to activate your account. ');
            }

        }
    }

    public function postChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|same:password'
        ]);

        if($validator->fails())
        {
            return Redirect::route('account-change-password')->withErrors($validator);
        }
        else
        {
            $user = Auth::user();

            $old_password = $request->input('old_password');
            $password = $request->input('password');

            if(Hash::check($old_password,$user->getAuthPassword())){
                $user->update(['password' => Hash::make($password)]);
                return Redirect::route('home')->with('global','Your password has been changed');
            }
            else
            {
                return Redirect::route('account-change-password')->with('global','Your old password is incorrect');
            }
        }
    }

    public function postForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(),['email' => 'required|email']);

        if($validator->fails())
        {
            return Redirect::route('account-forgot-password')->withErrors($validator)->withInput();
        }
        else
        {
            $email = $request->input('email');
            $user = User::where('email',$email)->first();
            if($user)
            {
                $code = Str::random(60);
                $password = Str::random(10);

                $user->update(['code' => $code, 'password_temp' => Hash::make($password)]);

                Mail::send('emails.auth.recover', ['link' => route('account-recover',$code),'username'=> $user->username,'password'=>$password],function($message) use ($user) {
                    $message->to($user->email, $user->username)->subject('Your new password');
                });

                return Redirect::route('home')->with('global','We have sent you a new password on your email');
            }
        }
        return Redirect::route('account-forgot-password')->with('global','Could not request new password');
    }

    public function getRecover($code)
    {
        $user = User::where('code','=',$code)->where('password_temp','!=','')->first();
        if($user)
        {
            $user->update(['password' => $user->password_temp, 'password_temp' => '', 'code'=>'']);
            return  Redirect::route('home')->with('global','Your account has been recovered and you can now sign in');
        }
        return Redirect::route('home')->with('globale','Could not recover your account');
    }
}
