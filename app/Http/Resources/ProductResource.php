<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"            => $this->id,
            "slug"          => $this->slug,
            "name"          => $this->name,
            "photo"         => route('product.photo.stream', [$this->id, 1]),
            "description"   => $this->description ?? "",
            "price"         => $this->price ?? "",
        ];
    }
}
