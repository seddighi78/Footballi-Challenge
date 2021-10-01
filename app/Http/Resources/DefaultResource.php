<?php

namespace App\Http\Resources;


class DefaultResource extends AbstractResource
{
    public function toArray($request)
    {
        return $this->resource;
    }
}
