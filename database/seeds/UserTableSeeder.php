<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        User::create([
        	'name'=>'ramy',
        	'email'=>'ramy711@yahoo.com',
        	'password'=> bcrypt('ramy')
        	]);
    }
}
