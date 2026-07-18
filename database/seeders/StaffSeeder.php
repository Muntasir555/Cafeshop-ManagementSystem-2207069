<?php

namespace Database\Seeders;

use App\Models\SalaryPayment;
use App\Models\Staff;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::pluck('id', 'name');

        $timesSquare  = $stores->first(fn($v, $k) => str_contains($k, 'Times Square'));
        $centralPark  = $stores->first(fn($v, $k) => str_contains($k, 'Central Park'));
        $brooklyn     = $stores->first(fn($v, $k) => str_contains($k, 'Brooklyn'));

        $staff = [
            [
                'store_id'       => $timesSquare,
                'name'           => 'James Rivera',
                'email'          => 'james.rivera@brewhaven.com',
                'phone'          => '(212) 555-1001',
                'role'           => 'manager',
                'shift'          => 'full_day',
                'monthly_salary' => 3200.00,
                'join_date'      => '2023-03-01',
                'status'         => 'active',
                'notes'          => 'Senior manager overseeing Times Square flagship.',
            ],
            [
                'store_id'       => $centralPark,
                'name'           => 'Priya Nair',
                'email'          => 'priya.nair@brewhaven.com',
                'phone'          => '(212) 555-1002',
                'role'           => 'supervisor',
                'shift'          => 'morning',
                'monthly_salary' => 2600.00,
                'join_date'      => '2023-06-15',
                'status'         => 'active',
                'notes'          => null,
            ],
            [
                'store_id'       => $timesSquare,
                'name'           => 'Carlos Gomez',
                'email'          => 'carlos.gomez@brewhaven.com',
                'phone'          => '(212) 555-1003',
                'role'           => 'barista',
                'shift'          => 'morning',
                'monthly_salary' => 1800.00,
                'join_date'      => '2024-01-10',
                'status'         => 'active',
                'notes'          => null,
            ],
            [
                'store_id'       => $brooklyn,
                'name'           => 'Mei Lin',
                'email'          => 'mei.lin@brewhaven.com',
                'phone'          => '(718) 555-1004',
                'role'           => 'barista',
                'shift'          => 'afternoon',
                'monthly_salary' => 1800.00,
                'join_date'      => '2024-02-20',
                'status'         => 'active',
                'notes'          => null,
            ],
            [
                'store_id'       => $centralPark,
                'name'           => 'Aisha Okafor',
                'email'          => 'aisha.okafor@brewhaven.com',
                'phone'          => '(212) 555-1005',
                'role'           => 'cashier',
                'shift'          => 'morning',
                'monthly_salary' => 1650.00,
                'join_date'      => '2024-03-05',
                'status'         => 'active',
                'notes'          => null,
            ],
            [
                'store_id'       => $brooklyn,
                'name'           => 'Tom Kowalski',
                'email'          => 'tom.kowalski@brewhaven.com',
                'phone'          => '(718) 555-1006',
                'role'           => 'cashier',
                'shift'          => 'evening',
                'monthly_salary' => 1650.00,
                'join_date'      => '2024-04-12',
                'status'         => 'on_leave',
                'notes'          => 'Currently on medical leave.',
            ],
            [
                'store_id'       => $timesSquare,
                'name'           => 'Daniela Cruz',
                'email'          => 'daniela.cruz@brewhaven.com',
                'phone'          => '(212) 555-1007',
                'role'           => 'cleaner',
                'shift'          => 'morning',
                'monthly_salary' => 1400.00,
                'join_date'      => '2024-05-01',
                'status'         => 'active',
                'notes'          => null,
            ],
            [
                'store_id'       => $brooklyn,
                'name'           => 'Ben Harrington',
                'email'          => 'ben.harrington@brewhaven.com',
                'phone'          => '(718) 555-1008',
                'role'           => 'barista',
                'shift'          => 'evening',
                'monthly_salary' => 1800.00,
                'join_date'      => '2024-06-18',
                'status'         => 'active',
                'notes'          => null,
            ],
        ];

        foreach ($staff as $data) {
            Staff::create($data);
        }

        // ── Seed salary payments ────────────────────────────────────────────
        // Pay everyone for the previous month
        $prevMonth = now()->subMonth()->format('Y-m');
        $currMonth = now()->format('Y-m');

        $allActive = Staff::where('status', 'active')->get();

        // Previous month — all active staff paid
        foreach ($allActive as $member) {
            SalaryPayment::create([
                'staff_id'       => $member->id,
                'amount'         => $member->monthly_salary,
                'payment_month'  => $prevMonth,
                'payment_date'   => now()->subMonth()->endOfMonth()->toDateString(),
                'payment_method' => 'bank_transfer',
                'note'           => null,
                'paid_by'        => 'Admin',
            ]);
        }

        // Current month — only pay SOME staff (leaving 3 pending to demo the feature)
        $paidThisMonth = $allActive->take(4); // first 4 get paid, rest show as pending
        foreach ($paidThisMonth as $member) {
            SalaryPayment::create([
                'staff_id'       => $member->id,
                'amount'         => $member->monthly_salary,
                'payment_month'  => $currMonth,
                'payment_date'   => now()->toDateString(),
                'payment_method' => 'bank_transfer',
                'note'           => null,
                'paid_by'        => 'Admin',
            ]);
        }
    }
}
