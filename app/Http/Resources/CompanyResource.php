<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "spokesperson_id" => $this->spokesperson->id,
            "name" => $this->name,
            "title" => $this->title,
            "site" => $this->site,
            "age_date" => $this->age_date,
            "numbers" => $this->numbers,
            "location" => $this->location,
        ];
    }
}
