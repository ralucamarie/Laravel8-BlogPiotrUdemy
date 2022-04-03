<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Tag;


class PostTagController extends Controller
{
    public function index($tag)
{
    $tag=Tag::findOrfail($tag);

    return view('posts.index',[
        'posts'=> $tag->blogPosts()
            ->latestWithRelations()
            ->get(),
        ]);
}
}
