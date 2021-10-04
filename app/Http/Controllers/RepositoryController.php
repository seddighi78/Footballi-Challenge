<?php

namespace App\Http\Controllers;

use App\Http\Requests\Repository\IndexRequest;
use App\Http\Requests\Repository\ShowRequest;
use App\Http\Resources\Repository\RepositoryCollectionResource;
use App\Http\Resources\Repository\RepositoryResource;
use App\Models\Repository;
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
        $filters = $request->only(['tag']);

        $repositories = $this->service->index($pagination, $filters);

        return RepositoryCollectionResource::collection($repositories);
    }

    public function show(ShowRequest $request, Repository $repository)
    {
        return new RepositoryResource($repository);
    }
}
