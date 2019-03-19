<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        $data = [
            [
                'name'=>'Admin',
                'slug'=>'admin',
                'permissions'=>json_encode([
                    'manage-user'=>true,
                    'admin'=>true,
                    'manage-roles'=>true
                ]),
                'created_at'=>$now,
                'updated_at'=>$now
            ],
            [
                'name'=>'Manager',
                'slug'=>'manager',
                'permissions'=>json_encode([
                    'manager'=>true,
                ]),
                'created_at'=>$now,
                'updated_at'=>$now
            ]
        ];

        \App\Role::insert($data);
    }
}
