<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 12);

        $query = Product::query()
            ->select([
                'id',
                'slug',
                'name',
                'category_id',
                'photos',
            ]);

        $total = $query->count();

        $products = $total > 0
            ? $query
                ->with('category')
                ->skip($skip)
                ->take($take)
                ->get()
            : collect();

        // return $products;

        return [
            'total' => $total,
            'skip'  => $skip,
            'take'  => $take,
            'products' => ProductResource::collection($products),
        ];
    }
}
