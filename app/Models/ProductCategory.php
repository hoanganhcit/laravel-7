<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    public $table = 'product_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'photo',
        'category_parent',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function childs() {
        return $this->hasMany(ProductCategory::class, 'category_parent', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}