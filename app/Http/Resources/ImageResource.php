<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $disk = 'public';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'src' => $this->src,
            'imgUrl' => Storage::disk($disk)->url($this->src),
        ];
    }
}
