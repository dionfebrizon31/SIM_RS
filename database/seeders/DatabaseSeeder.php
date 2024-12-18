<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('jabatans')->insert([
            'id' => '0',
            'divisi' =>'Tidak ada',
            'name' =>'Tidak ada',
        ]);
        DB::table('users')->insert([
            'name' => 'Test User',
            'slugname' => Str::slug('Test User'),
            'email' => 'tests@gmail.com',
            'username' => '123',
            'role' => 'admins',
            'nohp' => '123',
            'password' => Hash::make('123'),
            'jabatans_id' => '0'
        ]);
        DB::table('users')->insert([
            'name' => 'Staff 1',
            'slugname' => Str::slug('Staff 1'),
            'email' => 'Staff@gmail.com',
            'username' => 'staf1',
            'role' => 'staff',
            'nohp' => 'staf1',
            'password' => Hash::make('staf1'),
            'jabatans_id' => '0'
        ]);
        DB::table('users')->insert([
            'name' => 'Staff 2',
            'slugname' => Str::slug('Staff 2'),
            'email' => 'Staff2@gmail.com',
            'username' => 'staf2',
            'role' => 'staff',
            'nohp' => 'staf2',
            'password' => Hash::make('staf2'),
            'jabatans_id' => '0'
        ]);
        DB::table('users')->insert([
            'name' => 'Manager',
            'slugname' => Str::slug('Manager'),
            'email' => 'manager@gmail.com',
            'username' => '1',
            'role' => 'manager',
            'nohp' => '123',
            'password' => Hash::make('1'),
            'jabatans_id' => '0'
        ]);
        DB::table('visitors')->insert([
            'name' => 'Test User',
            'email' => 'tests@gmail.com',
            'username' => '321',
            'role' => 'users',
            'nomorhp' => '321',
            'password' => Hash::make('321'),

        ]);
    }
}
