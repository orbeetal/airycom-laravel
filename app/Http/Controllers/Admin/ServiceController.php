<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return
        $services = Service::query()
            ->with('category')
            ->latest()
            ->paginate();

        return view("admin.services.index", compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $service = new Service();

        // return
        $categories = Category::query()
            ->get([
                'id',
                'name'
            ]);

        return view("admin.services.create", compact(
            'service',
            'categories',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        $service = Service::create(
            $this->getValidatedData($request)
            + $this->getPhotoData($request)
            + $this->getSpecificationData($request)
        );

        return to_route('dashboard.services.show', $service->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return to_route('dashboard.services.index', [
            'service' => $service->id, 
        ]);

        // return $service;

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // return $service;

        // return
        $categories = Category::query()
            ->get([
                'id',
                'name'
            ]);

        return view("admin.services.edit", compact(
            'service',
            'categories',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // return $request;

        $service->update(
            $this->getValidatedData($request, $service->id) 
            + $this->getPhotoData($request, $service->photos)
            + $this->getSpecificationData($request, $service->specifications)
        );

        return to_route('dashboard.services.show', $service->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        return $service;

        return to_route('dashboard.services.index');
    }

    protected function getValidatedData($request, $id = '')
    {
        return $request->validate([
            "name" => "required|string",
            "slug" => [
                'required',
                Rule::unique('services')->ignore($id),
            ],
            "price" => "",
            "category_id" => "required|exists:App\Models\Category,id",
            "description" => "",
        ]);
    }

    protected function getPhotoData($request, $photos = [])
    {
        if(!$request->hasFile('photos')) {
            return [];  
        }

        foreach($request->file('photos') as $index => $file) {
            $image = Image::read($file);

            $photos[$index] = $image->scale(720)->toWebp()->toDataUri();
        }

        return [
            "photos" => $photos
        ];
    }

    protected function getSpecificationData($request, $specifications = [])
    {
        if(!$request->has('specifications')) {
            return [];  
        }

        $specifications = json_decode($request->specifications, true);

        return [
            "specifications" => $specifications
        ];
    }
}
