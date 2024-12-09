<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "is_active" => "boolean",
        'published_at' => 'date',
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::slug($value),
        );
    }

    public function scopeActive($query, bool $is_active = true)
    {
        return $query->where('is_active', $is_active);
    }

    public function scopePublished($query, bool $is_published = true)
    {
        return $query->where('published_at', $is_published ? '<=' : '>', now());
    }
}
