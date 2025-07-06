<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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

        foreach($request->settings as $property => $value) {
            Setting::updateOrCreate(
                [
                    'property' => $property,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        return back()->with('message', 'Updated successfully!');
    }
}
