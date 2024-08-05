<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@email.com',
            'matricule'=> Str::random(10),
            'password' =>  bcrypt('super'),
            'created_at' => now(),
            'updated_at' => now(),
            'type' => 'super',
            'status' => '1',
        ]);
        #Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'matricule'=> Str::random(10),
            'password' =>  bcrypt('admin'),
            'created_at' => now(),
            'updated_at' => now(),
            'type' => 'admin',
            'status' => '1',
        ]);
        #User
        User::create([
            'name' => 'User',
            'email' => 'user@email.com',
            'matricule'=> Str::random(10),
            'email_verified_at' => now(),
            'password' =>  bcrypt('user'),
            'created_at' => now(),
            'updated_at' => now(),
            'type' => 'user',
            'status' => '1',
        ]);
    }
}