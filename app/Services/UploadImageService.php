<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadImageService
{
    public function uploadAndManipulate(UploadedFile $file): string
    {
        $folder = 'upload/images/'.date('Ym').'/';

        if (! is_dir(Storage::disk('public')->path($folder))) {
            mkdir(Storage::disk('public')->path($folder), 0777, true);
        }

        $ext = $file->getClientOriginalExtension();

        if (strtolower($ext) == 'gif') {
            $path = $file->store($folder, [
                'disk' => 'public',
            ]);
        } else {
            $image = Image::make($file);
            $width = $image->getWidth();
            $height = $image->getHeight();

            $path = $folder.Str::random(40).'.'.$ext;

            if ($width >= 1024 || $height >= 1024) {
                $image->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(Storage::disk('public')->path($path));
            } else {
                $image->save(Storage::disk('public')->path($path));
            }
        }

        return $path;
    }
}
