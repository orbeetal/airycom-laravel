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
        'product' => [
            'product_cleanroom_thumbnail',
            'product_cleanroom_description',
            'product_hvac_thumbnail',
            'product_hvac_description',
            'product_air_filtration_thumbnail',
            'product_air_filtration_description',
        ],
        'service' => [
            'service_cleanroom_thumbnail',
            'service_cleanroom_description',
            'service_hvac_thumbnail',
            'service_hvac_description',
        ],
    ];

    protected $guarded = [];
}
