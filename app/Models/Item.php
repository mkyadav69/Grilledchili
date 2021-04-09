<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;
class Item extends Model
{
    use HasFactory;
    public function order_item()
    {
        return $this->hasMany(ItemOrder::class);

    }
}
