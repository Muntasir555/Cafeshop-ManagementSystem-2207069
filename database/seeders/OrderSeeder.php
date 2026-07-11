<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Alice Johnson',   'email' => 'alice@example.com'],
            ['name' => 'Bob Martinez',    'email' => 'bob@example.com'],
            ['name' => 'Clara Lee',       'email' => 'clara@example.com'],
            ['name' => 'David Kim',       'email' => 'david@example.com'],
            ['name' => 'Emma Thompson',   'email' => 'emma@example.com'],
            ['name' => 'Frank Wilson',    'email' => 'frank@example.com'],
            ['name' => 'Grace Chen',      'email' => 'grace@example.com'],
            ['name' => 'Henry Brown',     'email' => 'henry@example.com'],
        ];

        $menuItems = [
            ['name' => 'Iced Caramel Macchiato',  'price' => 5.75],
            ['name' => 'Sweet Cream Cold Brew',    'price' => 5.95],
            ['name' => 'Caramel Frappuccino',      'price' => 6.25],
            ['name' => 'Chai Tea Latte',            'price' => 5.25],
            ['name' => 'Butter Croissant',          'price' => 3.50],
            ['name' => 'Flat White',                'price' => 5.00],
            ['name' => 'Chocolate Muffin',          'price' => 3.75],
            ['name' => 'Iced Matcha Latte',         'price' => 5.45],
            ['name' => 'Protein Box',               'price' => 7.95],
            ['name' => 'Mocha Frappuccino',          'price' => 6.25],
        ];

        $statuses = ['pending', 'preparing', 'ready', 'completed', 'completed', 'completed', 'cancelled'];

        for ($i = 0; $i < 25; $i++) {
            $customer = $customers[array_rand($customers)];

            // Pick 1-4 random items
            $count     = rand(1, 4);
            $picked    = array_rand($menuItems, min($count, count($menuItems)));
            if (!is_array($picked)) $picked = [$picked];

            $items = collect($picked)->map(fn ($k) => [
                'name'  => $menuItems[$k]['name'],
                'price' => $menuItems[$k]['price'],
                'qty'   => rand(1, 2),
            ])->values()->toArray();

            $total = collect($items)->sum(fn ($item) => $item['price'] * $item['qty']);

            Order::create([
                'customer_name'  => $customer['name'],
                'customer_email' => $customer['email'],
                'items'          => $items,
                'total'          => round($total, 2),
                'status'         => $statuses[array_rand($statuses)],
                'notes'          => rand(0, 1) ? 'Extra ice please.' : null,
                'created_at'     => Carbon::now()->subDays(rand(0, 6))->subHours(rand(0, 23)),
            ]);
        }
    }
}
