<?php

namespace App\Services;

use App\Models\User;
use App\Repository\RepositoryRepositoryInterface;
use App\Services\Github\GithubServiceInterface;

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
        $this->sync();

        return $this->repositories->index($pagination, $filters);
    }

    private function sync()
    {
        $page = 1;
        do {
            $results = $this->github->repositories()->starred($this->user->username, $page);
            $this->insert($results);
            $page++;
        } while (!empty($results));
    }

    private function insert(array $items)
    {
        foreach ($items as $item) {
            $attributes = [
                'id' => $item['id'],
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
