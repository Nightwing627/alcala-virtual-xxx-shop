<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
        	"email"=>"admin@sustam.com",
        	"password"=>Hash::make("sustam2021?"),
        	"name"=>"Admin Sustam",
        	"access"=>1
        ]);

        $user=User::where('email','admin@sustam.com')->first();
        $user->assignRole('administrador');

    }
}
