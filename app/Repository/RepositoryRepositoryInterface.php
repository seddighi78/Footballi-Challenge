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
     * @param array $pagination the page and per_page are used to pagination.
     * @param array $filters
     * @return Repository[]
     */
    public function get(array $pagination = [], array $filters = []);

    /**
     * @param array $attributes
     * @return Repository
     */
    public function create(array $attributes);

    /**
     * @param int $id
     * @param int $tagId
     * @return Repository
     */
    public function attachTag(int $id, int $tagId);

    /**
     * @param int $id
     * @param int $tagId
     * @return Repository
     */
    public function detachTag(int $id, int $tagId);
}
