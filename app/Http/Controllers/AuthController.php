<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Mail;


class AuthController extends Controller
{
 
    /**
    * Login function for login route
    */
    public function login()
    {
	 return view('auth.login');
    }


    /**
    * handleLogin function takes the requested email , 
    * password and userType to check if exist or not and then
    * check the account's status type if it confirmed or not yet 
    */
    public function handleLogin(Request $request)
    {
      $this->validate($request, User::$login_validation_rules);
      $data = $request->only('email', 'password','user_type');
      $data['account_status'] =  'confirmed'; // to check the user account is confirmed for logging in 
      if(\Auth::attempt($data)){
      return redirect()->intended('home');
    }
    return back()->withInput()->withErrors(['email' => 'Username , password or login type is invalid, or your account not confirmed yet.']);
    }


    /**
    * Logout function for logout route
    */
    public function logout()
    {
      \Auth::logout();
      return redirect()->route('login');
    }



    /**
    * The forgotpassword function for forgotpassword route  
    */
    public function forgotpassword(){
       return view('auth.forgotpassword');
    }
      
    /**
    * Handel forgot function takes the requested
    * email and generats a reset token for the account
    * and send this token to that mail to confirm the reseting process
    */

    public function handleForgot(Request $request){
    $this->validate($request, User::$forgotpassword_rules);
    $data = $request->only('email');
    $data['password_reset_token'] =  str_random(100);
    $user = new User ; 
    $user = $user->select()->where('email','=',$data['email']) ; 
    if(count($user)>0){
     $user->where('email','=',$data['email'])
          ->update(['password_reset_token'=>$data['password_reset_token']]);

       Mail::send('mails.passwordreset',['data'=>$data],function($mail) use($data){
                $mail->from('desertfox.php.task@gmail.com', 'Password reset ');
                $mail->subject('Password reset');
                $mail->to($data['email'],'Account reset password');
                });
              \Session::flash('message','password reset link has sent to your account email .');
    } 
     return redirect()->intended('forgotpassword');      
    }


    /**
    * Handel passwordReset function takes the requested 
    * email and token to check if the requested data
    * are existing or not to update the password 
    */
    
    public function passwordReset($email , $confirm_token){
        $user = new User;
        $the_user = $user->select()->where('email','=',$email)
                                   ->where('password_reset_token','=',$confirm_token)->get();
        if(count($the_user)>0)
        {
        \Session::put('password_token', $confirm_token);
        \Session::put('email', $email);
        return view('auth.updatepassword');
        }
       
        else 
        {
         \Session::flash('error_message',' Confirmation failed.  ');
             return redirect()->route('forgotpassword');
       }
    
    }

    
    /**
    * Updatepassword function takes the new requested password  
    * and compare the email and token with the emailed token and 
    * email to identify that is a correct link then update 
    * the email's password for all accounts with the same email 
    */

    public function updatePassword(Request $request){
       $this->validate($request, User::$resetpassword_rules);
      $data = $request->only('password','email','password_token');
        $user = new User;
        $the_user = $user->select()->where('email','=',$data['email'])
                                   ->where('password_reset_token','=',$data['password_token'])->get();
        if(count($the_user)>0)
        {
           $user->where('email','=',$data['email'])
                ->where('password_reset_token','=',$data['password_token'])
                ->update(['password'=>bcrypt($data['password']) ] );
          \Session::flash('message','Password changed successfully  .');
          return redirect()->route('login');
        }
      return view('auth.updatepassword');
    }















}
