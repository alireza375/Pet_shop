<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Setting::create([
            'title' => 'Pet Shop',
            'logo' => "https://appstick.s3.ap-southeast-1.amazonaws.com/one-ride-storage/files/a0QPNfneE6PFUT6p5h9ot7fBcSKBU4CrdNd7mOKa.jpg",
            'description' => 'Pet Shop Description',
            'email' => 'petshop@appstick.com.bd',
            'phone' => '+880 123 456 123',
            'address' => 'khulna, Bangladesh'
         ]);
    }
}
