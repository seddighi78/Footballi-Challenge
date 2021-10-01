<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractResource extends JsonResource
{
    public static int $code = Response::HTTP_OK;
    public static string $message = 'messages.resource.success';

    public function __construct($resource = [])
    {
        parent::__construct($resource);

        $this->additional['code'] = self::$code;
        $this->additional['message'] = __(self::$message);
    }

    public function __destruct()
    {
        $this->reset();
    }

    private function reset()
    {
        self::$code = Response::HTTP_OK;
        self::$message = 'messages.resource.success';
    }

    public static function collection($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            $instance = parent::collection($resource->getCollection());

            $instance->additional['pagination']['total'] = $resource->total();
            $instance->additional['pagination']['per_page'] = $resource->perPage();
            $instance->additional['pagination']['current_page'] = $resource->currentPage();
            $instance->additional['pagination']['has_more_pages'] = $resource->hasMorePages();
            $instance->additional['pagination']['last_page'] = $resource->lastPage();
        } else {
            $instance = parent::collection($resource);
        }

        $instance->additional['code'] = self::$code;
        $instance->additional['message'] = __(self::$message);

        return $instance;
    }

    public function toResponse($request)
    {
        $response = (new ResourceResponse($this))->toResponse($request);

        if (self::$code >= 100) {
            $response->setStatusCode(self::$code);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}
