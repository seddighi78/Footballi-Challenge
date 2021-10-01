<?php

namespace App\Repository;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id);

    /**
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username);

    /**
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes);
}
