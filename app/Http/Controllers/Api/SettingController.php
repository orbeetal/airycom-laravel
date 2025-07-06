<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function contact()
    {
        return $this->index('contact');
    }

    public function about()
    {
        return $this->index('about');
    }

    public function index($criteria = 'contact')
    {
        // return $criteria;

        if(!array_key_exists($criteria, Setting::CRITERIA)) {
            return abort(404);
        }

        $settings = Setting::query()
            ->whereIn('property', Setting::CRITERIA[$criteria] ?? [])
            ->pluck('value', 'property')
            ->toArray();

        return response()->json($settings);
    }
}
