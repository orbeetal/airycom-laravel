<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // return
        $products = Product::query()
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return ProductResource::collection($products);
    }

    public function latestProducts(Request $request)
    {
        $latestProducts = Product::select('products.*')
            ->join(
                DB::raw('(SELECT category_id, MAX(created_at) as latest_created_at FROM products GROUP BY category_id) as latest'),
                function ($join) {
                    $join->on('products.category_id', '=', 'latest.category_id')
                         ->on('products.created_at', '=', 'latest.latest_created_at');
                }
            )
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();
    
        return ProductResource::collection($latestProducts);
    }

    public function categoryProducts(Request $request, $category)
    {
        // return
        $products = Product::query()
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->skip($request->skip ?? 0)
            ->take($request->take ?? 10)
            ->get();

        return ProductResource::collection($products);
    }

    public function streamPhoto($id, $serial = 1)
    {
        // return
        $product = Product::findOrFail($id);

        $index = $serial > 0 ? $serial - 1 : 0;

        if (($product->photos[$index] ?? null) && strpos($product->photos[$index], 'data:image') === 0) {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $product->photos[$index]);
            $imageData = base64_decode($base64String);

            return response($imageData, 200)
                ->header('Content-Type', 'image/jpeg');
        }

        return abort(404);
    }

}
