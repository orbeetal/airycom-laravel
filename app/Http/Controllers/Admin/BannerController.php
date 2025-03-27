<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Banner::PAGES;
        
        $pagesString = "'" . implode("','", $pages) . "'";
        
        $banners = Banner::query()
            ->orderByRaw("FIELD(page, $pagesString)")
            ->orderBy('status', 'DESC')
            ->paginate();

        return view("admin.banners.index", compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner = new Banner();

        $pages = Banner::PAGES;

        return view("admin.banners.create", compact('banner', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banner = Banner::create(
            $this->getValidatedData($request)
            + $this->getPhotoData($request, 1920, 600)
        );

        return to_route('dashboard.banners.show', $banner->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return to_route('dashboard.banners.index', [
            'banner' => $banner->id,
        ]);

        return view("admin.banners.show", compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $pages = Banner::PAGES;

        return view("admin.banners.edit", compact('banner', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $banner->update(
            $this->getValidatedData($request, $banner->id)
            + $this->getPhotoData($request, 1920, 600)
        );

        return to_route('dashboard.banners.show', $banner->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return to_route('dashboard.banners.index');
    }

    protected function getValidatedData($request, $id = '')
    {
        return $request->validate([
            "page"      => "required|string",
            "link"      => "nullable|string",
            "status"    => "nullable|boolean",
            "position"  => "nullable|numeric",
        ]);
    }
}
