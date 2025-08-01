<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $ordersData = [];
            $itemsData = [];
            $now = now()->toDateTimeString();

            for ($i = 1; $i <= 1000; $i++) {
                $locationId = rand(1, 5); // giả sử có 5 kho

                $ordersData[] = [
                    'code' => 'ORD' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'location_id' => $locationId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // tạo item cho đơn này (5–15 items)
                $itemCount = rand(5, 15);
                for ($j = 1; $j <= $itemCount; $j++) {
                    $itemsData[] = [
                        'order_id' => $i,
                        'location_id' => rand(1, 5), // deliberately mixed for test
                        'product' => 'Product ' . Str::random(5),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            // batch insert
            Order::insert($ordersData);
            OrderItem::insert($itemsData);

            echo "Seeded 1000 orders and ~" . count($itemsData) . " items.\n";
        });
    }
}
