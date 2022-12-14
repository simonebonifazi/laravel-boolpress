<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    protected $fillable = ['title','slug', 'image','content', 'is_published','category_id','user_id'];
}