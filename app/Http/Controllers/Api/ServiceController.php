<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        // return
        $services = Service::query()
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return ServiceResource::collection($services);
    }

    public function categoryServices(Request $request, $category)
    {
        // return
        $services = Service::query()
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return ServiceResource::collection($services);
    }

    public function streamPhoto($id, $serial = 0)
    {
        // return
        $service = Service::findOrFail($id);

        if ($service->photo && strpos($service->photos[$serial] ?? "", 'data:image') === 0) {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $service->photo);
            $imageData = base64_decode($base64String);

            return response($imageData, 200)
                ->header('Content-Type', 'image/jpeg');
        }

        return abort(404);
    }
}
