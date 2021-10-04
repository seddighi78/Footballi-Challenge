<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\AbstractResource;
use App\Models\Tag;

/**
 * @mixin Tag
 */
class TagResource extends AbstractResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
