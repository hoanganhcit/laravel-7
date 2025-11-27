<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    public $table = 'customers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'provider',
        'provider_id',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orders_customer()
    {
        return $this->hasMany(OrderCustomer::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}
