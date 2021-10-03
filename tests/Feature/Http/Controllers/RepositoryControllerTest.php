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

    private const VALID_USERNAME = 'seddighi78';

    public function test_index_with_pagination_is_success(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['username' => self::VALID_USERNAME]);

        $data = [
            'page' => 1,
            'per_page' => 10,
        ];

        $response = $this->actingAs($user)->getJson('/api/repositories', $data);

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
        $user = User::factory()->create(['username' => self::VALID_USERNAME]);

        /** @var Repository $repository */
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $tags = [
            Tag::factory()->create(['name' => 'docker'])->id,
            Tag::factory()->create(['name' => 'ex_doc'])->id,
        ];

        $repository->tags()->attach($tags);

        $data = [
            'tag' => 'doc'
        ];

        $response = $this->actingAs($user)->getJson('/api/repositories', $data);

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
}
