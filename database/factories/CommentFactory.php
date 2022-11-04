<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'          => 1,
            'commentable_type' => 'App\Models\Game',
            'commentable_id'   => $this->faker->numberBetween(1, 10),
            'body'             => $this->faker->paragraph(4),
            'is_verified'      => 1,
            'likes'            => $this->faker->numberBetween(3, 30),
            'dislikes'         => $this->faker->numberBetween(1, 15)
        ];
    }
}
