<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasHistories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasAuthor, HasHistories;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
