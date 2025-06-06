<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasHistories;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasAuthor, HasHistories;

    protected $guarded = [];

    protected $appends = [
        'photo',
    ];

    protected $casts = [
        "photos" => "array",
        "specifications" => "json",
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::slug($value, '-'),
        );
    }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->photos[0] ?? "",
        );
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
