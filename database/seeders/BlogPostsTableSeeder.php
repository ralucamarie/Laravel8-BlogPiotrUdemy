<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $postCount=max((int)$this->command->ask('How many posts to add:',20),1);

        BlogPost::factory()->count($postCount)->make()
            ->each(function ($post){
                $post->user_id = User::all()->random()->id;
                $post->save();
        });
    }
}
