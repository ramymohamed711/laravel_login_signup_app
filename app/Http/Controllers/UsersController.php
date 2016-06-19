<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
    * Store function takes the requested data to register new user, 
    * validate these data and send the registeration confirmation email.
    */
    public function store(Request $request)
    {
        $this->validate($request, User::$create_validation_rules);
        $user = new User;
        $user = $user->select()->where('email','=',$request['email'])
                               ->where('user_type','=',$request['user_type'])->get();
        /**
        * Check if the user exists before with the same
        * account type. 
        */
        if(count($user) == 0 ){
        $data = $request->only('firstname','surname', 'email', 'password','gender','user_type');
        $data['password'] = bcrypt($data['password']);
        $data['confirmation_token'] = str_random(100);
        $user = User::create($data);
        if($user)
        {
                Mail::send('mails.register',['data'=>$data],function($mail) use($data){
                $mail->from('desertfox.php.task@gmail.com', 'Registiration confirmation');
                $mail->subject('Confirmation email');
                $mail->to($data['email'],$data['firstname'].' '.$data['surname']);
                });
              \Session::flash('message','Your registeration successfully submitted please check your email to confirm your account.');
        if(\Auth::check())
         {
            return redirect()->route('home');  // return to home if the user alread logged in and make new user 
         }
        else{
            return redirect()->route('login'); //return to login if user not logged in and make new user
         }

       }
    }
    else
     {
        \Session::flash('error_message','This account already exist .');
    }
     
     return back()->withInput();
    }


    /**
    * Confirm register takes the emailed token and check 
    * it's existance with the account email to identify that is a correct token 
    * then update the account status to confirmed  
    */
    public function confirmRegister($email , $confirm_token){
        \Auth::logout();
        $user = new User;
        $the_user = $user->select()->where('email','=',$email)
                                   ->where('confirmation_token','=',$confirm_token)->get();
        if(count($the_user)>0){
            $account_status= 'confirmed';
        /**
        * Update the account status to confirmed.
        * 
        */   
        $user->where('email','=',$email)
             ->where('confirmation_token','=',$confirm_token)
             ->update(['account_status'=>$account_status]);

        \Session::flash('message','Your account successfully confirmed.');

        return redirect()->route('login');
        }else {
     
            \Session::flash('error_message',' Confirmation failed.  ');
             return redirect()->route('login');
        }
    }

    
    /**
    * The home function for the home route
    */    
    public function home()
    {
      return view('users.home');
    }
}
