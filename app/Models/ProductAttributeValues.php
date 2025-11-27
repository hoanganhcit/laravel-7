<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValues extends Model
{
    use SoftDeletes;

    public $table = 'product_attribute_values';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'product_attribute_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}