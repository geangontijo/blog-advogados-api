<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['address', 'post_id'];
    protected $table = 'post_images';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
