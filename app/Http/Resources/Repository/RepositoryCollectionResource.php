<?php

namespace App\Http\Resources\Repository;

use App\Http\Resources\AbstractResource;
use App\Models\Repository;

/**
 * @mixin Repository
 */
class RepositoryCollectionResource extends AbstractResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language,
        ];
    }
}
