<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;
 
    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
    }

    public function testSeeOneBlogPostWhenThereIsOneNoComments()
    {
        //Arrange
        $post=$this->createDummyBlogPost();
        
        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('Test Title');
        $response->assertSeeText('No comments yet!');
        $this->assertDatabaseHas('blog_posts', [
            'title'=>'Test Title'
        ]);
    }


    public function testStoreValid()
        {
            $user=$this->user();
            

            $params = [
                'title' => 'Valid Title',
                'content'=> 'This is a valid content to add.'
            ];

            $this->actingAs($user)
            ->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('status');
            
            $this->assertEquals(session('status'), 'The blog post was created!');

        }

        public function testStoreFail()
        {
            $user=$this->user();
            $params = [
                'title' => 'X',
                'content'=> 'X'
            ];

            $this->actingAs($user)
            ->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
            
            $messages= session('errors')->getMessages();
            $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
            $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
        }


        public function testUpdateValid()
        {
            $user=$this->user();
            //Arrange
            $post=$this->createDummyBlogPost($user->id);

            $this->assertDatabaseHas('blog_posts', [
                'title' => 'Test Title',
                'content' => 'Test Content from the test env.'
            ]);

            $params = [
                'title' => 'A new name for the title',
                'content'=> 'A new content for the new post added earlier.'
            ];

            $this->actingAs($user)
                ->put("/posts/{$post->id}",$params)
                ->assertStatus(302)
                ->assertSessionHas('status');

            $this->assertEquals(session('status'), 'Blog post was updated!');
            
            $this->assertDatabaseMissing('blog_posts', [
                'title' => 'Test Title',
                'content' => 'Test Content from the test env.'
            ]);

            $this->assertDatabaseHas('blog_posts', [
                'title' => 'A new name for the title',
                'content' => 'A new content for the new post added earlier.'
            ]);
        }


        public function testDelete()
        {
            $user=$this->user();
            $post=$this->createDummyBlogPost($user->id);

            $this->assertDatabaseHas('blog_posts', [
                'title' => 'Test Title',
                'content' => 'Test Content from the test env.'
            ]);

            $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

            $this->assertEquals(session('status'), 'Blog Post was deleted!');

            // $this->assertDatabaseMissing('blog_posts', [
            //     'title' => 'Test Title',
            //     'content' => 'Test Content from the test env.'
            // ]);
            $this->assertSoftDeleted('blog_posts', [
                'title' => 'Test Title',
                'content' => 'Test Content from the test env.'
            ]);

        }


    private function createDummyBlogPost($userId=null):BlogPost
    {
        // $post=new BlogPost();
        // $post->title='Test Title';
        // $post->content='Test Content from the test env.';

        $post=BlogPost::factory()->dummy()->create(
            [
                'user_id'=>$userId ?? $this->user()->id,
            ]);

        // $post->save();

        return $post;
    }

public function testSeeBlogPostWithComments()
{
    $user=$this->user();
    $post=$this->createDummyBlogPost();
    Comment::factory()->count(4)->create([
        'commentable_id'=>$post->id,
        'commentable_type'=>'App\Models\BlogPost',
        'user_id'=>$user->id
    ]);
        
    // factory(Comment::class,4)->create([
    //     'blog_post_id'=>$post->id
    // ]);

    $response = $this->get('/posts');
    $response->assertSeeText('4 comments');

}


}
