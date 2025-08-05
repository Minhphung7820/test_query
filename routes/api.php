<?php
use Illuminate\Support\Collection;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
Route::get('/orders', function () {
    $startMemory = memory_get_usage(true);
    $startTime = microtime(true);

    $orders = Order::limit(10)->get();

    $orders = $orders->withChildrenPerParent(
        childQuery: OrderItem::query(),
        matchColumns: [['id', '=', 'order_id'], ['location_id', '=', 'location_id']],
        relationName: 'items',
        limit: 10
    );

    $endMemory = memory_get_usage(true);
    $endTime = microtime(true);

    return response()->json([
        'orders' => $orders,
        'debug' => [
            'memory_used_mb' => round(($endMemory - $startMemory) / 1024 / 1024, 2),
            'execution_time_ms' => round(($endTime - $startTime) * 1000, 2)
        ]
    ]);
});
