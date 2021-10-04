<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\AssignRequest;
use App\Http\Requests\Tag\IndexRequest;
use App\Http\Requests\Tag\RemoveRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Tag\TagCollectionResource;
use App\Http\Resources\Tag\TagResource;
use App\Repository\TagRepositoryInterface;
use App\Services\TagService;

class TagController extends Controller
{
    private TagRepositoryInterface $tags;
    private TagService $service;

    public function __construct(TagService $service, TagRepositoryInterface $tags)
    {
        $this->service = $service;
        $this->tags = $tags;
    }

    public function index(IndexRequest $request)
    {
        $pagination = $request->only(['page', 'per_page']);

        $tags = $this->tags->get($pagination);

        return TagCollectionResource::collection($tags);
    }

    public function assign(AssignRequest $request)
    {
        $tag = $this->service->assign($request->repository_id, $request->name);

        return new TagResource($tag);
    }

    public function remove(RemoveRequest $request)
    {
        $this->service->remove($request->repository_id, $request->name);

        return new DefaultResource();
    }
}
