<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        // return
        $equipments = Equipment::query()
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return EquipmentResource::collection($equipments);
    }

    public function latestEquipments(Request $request)
    {
        $latestEquipments = Equipment::select('equipments.*')
            ->join(
                DB::raw('(SELECT category_id, MAX(created_at) as latest_created_at FROM equipments GROUP BY category_id) as latest'),
                function ($join) {
                    $join->on('equipments.category_id', '=', 'latest.category_id')
                         ->on('equipments.created_at', '=', 'latest.latest_created_at');
                }
            )
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();
    
        return EquipmentResource::collection($latestEquipments);
    }

    public function categoryEquipments(Request $request, $category)
    {
        // return
        $equipments = Equipment::query()
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return EquipmentResource::collection($equipments);
    }

    public function streamPhoto($id, $serial = 1)
    {
        // return
        $equipment = Equipment::findOrFail($id);

        $index = $serial > 0 ? $serial - 1 : 0;

        if (($equipment->photos[$index] ?? null) && strpos($equipment->photos[$index], 'data:image') === 0) {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $equipment->photos[$index]);
            $imageData = base64_decode($base64String);

            return response($imageData, 200)
                ->header('Content-Type', 'image/jpeg');
        }

        return abort(404);
    }
}
