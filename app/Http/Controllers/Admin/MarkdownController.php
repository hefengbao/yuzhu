<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Services\UploadImageService;
use Illuminate\Http\JsonResponse;

class MarkdownController extends Controller
{
    public function upload_image(UploadImageRequest $request, UploadImageService $service): JsonResponse
    {
        return response()->json([
            'data' => [
                'filePath' => 'storage/'.$service->uploadAndManipulate($request->file('image')),
            ],
        ]);
    }
}
