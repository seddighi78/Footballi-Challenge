<?php

namespace App\Http\Controllers;

use App\Http\Requests\Repository\IndexRequest;
use App\Http\Resources\Repository\RepositoryCollectionResource;
use App\Services\RepositoryService;

class RepositoryController extends Controller
{
    private RepositoryService $service;

    public function __construct(RepositoryService $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request)
    {
        $pagination = $request->only(['page', 'per_page']);
        $filters = $request->only('tag');

        $repositories = $this->service->index($pagination, $filters);

        return RepositoryCollectionResource::collection($repositories);
    }
}
