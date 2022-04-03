<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

       public function blogPosts()
    {
        return $this->morphedByMany('App\Models\BlogPost','taggable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphedByMany('App\Models\Comment','taggable')->withTimestamps();
    }
}
