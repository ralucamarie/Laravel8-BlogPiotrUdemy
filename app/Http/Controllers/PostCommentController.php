<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPostMarkdown;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function store(BlogPost $post, StoreComment $request){
        $comment=$post->comments()->create([
            'content'=>$request->input('content'),
            'user_id'=>$request->user()->id
        ]);

        // Mail::to($post->user)->send(
        //     new CommentPostMarkdown($comment)
        // );

        // Mail::to($post->user)->queue(
        //     new CommentPostMarkdown($comment)
        // );

        event(new CommentPosted ($comment));

        return redirect()->back()
        ->withStatus('Comment was created');
    }
}
