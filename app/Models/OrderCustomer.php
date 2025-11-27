<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCustomer extends Model
{
    use SoftDeletes;

    public $table = 'order_customers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'phone',
        'address',
        'note',
        'order_id',
        'customer_id',
        'city_id',
        'province_id',
        'ward_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'ward_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}
