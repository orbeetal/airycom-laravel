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

    public function product()
    {
        return $this->index('product');
    }

    public function service()
    {
        return $this->index('service');
    }

    public function index($criteria = 'contact')
    {
        // return $criteria;

        if(!array_key_exists($criteria, Setting::CRITERIA)) {
            return abort(404);
        }

        $properties = Setting::CRITERIA[$criteria] ?? [];

        $settings = $properties
            ? Setting::whereIn('property', $properties)
                ->get()
                ->mapWithKeys(fn($setting) => [$setting->property => $setting->value])
                ->toArray()
            : [];

        return response()->json($settings);
    }

    public function streamImage($property)
    {
        // return $property;

        // return
        $value = Setting::where('property', $property)->value('value');

        $imageData = $this->getImageData($value);

        return $imageData
            ? response($imageData)->header('Content-Type', 'image/webp')
            : abort(404);
    }
}
