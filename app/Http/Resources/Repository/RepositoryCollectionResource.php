<?php

namespace App\Http\Resources\Repository;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Tag\TagCollectionResource;
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
            'source_id' => $this->source_id,
            'name' => $this->name,
            'language' => $this->language,
            'tags' => TagCollectionResource::collection($this->tags),
        ];
    }
}
