<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaggableRequest;
use App\Http\Requests\UpdateTaggableRequest;
use App\Http\Resources\TaggableResource;
use App\Models\Taggable;

class TaggableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return TaggableResource::collection(Taggable::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaggableRequest $request): void
    {
        $attributes = $request->validated();

        Taggable::query()->create([
            'tag_id' => $attributes['tag_id'],
            'taggable_id' => $attributes['taggable_id'],
            'taggable_type' => $attributes['taggable_type'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Taggable $taggable): array
    {
        return (new TaggableResource($taggable))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaggableRequest $request, Taggable $taggable): void
    {
        $attributes = $request->validated();

        $taggable->update([
            'tag_id' => $attributes['tag_id'],
            'taggable_id' => $attributes['taggable_id'],
            'taggable_type' => $attributes['taggable_type'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Taggable $taggable): void
    {
        $taggable->delete();
    }
}
