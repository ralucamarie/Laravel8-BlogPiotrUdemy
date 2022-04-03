<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserCommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//protecting the home index rout from unsigned users
Route::get('/',[HomeController::class,'home'])
    ->name('home.index')
    // ->middleware('auth')
    ;
Route::get('/contact',[HomeController::class,'contact'])->name('home.contact');
//controller with single function usin invoke:
Route::get('/secret',[HomeController::class,'secret'])
    ->name('secret')
    ->middleware('can:home.secret');
Route::get('/single', AboutController::class);



Route::resource('posts',PostsController::class);
//->only(['index','show', 'create', 'store','edit','update']);

Route::get('/posts/tag/{tag}', [PostTagController::class,'index'])->name('posts.tags.index');
Route::resource('posts.comments', PostCommentController::class)->only(['store']);

Route::resource('users', UserController::class)->only(['show','edit','update']);

Route::resource('users.comments', UserCommentController::class)->only(['store']);

Route::get('mailable', function(){
    $comment = App\Models\Comment::find(1);
    return new App\Mail\CommentPostMarkdown($comment);
});

Auth::routes();






