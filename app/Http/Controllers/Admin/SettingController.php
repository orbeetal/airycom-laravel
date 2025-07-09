<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function form($criteria)
    {
        // return $criteria;

        if(!array_key_exists($criteria, Setting::CRITERIA)) {
            return abort(404);
        }

        // return
        $settings = $this->getSettings($criteria);

        return view('admin.settings.' . $criteria, compact('settings'));
    }

    protected function getSettings($criteria)
    {
        return Setting::query()
            ->whereIn('property', Setting::CRITERIA[$criteria] ?? [])
            ->pluck('value', 'property')
            ->toArray();
    }

    public function save(Request $request)
    {
        // return $request;

        try {
            foreach ($request->settings as $property => $value) {
                Setting::updateOrCreate(
                    ['property' => $property],
                    [
                        'value' => $value instanceof UploadedFile
                            ? $this->getPhotoStringData($value, 5 * 64, 6 * 64)
                            : $value,
                    ]
                );
            }

            return back()->with('message', 'Updated successfully!');
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    protected function getPhotoStringData($file, $width = 320, $height = 320): string
    {
        if(!is_file($file) || !$file->isValid()) {
            return '';  
        }

        $image = Image::read($file);

        $image = $image->cover($width, $height)->toWebp()->toDataUri();

        return $image;
    }
}
