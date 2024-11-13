<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function latestServices(Request $request)
    {
        $latestServices = Service::select('services.*')
            ->join(
                DB::raw('(SELECT category_id, MAX(created_at) as latest_created_at FROM services GROUP BY category_id) as latest'),
                function ($join) {
                    $join->on('services.category_id', '=', 'latest.category_id')
                         ->on('services.created_at', '=', 'latest.latest_created_at');
                }
            )
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();
    
        return ServiceResource::collection($latestServices);
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

    public function streamPhoto($id, $serial = 1)
    {
        // return
        $service = Service::findOrFail($id);

        $index = $serial > 0 ? $serial - 1 : 0;

        if (($service->photos[$index] ?? null) && strpos($service->photos[$index], 'data:image') === 0) {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $service->photos[$index]);
            $imageData = base64_decode($base64String);

            return response($imageData, 200)
                ->header('Content-Type', 'image/jpeg');
        }

        return abort(404);
    }
}
