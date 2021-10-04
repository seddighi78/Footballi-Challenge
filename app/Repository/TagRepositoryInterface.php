<?php

namespace App\Repository;

use App\Models\Tag;

interface TagRepositoryInterface
{
    /**
     * @param int $id
     * @return Tag|null
     */
    public function find(int $id);

    /**
     * @param string $name
     * @return Tag|null
     */
    public function findByName(string $name);

    /**
     * @param array $pagination the page and per_page are used to pagination.
     * @return Tag[]
     */
    public function get(array $pagination = []);

    /**
     * @param array $attributes
     * @return Tag
     */
    public function create(array $attributes);
}
