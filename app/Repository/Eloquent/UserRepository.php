<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function find(int $id)
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    public function findByUsername(string $username)
    {
        return $this->model->newQuery()->where('username', $username)->first();
    }

    public function create(array $attributes)
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $this->model->newQuery()->where('id', $id)->update($attributes);

        return $this->find($id);
    }
}
