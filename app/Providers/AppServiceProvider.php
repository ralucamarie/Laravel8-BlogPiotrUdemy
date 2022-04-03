<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Observers\BlogPostObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Observers\CommentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('package-badge', Badge::class);   
        Blade::aliasComponent('components.updated', 'updated');  
        Blade::component('package-card', Card::class);  
        Blade::aliasComponent('components.tags', 'tags');  
        Blade::aliasComponent('components.errors', 'errors');  
        Blade::aliasComponent('components.comment-form','commentForm');
        Blade::aliasComponent('components.comments-list','commentsList');

        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
   
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

    }
}
