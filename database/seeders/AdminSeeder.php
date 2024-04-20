<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([

            'uuid'    => Str::uuid(),
            'name'    => 'Admin',
            'username'    => 'Admin1',
            'email'         => 'admin@gmail.com',
            'phone'         => '01711000000',
            'password'      =>  Hash::make('123456'),
            'is_mail_verified' => ENABLE,
            'role'          => ADMIN,
            'status'        => ACTIVE

        ]);
    }
}
