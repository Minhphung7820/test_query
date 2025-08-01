<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['code', 'location_id'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
