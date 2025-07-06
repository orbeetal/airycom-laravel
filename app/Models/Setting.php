<?php

namespace App\Models;

use App\Traits\HasHistories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, HasHistories;

    const CRITERIA = [
        'contact' => [
            'phone',
            'email',
            'facebook',
            'address',
        ],
        'about' => [
            'about_company',
            'company_vision',
            'company_mission',
            'company_offerings',
        ],
    ];

    protected $guarded = [];
}
