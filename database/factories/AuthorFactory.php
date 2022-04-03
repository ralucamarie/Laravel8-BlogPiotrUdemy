<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Author;
use App\Models\Profile;

class AuthorFactory extends Factory
{
    protected $model = Author::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function configureAfterCreating()
    {
        return $this ->afterCreating(function (Author $author) {
            $author->profile()->save(Profile::factory()->make());
        });
    }

    
}
