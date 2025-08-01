<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $totalItems = 80000;
        $orders = range(1, 10);
        $now = now();

        $batchSize = 1000; // tránh insert quá lớn
        $insertData = [];

        for ($i = 1; $i <= $totalItems; $i++) {
            $insertData[] = [
                'order_id'    => $orders[array_rand($orders)],
                'location_id' => rand(1, 5),
                'product'     => 'Product ' . Str::random(5),
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            if ($i % $batchSize === 0) {
                DB::table('order_items')->insert($insertData);
                $insertData = [];
                echo "Inserted $i rows...\n";
            }
        }

        // Insert phần còn lại
        if (!empty($insertData)) {
            DB::table('order_items')->insert($insertData);
            echo "Inserted remaining " . count($insertData) . " rows.\n";
        }

        echo "Done inserting 80,000 order_items.\n";
    }
}
