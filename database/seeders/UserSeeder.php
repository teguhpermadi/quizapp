<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function ($user) {
            $role = [
                'admin',
                'teacher',
                'student'
            ][array_rand([0, 1, 2])];

            $user->assignRole($role);
        });
    }
}
