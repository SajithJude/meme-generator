<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Models\{
    User,
    Role,
    UserLoginLog
};

class AuthenticatedSessionController extends Controller {

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request) {
        $request->authenticate();

        $request->session()->regenerate();
        User::where('id',Auth::guard('web')->user()->id)->update(['last_login_at'=>date('Y-m-d H:i:s')]);
        $user = User::where('id',Auth::guard('web')->user()->id)->select('id as user_id','last_login_at','last_logout_at')->first()->toArray();
        //dd($user);
        UserLoginLog::saveData($user,'login');
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request) {
        $user = User::where('id',Auth::guard('web')->user()->id);
        $user_id = Auth::guard('web')->user()->id;
        Auth::guard('web')->logout();
        if($user != NULL){
            $user->update(['last_logout_at'=>date('Y-m-d H:i:s')]);
            $user = User::where('id',$user_id)->select('id as user_id','last_login_at','last_logout_at')->first()->toArray();

            $log = UserLoginLog::where('user_id',$user_id)->orderby('id','desc')->first();
            if($log != NULL)
                $log->update(['logout_at'=>date('Y-m-d H:i:s')]);

        }
       

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function socialLogin($social) {
        return Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response
     */
    public function handleProviderCallback($social) 
    {
        $userSocial = Socialite::driver($social)->user();
        $full_name = explode(" ", $userSocial->name);
        $first_name = $full_name[0];
        $last_name = $full_name[1];

        $data['email'] = $userSocial->email;
        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['is_active'] = '1';

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if ($user) {

            Auth::login($user);
            //----------logging logins
            $user = User::where('id',$user->id)->select('id as user_id','last_login_at','last_logout_at')->first()->toArray();
            UserLoginLog::saveData($user,'login');
            //------------------------
             return redirect(RouteServiceProvider::HOME);
        } else {
            $user = User::create([
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'is_active' => $data['is_active'],
                        'email_verified_at' => date('Y-m-d H:i:s')
            ]);
            Auth::login($user);
            //----------logging logins
            $user = User::where('id',$user->id)->select('id as user_id','last_login_at','last_logout_at')->first()->toArray();
            UserLoginLog::saveData($user,'login');
            //------------------------
            return redirect(RouteServiceProvider::HOME);
        }
    }

    public function signUpFree() 
    {   
        \DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['is_sign_up_free'=>1]);
        return redirect('/home');
    }

}
