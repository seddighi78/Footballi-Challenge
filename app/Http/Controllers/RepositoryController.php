<?php

namespace App\Http\Controllers;

use App\Http\Requests\Repository\IndexRequest;
use App\Http\Requests\Repository\ShowRequest;
use App\Http\Resources\Repository\RepositoryCollectionResource;
use App\Http\Resources\Repository\RepositoryResource;
use App\Repository\RepositoryRepositoryInterface;
use App\Services\RepositoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RepositoryController extends Controller
{
    private RepositoryService $service;
    private RepositoryRepositoryInterface $repositories;

    public function __construct(RepositoryService $service, RepositoryRepositoryInterface $repositories)
    {
        $this->service = $service;
        $this->repositories = $repositories;
    }

    public function index(IndexRequest $request)
    {
        $pagination = $request->only(['page', 'per_page']);
        $filters = $request->only(['tag']);

        $repositories = $this->service->index($pagination, $filters);

        return RepositoryCollectionResource::collection($repositories);
    }

    public function show(ShowRequest $request, $id)
    {
        $repository = $this->repositories->find($id);

        if ($repository === null) {
            return abort(404);
        }

        return new RepositoryResource($repository);
    }
}
