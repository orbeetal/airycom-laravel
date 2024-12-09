<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $skip = (int) ($request->skip ?? 0);
        $take = (int) ($request->take ?? 5);

        $query = Blog::query()
            ->select([
                'title',
                'slug',
                'description',
                'published_at',
            ])
            ->active()
            ->published()
            ->orderBy('published_at', 'desc');

        $total = $query->count();

        $blogs = $total > 0
            ? $query->skip($skip)->take($take)->get()
            : collect();

        return [
            'total' => $total,
            'skip'  => $skip,
            'take'  => $take,
            'blogs' => BlogResource::collection($blogs),
        ];
    }

    public function show($slug)
    {
        $blog = Blog::query()
            ->active()
            ->published()
            ->where('slug', $slug)
            ->first();

        return $blog ? BlogResource::make($blog) : (object) [];
    }
}
