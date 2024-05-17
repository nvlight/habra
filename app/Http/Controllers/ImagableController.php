<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImagableRequest;
use App\Http\Requests\UpdateImagableRequest;
use App\Http\Resources\ImagableResource;
use App\Models\Imagable;
use App\Models\Taggable;

class ImagableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return ImagableResource::collection(Imagable::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImagableRequest $request): void
    {
        $attributes = $request->validated();

        Imagable::query()->create([
            'image_id' => $attributes['image_id'],
            'imagable_id' => $attributes['imagable_id'],
            'imagable_type' => $attributes['imagable_type'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Imagable $imagable): array
    {
        return (new ImagableResource($imagable))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImagableRequest $request, Imagable $imagable): void
    {
        $attributes = $request->validated();

        $imagable->update([
            'image_id' => $attributes['image_id'],
            'imagable_id' => $attributes['imagable_id'],
            'imagable_type' => $attributes['imagable_type'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imagable $imagable)
    {
        //
    }
}
