<?php

namespace App\Http\Controllers\Auth;

use App\Ads;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user-panel';

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
     // protected function credentials(Request $request)
     //  {
     //      return [
     //          'email' => $request->{$this->username()},
     //          'password' => $request->password,
     //          'sta' => '1',
     //      ];
     //  }

    //app\Http\Auth\LoginController
    protected function authenticated($request, $user)
    {
      if ($user->status == 0) {
                  $message = 'This account been blocked, please contact us for more information!';
                  Auth::logout($request);
                  return back()->with('error',$message)->withInput($request->only('email'));
              }

        if (!Auth::guest())
        {
            User::whereId(Auth::user()->id)->update(['is_login' => 1]);
            Ads::where('user_id', Auth::user()->id)->update(['is_login' => 1]);
        }

        if ($user->type == 'adm')
        {
            return redirect('/admin');
        }else{
            return redirect('user-panel');
        }
    }
    // logout user
    public function logout(Request $request)
    {
        User::whereId(Auth::user()->id)->update(['is_login' => 0]);
        Ads::where('user_id', Auth::user()->id)->update(['is_login' => 0]);
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
