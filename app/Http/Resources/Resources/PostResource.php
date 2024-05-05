<?php

namespace App\Http\Resources\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'author_id' => $this->author_id,
            'author' => $this->author,
            'company_id' => $this->company_id,
            'title' => $this->title,
            'content' => $this->content,
            'difficulty' => $this->difficulty,
            'views' => $this->views,
            'read_time' => $this->read_time,
            'likes' => $this->likes,
            'status' => $this->status,
            'comments' => $this->comments(),
            'tags' => $this->tags(),
            'images' => $this->images(),
            'published_at' => $this->published_at,
        ];
    }
}
