<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\Resources\ImageResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return ImageResource::collection(Image::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $img = $request->file('src') ?: null;
        $disk = 'public';
        $imgPrefix = 'images';

        if ($img){
            try {
                $title = preg_replace("/[\t\s]+/", " ", trim($attributes['title']));
                $imgName =  $imgPrefix . '/' . $title . '.' . $img->extension();

                // сработает каждый из них
                // $img->storeAs('',  $imgName, $disk);
                Storage::disk($disk)->putFileAs($img, $imgName);

                $attributes['src'] = $imgName;
                Storage::disk($disk)->url($attributes['src']);
            }catch (\Throwable $exception){
                return response()
                    ->json(['error with file creating'], 422);
            }
        }

        /** @var Image $image */
        $image = Image::query()->create($attributes);

        $imageResource = (new ImageResource($image))->resolve();

        return response()
            ->json($imageResource, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image): array
    {
        return (new ImageResource($image))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image): JsonResponse
    {
        $attributes = $request->validated();

        $img = $request->file('src') ?: null;
        $disk = 'public';
        $imgPrefix = 'images';

        if ($img){
            try {
                // first delete old image
                $etalonImageSrc = $image->src;

                $imgName =  $imgPrefix . '/' . $attributes['title'] . '.' . $img->extension();

                // сработает каждый из них
                // $img->storeAs('',  $imgName, $disk);
                Storage::disk($disk)->putFileAs($img, $imgName);

                $attributes['src'] = $imgName;
                Storage::disk($disk)->url($attributes['src']);

                // delete old image then
                if (Storage::disk($disk)->exists($etalonImageSrc)){
                    Storage::disk($disk)->delete($etalonImageSrc);
                }
            }catch (\Throwable $exception){
                return response()
                    ->json([
                        'error with file updating',
                        $exception->getMessage(),
                    ], 422);
            }
        }

        $image->update($attributes);

        $imageResource = (new ImageResource($image))->resolve();

        return response()
            ->json($imageResource, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image):void
    {
        $disk = 'public';

        if (Storage::disk($disk)->exists($image->src)){
            Storage::disk($disk)->delete($image->src);
        }

        $image->delete();
    }

    public function img_files()
    {
        return Storage::disk('public')->allFiles();
    }

    public function img_exists(Request $request)
    {
        $fileName = $request->input('name');
        $exists = Storage::disk('public')->exists($fileName);

        return response()->json([
            '$fileName' => $fileName,
            '$exists' => $exists,
        ]);
    }

}
