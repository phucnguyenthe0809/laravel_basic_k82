<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='order';
    public function product_order()
    {
        return $this->hasMany('App\Models\ProductOrder', 'order_id', 'id');
    }
}
