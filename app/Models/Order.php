<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;
use App\Models\Item;
class Order extends Model
{   
    use HasFactory;
    public function orderItem()
    {
        return $this->hasMany(ItemOrder::class);
    }

    public function test()
    {
        return $this->orderItem->hasMany(Item::class);
    }

}
