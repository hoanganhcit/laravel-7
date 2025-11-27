<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    public $table = 'banners';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'photo',
        'sub_title',
        'title',
        'description',
        'product_categories_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
