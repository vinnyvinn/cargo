<?php

use App\Mail\UserCreated;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@esl.com',
            'password' => '!!Qwerty123!!'
        ]);

//        Mail::to(['email'=>'marvincollins14@gmail.com'])
//            ->cc(['evans@esl-eastafrica.com'])
//            ->send(new UserCreated(['name'=>$user->name,
//                'password'=>$user->password,
//                'email'=>$user->email]));

        $user->roles()->attach(1);
    }
}
