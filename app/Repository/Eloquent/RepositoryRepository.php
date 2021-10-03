<?php

namespace App\Repository\Eloquent;

use App\Models\Repository;
use App\Repository\RepositoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class RepositoryRepository implements RepositoryRepositoryInterface
{
    private Repository $model;

    public function __construct(Repository $repository)
    {
        $this->model = $repository;
    }

    public function find(int $id)
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    public function index(array $pagination = [], array $filters = [])
    {
        $repositories = $this->model->newQuery();

        if (isset($filters['tag'])) {
            $repositories->whereHas('tags', function (Builder $query) use ($filters){
               $query->where('tags.name', 'like', "%{$filters['tag']}%");
            });
        }

        return $repositories->paginate($pagination['per_page'] ?? null);
    }

    public function create(array $attributes)
    {
        return $this->model->newQuery()->firstOrCreate($attributes);
    }
}
