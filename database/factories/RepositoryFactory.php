<?php

namespace Database\Factories;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepositoryFactory extends Factory
{
    protected $model = Repository::class;

    public function definition()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $languages = ['php', 'c#', 'javascript', 'c', 'python', 'cpp', 'ruby', 'r'];

        return [
            'user_id' => $user->id ,
            'name' => $this->faker->name,
            'language' => $this->faker->randomElement($languages),
            'url' => $this->faker->url(),
            'description' => $this->faker->text(),
        ];
    }
}
