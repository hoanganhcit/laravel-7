<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'quantity',
        'short_description',
        'price',
        'discount',
        'discount_price',
        'date_discount_period',
        'is_variation',
        'low_stock_to_notify',
        'status',
        'description',
        'photo',
        'featured_product',
        'new_arrival',
        'on_sale',
        'viewed',
        'sold',
        'brand_id',
        'meta_title',
        'meta_description',
        'display_order',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class);
    }

    public function galleries()
    {
        return $this->hasMany(GalleryProduct::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(Variation::class);
    }

    public function variationDefault()
    {
        if (!empty($this->variations)) {
            return $this->variations->where('is_default', 1)->first();
        }
        return null;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
