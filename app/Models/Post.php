<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];
    protected $appends = ['images'];

    public function getImagesAttribute():array
    {
        return [
            'images' => DB::table('post_images')->where('post_id', '=', $this->attributes['id'])->get()
        ];
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
