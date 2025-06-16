<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_profiles')->insert([
            'name' => 'Tobapos Toko Bako',
            'address' => 'Jl. Raya Ciomas No. 123, Bogor',
            'home_description' => 'Selamat datang di Tobapos, toko tembakau terpercaya sejak 2023.',
            'about_description' => 'Tobapos hadir sebagai solusi lengkap untuk pecinta tembakau dengan berbagai produk berkualitas dan pelayanan terbaik.',
            'img_home' => 'company_profile/default_home.jpg', // bisa kamu ganti sesuai path file default
            'img_description' => 'company_profile/default_description.jpg',
            'phone' => '081234567890',
            'email' => 'tobapos@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
