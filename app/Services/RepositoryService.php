<?php

namespace App\Services;

use App\Models\User;
use App\Repository\RepositoryRepositoryInterface;
use App\Services\Github\GithubServiceInterface;
use Illuminate\Support\Facades\Cache;

class RepositoryService
{
    private GithubServiceInterface $github;
    private RepositoryRepositoryInterface $repositories;
    private ?User $user;

    public function __construct(GithubServiceInterface $github, RepositoryRepositoryInterface $repositories)
    {
        $this->github = $github;
        $this->repositories = $repositories;
        $this->user = auth('api')->user();
    }

    public function index(array $pagination = [], array $filters = [])
    {
        if (!Cache::has($this->getCacheKey())) {
            $this->sync();
        }

        $filters['user_id'] = $this->user->id;

        return $this->repositories->get($pagination, $filters);
    }

    private function getCacheKey()
    {
        return strtolower($this->user->id).'_repositories';
    }

    private function sync()
    {
        $page = 1;
        do {
            $results = $this->github->repositories()->starred($this->user->username, $page);

            if ($results === null) {
                break;
            }

            $this->insert($results);
            $page++;
        } while (!empty($results));

        Cache::put($this->getCacheKey(), true, 3600);
    }

    private function insert(array $items)
    {
        foreach ($items as $item) {
            $attributes = [
                'source_id' => $item['id'],
                'user_id' => $this->user->id,
                'name' => $item['name'],
                'language' => $item['language'],
                'url' => $item['html_url'],
                'description' => $item['description'],
            ];

            $this->repositories->create($attributes);
        }
    }
}
