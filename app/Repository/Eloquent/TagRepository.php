<?php

namespace App\Repository\Eloquent;

use App\Models\Tag;
use App\Repository\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    private Tag $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    public function find(int $id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByName(string $name)
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    public function get(array $pagination = [])
    {
        $repositories = $this->model->newQuery();

        $pagination['page'] = $pagination['page'] ?? 1;
        $pagination['per_page'] = $pagination['per_page'] ?? null;

        return $repositories->paginate($pagination['per_page'], ['*'], 'page', $pagination['page']);
    }

    public function create(array $attributes)
    {
        return $this->model->newQuery()->firstOrCreate($attributes);
    }
}
