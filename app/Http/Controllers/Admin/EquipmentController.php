<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return
        $equipments = Equipment::query()
            ->with('category')
            ->latest()
            ->paginate();

        return view("admin.equipments.index", compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipment = new Equipment();

        // return
        $categories = Category::query()
            ->get([
                'id',
                'name'
            ]);

        return view("admin.equipments.create", compact(
            'equipment',
            'categories',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        $equipment = Equipment::create(
            $this->getValidatedData($request)
            + $this->getPhotoData($request)
            + $this->getSpecificationData($request)
        );

        return to_route('dashboard.equipments.show', $equipment->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        return to_route('dashboard.equipments.index', [
            'equipment' => $equipment->id, 
        ]);

        // return $equipment;

        return view('admin.equipments.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        // return $equipment;

        // return
        $categories = Category::query()
            ->get([
                'id',
                'name'
            ]);

        return view("admin.equipments.edit", compact(
            'equipment',
            'categories',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        // return $request;

        $equipment->update(
            $this->getValidatedData($request, $equipment->id) 
            + $this->getPhotoData($request, $equipment->photos)
            + $this->getSpecificationData($request, $equipment->specifications)
        );

        return to_route('dashboard.equipments.show', $equipment->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        return $equipment;

        return to_route('dashboard.equipments.index');
    }

    protected function getValidatedData($request, $id = '')
    {
        return $request->validate([
            "name" => "required|string",
            "slug" => [
                'required',
                Rule::unique('equipments')->ignore($id),
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
