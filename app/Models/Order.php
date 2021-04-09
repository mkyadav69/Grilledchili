<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;
use App\Models\Item;
use App\Models\Customer;
class Order extends Model
{   
    use HasFactory;
    public function orderItem()
    {
        return $this->hasMany(ItemOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function b()
    {
        return $this->hasMany(ItemOrder::class);
    }
}
