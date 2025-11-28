<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed admin user only for tutorial video
     */
    public function run(): void
    {
        // Create admin user only
        User::updateOrCreate(
            ['email' => 'admin@banyukambang.desa.id'],
            [
                'name' => 'Admin Desa Banyukambang',
                'email' => 'admin@banyukambang.desa.id',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );

        echo "✅ Admin user created successfully!\n";
        echo "📧 Email: admin@banyukambang.desa.id\n";
        echo "🔑 Password: admin123\n";
        echo "🎥 Ready for tutorial video!\n";
    }
}
