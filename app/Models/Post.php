<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public $table = 'posts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'photo',
        'is_feature',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(){
        return $this->hasMany(PostComment::class)->whereNull('parent_id')->where('status',1)->orderBy('id','DESC');
    }
    public function allComments(){
        return $this->hasMany(PostComment::class)->where('status',1);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}