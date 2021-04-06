<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;
class Item extends Model
{
    use HasFactory;
    public function itemData()
    {
        return $this->belongsTo(ItemOrder::class, 'item_id');

    }
}
