<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(BlogPost::all()->count()===0 || User::all()->count()===0){
            $this->command->info('There are no blog posts, so no comments will be added');
            return;
        }

        $commentCount=max((int)$this->command->ask('How many comments to add:',50),1);

        Comment::factory()->count($commentCount)->make()
            ->each(function ($comment){
                $comment->commentable_id = BlogPost::all()->random()->id;
                $comment->commentable_type='App\Models\BlogPost';
                $comment->user_id = User::all()->random()->id;
                $comment->save();
        });
        Comment::factory()->count($commentCount)->make()
            ->each(function ($comment){
                $comment->commentable_id = User::all()->random()->id;
                $comment->commentable_type='App\Models\User';
                $comment->user_id = User::all()->random()->id;
                $comment->save();
        });
    }
}
