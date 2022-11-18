<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function image(Request $request){
        $this->validate($request, [
            'image' => ['required', 'file', 'image']
        ]);

        $path = $request->file('image')->storePublicly('images');

        return response()->json([
           'success' => 1,
            'file' => [
                'url' => url(\Storage::url($path))
            ]
        ]);
    }
}
