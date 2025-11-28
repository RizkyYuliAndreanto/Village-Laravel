<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; //
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Administrator Utama
        User::updateOrCreate(
            ['email' => 'admin@desa.id'], // Cek email agar tidak duplikat
            [
                'name' => 'Administrator Sistem',
                'password' => Hash::make('password'), // Password default: password
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Kepala Desa (Contoh User Tambahan)
        User::updateOrCreate(
            ['email' => 'kades@desa.id'],
            [
                'name' => 'Bapak Kepala Desa',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

         // 3. Akun Sekretaris Desa (Contoh User Tambahan)
         User::updateOrCreate(
            ['email' => 'sekdes@desa.id'],
            [
                'name' => 'Ibu Sekretaris Desa',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}