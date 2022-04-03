<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BlogPost;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'title' => $this->faker->sentence(10),
           'content' => $this->faker->paragraphs(5,true)
        ];
    }

    public function dummy()
{
    return $this->state(function (array $attributes) {
        return [
            'title' => 'Test Title',
            'content' => 'Test Content from the test env.'
        ];
    });
}



}
