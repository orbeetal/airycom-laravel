<?php

namespace App\Models;

use App\Traits\HasHistories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, HasHistories;

    const PAGES = [
        'home',
        'about',
        'cleanroom',
        'hvac',
        'air-filtration',
    ];

    protected $guarded = [];
}
