<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'location_id', 'product'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
