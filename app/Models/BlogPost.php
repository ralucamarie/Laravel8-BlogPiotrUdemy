<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\DeletedAdminScope;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class BlogPost extends Model
{
    protected $fillable=['title','content','user_id'];
    
    use HasFactory;
    use SoftDeletes, Taggable;
    

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }



    public function user()
    {
       return $this->belongsTo('App\Models\User'); 
    }

    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }
    
    public function scopeLatestWithRelations(Builder $query){
        return $query->latest()
            ->withCount('comments')
            ->with('user')
            ->with('tags');
            
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image','imageable');
    }
    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();
        
        // static::addGlobalScope(new LatestScope);
    }
}
