<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Laravel\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getImageData($image = null)
    {
        if ($image && strpos($image, 'data:image') === 0)
        {
            $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $image);

            return base64_decode($base64String);
        }

        return null;
    }

    protected function getPhotoData($request, $width = 320, $height = 320): array
    {
        if(!$request->hasFile('image')) {
            return [];  
        }

        $file = $request->file('image');

        $image = Image::read($file);

        $image = $image->cover($width, $height)->toWebp()->toDataUri();

        return [
            "image" => $image
        ];
    }
}
