<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Item;
class ItemOrder extends Model
{

    protected $table="item_order";
    use HasFactory;

    public function order(){
        return $this->belongsTo(Order::class);

    }
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
