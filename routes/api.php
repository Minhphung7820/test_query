<?php
use Illuminate\Support\Collection;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
Route::get('/orders', function () {
    $startMemory = memory_get_usage(true); // RAM đầu
    $startTime = microtime(true);          // thời gian bắt đầu

    // --- LOGIC CHÍNH ---
    $orders = Order::limit(10)->get();
    $orderIds = $orders->pluck('id')->all();
    $items = OrderItem::whereIn('order_id', $orderIds)
    ->lazy()->each(function ($item) {
       Log::info($item);
    });
    dd(34);
    $orders->withChildren([
        ['id', '=', 'order_id'],
        ['location_id', '=', 'location_id']
    ], $items, 'id', 'order_id', 'items');

    // --- TÍNH TOÁN ---
    $endMemory = memory_get_usage(true);
    $endTime = microtime(true);

    $memoryUsed = round(($endMemory - $startMemory) / 1024 / 1024, 2); // MB
    $executionTime = round(($endTime - $startTime) * 1000, 2); // ms

    return response()->json([
        'orders' => $orders,
        'debug' => [
            'memory_used_mb' => $memoryUsed,
            'execution_time_ms' => $executionTime
        ]
    ]);
});
