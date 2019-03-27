<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*`role_id`, `name`, `user_name`, `email`, `email_verified_at`, `password`, `image`, `about`,*/
        DB::table('users')->insert([
        	'role_id'=>'1',
        	'name'=>'MD. Admin',
        	'user_name'=>'admin',
        	'email'=>'admin@gmail.com',
        	'password'=>bcrypt('123456'),

        ]);

        DB::table('users')->insert([
        	'role_id'=>'2',
        	'name'=>'MD. Author',
        	'user_name'=>'author',
        	'email'=>'author@gmail.com',
        	'password'=>bcrypt('123456'),

        ]);
    }
}
