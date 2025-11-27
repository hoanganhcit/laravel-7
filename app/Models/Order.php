<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'order_code',
        'total_product',
        'total_price',
        'delivery_status',
        'payment_status',
        'payment_method',
        'shipping_method',
        'fee_shipping',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function orderCustomer()
    {
        return $this->hasOne(OrderCustomer::class, 'order_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}
