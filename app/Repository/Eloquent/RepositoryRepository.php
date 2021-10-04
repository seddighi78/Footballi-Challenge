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
        return $this->model->newQuery()->find($id);
    }

    public function get(array $pagination = [], array $filters = [])
    {
        $repositories = $this->model->newQuery();

        if (isset($filters['tag'])) {
            $repositories->whereHas('tags', function (Builder $query) use ($filters){
               $query->where('tags.name', 'like', "%{$filters['tag']}%");
            });
        }

        if (isset($filters['user_id'])) {
            $repositories->where('user_id', $filters['user_id']);
        }

        $pagination['page'] = $pagination['page'] ?? 1;
        $pagination['per_page'] = $pagination['per_page'] ?? null;

        return $repositories->paginate($pagination['per_page'], ['*'], 'page', $pagination['page']);
    }

    public function create(array $attributes)
    {
        return $this->model->newQuery()->updateOrCreate([
            'source_id' => $attributes['source_id'],
            'user_id' => $attributes['user_id'],
        ], $attributes);
    }

    public function attachTag(int $id, int $tagId)
    {
        /** @var Repository $repository */
        $repository = $this->model->newQuery()->find($id);

        if ($repository === null) {
            return null;
        }

        $repository->tags()->syncWithoutDetaching([$tagId]);

        return $repository;
    }

    public function detachTag(int $id, int $tagId)
    {
        /** @var Repository $repository */
        $repository = $this->model->newQuery()->find($id);

        if ($repository === null) {
            return null;
        }

        $repository->tags()->detach($tagId);

        return $repository;
    }
}
