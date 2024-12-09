<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // "id"            => $this->id,
            "slug"          => $this->slug,
            "name"          => $this->name,
            "photo"         => route('equipment.photo.stream', [$this->id, 1]),
            'keywords'      => $this->whenHas('keywords', $this->keywords ?? ''),
            "description"   => $this->whenHas('description', $this->description ?? ""),
            // "price"         => $this->price ?? "",
            "category"      => $this->whenLoaded('category', fn() => CategoryResource::make($this->category)),
        ];
    }
}
