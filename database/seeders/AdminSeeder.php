<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah user admin sudah ada biar tidak duplikat
        $cek = DB::table('users')->where('email', 'admin@imigrasi.go.id')->first();

        if(!$cek) {
            DB::table('users')->insert([
                'name' => 'Admin Imigrasi',
                'email' => 'admin@imigrasi.go.id',
                'password' => Hash::make('admin123'), // Password di-enkripsi
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}