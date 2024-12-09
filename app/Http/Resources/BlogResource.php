<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug'          => $this->slug,
            'title'         => $this->title,
            'published_at'  => $this->published_at ? $this->published_at->format('d-M-Y') : '',
            'keywords'      => $this->whenHas('keywords', $this->keywords ?? ''),
            'description'   => $this->description ?? '',
            'body'          => $this->whenHas('body', $this->body ?? ''),
        ];
    }
}
