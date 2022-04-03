<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Taggable;


class Comment extends Model
{
    use SoftDeletes, Taggable;
    use HasFactory;
    
    protected $fillable=['user_id', 'content'];
    
    //blog.post_id - this is the name that Laravel will search for in teh migration, based on the name we add to the folllowing method:
    public function commentable(){
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    
    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

     public static function boot()
    {
        parent::boot();
        
        // static::addGlobalScope(new LatestScope);
    }

    
}
