<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function streamPhoto($id, $serial = 0)
    {
        // return
        $product = Product::findOrFail($id);

        if ($product->photo && strpos($product->photos[$serial] ?? "", 'data:image') === 0) {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $product->photo);
            $imageData = base64_decode($base64String);

            return response($imageData, 200)
                ->header('Content-Type', 'image/jpeg');
        }

        return abort(404);
    }

}
