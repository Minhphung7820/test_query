<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;
class DatabaseSeeder extends Seeder
{
    /**d
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OrderItemSeeder::class);
    }
}
