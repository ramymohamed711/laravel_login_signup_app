<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','surname' , 'email', 'password','gender','user_type','confirmation_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token','confirmation_token'
    ];


    /**
    * Login validation rules 
    * validate that email is already exists 
    * validation not empty fields 
    */
    public static $login_validation_rules = [
      'email' => 'required|email|exists:users',
      'password' => 'required',
      'user_type' =>'in:orchestra,musician,member'
    ];


    /**
    * Create user validation rules
    * validate the required fields 
    * validate the entered email is in a correct format 
    * validate password length and it's confirmation
    */
     public static $create_validation_rules = [
      'firstname' => 'required|regex:/(^[A-Za-z]+$)+/',
      'surname' => 'required|regex:/(^[A-Za-z]+$)+/',
      'email' => 'required|email',
      'user_type' =>'in:orchestra,musician,member',
      'gender' => 'in:1,2',
      'password' => 'required|min:6|confirmed',
    ];

    /**
    * forgot password validation rules
    * validate the requeted email that is not empty , already exist 
    * and in a correct format
    */
    public static $forgotpassword_rules = [
    'email' => 'required|email|exists:users'
    ];

    /**
    * reset password validation rules 
    * validate the requested password length and it's confirmation
    */
    public static $resetpassword_rules = [
    'password' => 'required|min:6|confirmed',
    ];


}
