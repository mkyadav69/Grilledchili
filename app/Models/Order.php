<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;
class Order extends Model
{   
    use HasFactory;
    public function orderItem()
    {

        return $this->hasMany(ItemOrder::class);

    }
}
