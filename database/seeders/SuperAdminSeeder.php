<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $exists = User::where('super_admin', true)->exists();

        if ($exists) {
            return;
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@buildsight.com',
            'password' => Hash::make('123456'),
            'super_admin' => true,
        ]);
    }
}
