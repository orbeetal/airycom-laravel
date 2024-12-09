<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return
        $blogs = Blog::query()
            ->latest()
            ->paginate();

        return view("admin.blogs.index", compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog = new Blog();

        return view("admin.blogs.create", compact(
            'blog',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        $blog = Blog::create(
            $this->getValidatedData($request)
        );

        return to_route('dashboard.blogs.show', $blog->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // return $blog;

        return to_route('dashboard.blogs.index', [
            'blog' => $blog->id, 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        // return $blog;

        return view("admin.blogs.edit", compact(
            'blog',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        // return $request;

        // return $this->getValidatedData($request, $blog->id);

        $blog->update(
            $this->getValidatedData($request, $blog->id)
        );

        // return $blog;

        return to_route('dashboard.blogs.show', $blog->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        return $blog;

        return to_route('dashboard.blogs.index');
    }

    protected function getValidatedData($request, $id = '')
    {
        return $request->validate([
            "title" => "required|string",
            "slug"  => [
                'required',
                Rule::unique('blogs')->ignore($id),
            ],
            "keywords"      => "",
            "description"   => "",
            "body"          => "",
            "is_active"     => "required|boolean",
            "published_at"  => "",
        ]);
    }
}
