<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'file', 'image']
        ]);

        $file = $request->file('image');

        $image = \Image::make($file);
        $width = $image->getWidth();
        $height = $image->getHeight();

        $folder = 'upload/images/' . date('Ym') . '/';
        $ext = $file->getClientOriginalExtension();

        if (!is_dir(\Storage::disk('public')->path($folder))) {
            mkdir(Storage::disk('public')->path($folder), 0777, true);
        }

        $path = $folder . Str::random(40) . '.' . $ext;

        if ($width >= 1024 || $height > +1024) {
            $image->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(Storage::disk('public')->path($path));
        } else {
            $image->save(Storage::disk('public')->path($path));
        }

        return response()->json([
            'data' => [
                'filePath' => Storage::url($path)
            ]
        ]);
    }
}
