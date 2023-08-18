<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks!
        Schema::disableForeignKeyConstraints();
        User::truncate();

        User::create([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
        ]);

        // Enable foreign key checks!
        Schema::enableForeignKeyConstraints();
    }
}
