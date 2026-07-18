<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'BrewHaven Times Square',
                'address' => '1535 Broadway',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10036',
                'latitude' => 40.7580,
                'longitude' => -73.9855,
                'hours' => '6:00 AM - 10:00 PM',
                'phone' => '(212) 555-0101'
            ],
            [
                'name' => 'BrewHaven Central Park',
                'address' => 'Central Park South',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10019',
                'latitude' => 40.7656,
                'longitude' => -73.9774,
                'hours' => '7:00 AM - 8:00 PM',
                'phone' => '(212) 555-0102'
            ],
            [
                'name' => 'BrewHaven Brooklyn',
                'address' => '123 Bedford Ave',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'zip' => '11211',
                'latitude' => 40.7203,
                'longitude' => -73.9557,
                'hours' => '6:30 AM - 9:00 PM',
                'phone' => '(718) 555-0103'
            ],
        ];

        foreach ($stores as $store) {
            \App\Models\Store::create($store);
        }
    }
}
