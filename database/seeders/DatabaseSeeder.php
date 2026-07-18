<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@brewhaven.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);

        // Sample customers
        User::factory()->create(['name' => 'Alice Johnson',  'email' => 'alice@example.com',  'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Bob Martinez',   'email' => 'bob@example.com',    'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Clara Lee',      'email' => 'clara@example.com',  'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'David Kim',      'email' => 'david@example.com',  'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Emma Thompson',  'email' => 'emma@example.com',   'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Frank Wilson',   'email' => 'frank@example.com',  'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Grace Chen',     'email' => 'grace@example.com',  'role' => 'customer', 'status' => 'approved']);
        User::factory()->create(['name' => 'Henry Brown',    'email' => 'henry@example.com',  'role' => 'customer', 'status' => 'approved']);

        // Seed products, orders, stores, and staff
        $this->call([
            ProductSeeder::class,
            OrderSeeder::class,
            StoreSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
