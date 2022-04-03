<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "created" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */

    public function deleting (BlogPost $blogPost){
        // dd('I am deleted');
        $blogPost->comments()->delete();
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }

    public function updating (BlogPost $blogPost){
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
    }

    public function restoring (BlogPost $blogPost){
        $blogPost->comments()->restore();
    }
    
}
