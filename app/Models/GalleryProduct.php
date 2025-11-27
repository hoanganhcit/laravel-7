<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryProduct extends Model
{
    use SoftDeletes;

    public $table = 'gallery_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'galleries',
        'product_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}