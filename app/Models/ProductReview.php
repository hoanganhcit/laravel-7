<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use SoftDeletes;

    public $table = 'product_reviews';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'rate',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}