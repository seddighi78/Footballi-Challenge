<?php

namespace App\Repository;

use App\Models\Repository;

interface RepositoryRepositoryInterface
{
    /**
     * @param int $id
     * @return Repository|null
     */
    public function find(int $id);

    /**
     * @param array $pagination
     * @param array $filters
     * @return Repository[]
     */
    public function index(array $pagination = [], array $filters = []);

    /**
     * @param array $attributes
     * @return Repository
     */
    public function create(array $attributes);
}
