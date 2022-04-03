<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostsWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        dd('I was called in resp to event.');
        ThrottledMail::dispatch(new CommentPostMarkdown ($event->comment), $event->comment->commentable->user)
        ->onQueue('low');
        NotifyUsersPostsWasCommented::dispatch($event->comment)
        ->onQueue('high');

    }
}
