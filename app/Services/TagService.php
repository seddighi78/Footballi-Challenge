<?php

namespace App\Services;

use App\Repository\RepositoryRepositoryInterface;
use App\Repository\TagRepositoryInterface;

class TagService
{
    private TagRepositoryInterface $tags;
    private RepositoryRepositoryInterface $repositories;

    public function __construct(TagRepositoryInterface $tags, RepositoryRepositoryInterface $repositories)
    {
        $this->tags = $tags;
        $this->repositories = $repositories;
    }

    public function assign(int $repositoryId, string $name)
    {
        $tag = $this->tags->create(['name' => $name]);
        $this->repositories->attachTag($repositoryId, $tag->id);

        return $tag;
    }

    public function remove(int $repositoryId, string $name)
    {
        $tag = $this->tags->findByName($name);

        if ($tag === null) {
            return null;
        }

        $this->repositories->detachTag($repositoryId, $tag->id);
    }
}
