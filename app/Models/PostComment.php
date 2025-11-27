<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes;

    public $table = 'post_comments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'post_id',
        'name',
        'email',
        'message',
        'status',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    } 

    public function replies(){
        return $this->hasMany(PostComment::class,'parent_id')->where('status',1);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y');
    }
}
