<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return TagResource::collection(Tag::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): Tag
    {
        $attributes = $request->validated();

        /** @var Tag $tag */
        $tag = Tag::query()->create($attributes);

        return $tag;
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): array
    {
        return (new TagResource($tag))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): void
    {
        $attributes = $request->validated();

        $tag->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): void
    {
        $tag->delete();
    }
}
