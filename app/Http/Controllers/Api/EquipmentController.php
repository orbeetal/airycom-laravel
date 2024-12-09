<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EquipmentResource;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 10);

        $total = Equipment::count();

        if($total > 0) {
            // return
            $equipments = Equipment::query()
                ->select([
                    'id', 
                    'slug',
                    'name',
                    'category_id',
                    'photos',
                    'description',
                ])
                ->with('category')
                ->skip($skip)
                ->take($take)
                ->get();
        }

        return [
            'total'     => $total,
            'skip'      => $skip,
            'take'      => $take,
            'equipments'  => $total ? EquipmentResource::collection($equipments) : [],
        ];
    }    
    
    public function show($slug)
    {
        $equipment = Equipment::query()
            ->where('slug', $slug)
            ->first();

        return $equipment ? EquipmentResource::make($equipment) : (object) [];
    }

    public function latestEquipments(Request $request)
    {
        // return
        $latestEquipments = Equipment::query()
            ->select([
                'equipments.id', 
                'equipments.slug',
                'equipments.name',
                'equipments.category_id',
                'equipments.photos',
                'equipments.description',
            ])
            ->with('category')
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

    public function categoryEquipments(Request $request, $category_slug)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 10);

        $category = Category::query()
            ->where('slug', $category_slug)
            ->first();

        if(!$category) {
            return [
                'total'     => 0,
                'skip'      => $skip,
                'take'      => $take,
                'category'  => (object) [],
                'equipments'  => (array) [],
            ];
        }

        $query = Equipment::query()
            ->where('category_id', $category->id);

        $total = $query->count();

        if($total > 0) {
            // return
            $equipments = $query
                ->select([
                    'id', 
                    'slug',
                    'name',
                    'photos',
                    'description',
                ])
                ->skip($skip)
                ->take($take)
                ->get();
        }

        return [
            'total'     => $total,
            'skip'      => $skip,
            'take'      => $take,
            'category'  => CategoryResource::make($category),
            'equipments'  => $total ? EquipmentResource::collection($equipments) : [],
        ];
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
