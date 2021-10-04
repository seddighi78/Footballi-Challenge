<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_index_with_pagination_is_success(): void
    {
        /** @var User $user */
        $user = User::factory()->real()->create();

        $data = [
            'page' => 1,
            'per_page' => 10,
        ];

        $response = $this->actingAs($user)->json('GET', '/api/repositories', $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'language',
                ]
            ]
        ]);
    }

    public function test_index_with_filters_is_success(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Repository::factory()->count(10)->create(['user_id' => $user->id]);

        /** @var Repository[] $repositories */
        $repositories = Repository::factory()->count(2)->create(['user_id' => $user->id]);

        /** @var Tag[] $tags */
        $tags = [
            Tag::factory()->create(['name' => 'docker']),
            Tag::factory()->create(['name' => 'ex_doc']),
        ];

        $repositories[0]->tags()->attach($tags[0]->id);
        $repositories[1]->tags()->attach($tags[1]->id);

        $data = [
            'tag' => 'doc',
        ];

        $response = $this->actingAs($user)->json('GET', '/api/repositories', $data);

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'language',
                ]
            ]
        ]);
    }

    public function test_show_with_valid_input_is_success(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Repository $repository */
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->json('GET', "/api/repositories/{$repository->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'source_id',
                'name',
                'language',
                'url',
                'description',
            ]
        ]);
    }
}
