<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    private  $notification_subject, $notification_to_email = "";

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        //return redirect('register')->with('success', 'Email is send to your email! confirm to continue!');
        $this->guard()->login($user);
       // if (!Auth::guest()){
            User::whereId(Auth::user()->id)->update(['is_login' => 1]);
        //}
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|string',
            'type' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // send email
        $this->notification_to_email = $data['email'];
        $this->notification_subject = 'Confirm email';
        $url = base64_encode($data['type'].'%'.$data['email'].'%'.$data['name']);

        $link = url('confirm/query?user='.str_replace('=', '', $url));
        $result = array(
            'email' => $data['email'],
            'link' => $link,
            'name' => $data['name'],
            );
                 Mail::send('emails.confirm', $result, function($msg){
                     $msg->subject($this->notification_subject);
                     $msg->to($this->notification_to_email);
                 });

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'plain_password' => $data['password'],
            'gender' => $data['gender'],
            'type' => $data['type'],
            'status' => 1
        ]);
    }
}
