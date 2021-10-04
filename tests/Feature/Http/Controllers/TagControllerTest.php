<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_index_with_pagination_is_success(): void
    {
        Tag::factory()->count(20)->create();

        /** @var User $user */
        $user = User::factory()->create();

        $data = [
            'page' => 1,
            'per_page' => 10,
        ];

        $response = $this->actingAs($user)->json('GET', '/api/tags', $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }

    public function test_assign_with_valid_input_is_success()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Repository $repository */
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $data = [
            'repository_id' => $repository->id,
            'name' => 'docker',
        ];

        $response = $this->actingAs($user)->postJson('/api/tags/assign', $data);

        $exists = $repository->tags()->where('tag_id', $response->json('data.id'))->exists();

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'name' => 'docker',
            ]
        ]);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);

        $this->assertTrue($exists, 'Record not exists in database');
    }

    public function test_remove_with_valid_input_is_success()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Repository $repository */
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        /** @var Tag $tag */
        $tag = Tag::factory()->create(['name' => 'docker']);

        $repository->tags()->attach($tag->id);

        $data = [
            'repository_id' => $repository->id,
            'name' => 'docker',
        ];

        $response = $this->actingAs($user)->deleteJson('/api/tags/remove', $data);

        $exists = $repository->tags()->where('tag_id', $tag->id)->exists();

        $response->assertOk();
        $this->assertFalse($exists, 'Record exists in database and not removed');
    }
}
