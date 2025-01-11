<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function search($text)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 10);

        $query = Product::query()
            ->where(function ($query) use ($text) {
                $query->where('slug', 'like', "%{$text}%")
                    ->orWhere('name', 'like', "%{$text}%");
            });

        $total = $query->count();

        if($total > 0) {
            // return
            $products = $query
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
            'products'  => $total ? ProductResource::collection($products) : [],
        ];
    }

    public function advanceSearch($text)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 10);

        // Primary query: search by slug and name
        $primaryQuery = Product::query()
            ->where(function ($query) use ($text) {
                $query->where('slug', 'like', "%{$text}%")
                    ->orWhere('name', 'like', "%{$text}%");
            });

        // Secondary query: search by description
        $fallbackQuery = Product::query()
            ->where('description', 'like', "%{$text}%")
            ->whereNotIn('id', $primaryQuery->pluck('id')); // Exclude already matched IDs

        // Combine the results
        $primaryResults = $primaryQuery
            ->select(['id', 'slug', 'name', 'category_id', 'photos', 'description'])
            ->with('category')
            ->get();

        $fallbackResults = $fallbackQuery
            ->select(['id', 'slug', 'name', 'category_id', 'photos', 'description'])
            ->with('category')
            ->get();

        // Merge the primary and fallback results
        $mergedResults = $primaryResults->merge($fallbackResults);

        // Paginate the combined results
        $total = $mergedResults->count();
        $products = $mergedResults->slice($skip, $take);

        return [
            'total'     => $total,
            'skip'      => $skip,
            'take'      => $take,
            'products'  => ProductResource::collection($products),
        ];
    }

    public function index(Request $request)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 10);

        $total = Product::count();

        if($total > 0) {
            // return
            $products = Product::query()
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
            'products'  => $total ? ProductResource::collection($products) : [],
        ];
    }

    public function show($slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->first();

        return $product ? ProductResource::make($product) : (object) [];
    }

    public function latestProducts(Request $request)
    {
        // return
        $latestProducts = Product::query()
            ->select([
                'products.id', 
                'products.slug',
                'products.name',
                'products.category_id',
                'products.photos',
                'products.description',
            ])
            ->with('category')
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

    public function randomProducts()
    {
        $products = Product::query()
            ->with('category')
            ->select([
                'id', 
                'slug',
                'name',
                'photos',
                'description',
                'category_id',
            ])
            ->inRandomOrder()
            ->take(10)
            ->get();

        return response()->json($products ? ProductResource::collection($products) : []);

        return [
            'total'     => $total,
            'skip'      => $skip,
            'take'      => $take,
            'products'  => $total ? ProductResource::collection($products) : [],
        ];
    }

    public function categoryProducts(Request $request, $category_slug)
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
                'products'  => (array) [],
            ];
        }

        $query = Product::query()
            ->where('category_id', $category->id);

        $total = $query->count();

        if($total > 0) {
            // return
            $products = $query
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
            'products'  => $total ? ProductResource::collection($products) : [],
        ];
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
