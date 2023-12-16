<?php

namespace App\One;

use Auth;
use Intervention\Image\Exception\ImageException;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    /**
     * @var UploadedFile
     */
    protected $file;

    protected $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];

    /**
     * @param  UploadedFile  $file
     * @param  User  $user
     * @return array
     */
    public function uploadAvatar($file)
    {
        $this->file = $file;
        $this->checkAllowedExtensionsOrFail();

        $avatar_name = Auth::user()->id.'_'.time().'.'.$file->getClientOriginalExtension() ?: 'png';
        $this->saveImageToLocal('avatar', 380, $avatar_name);

        return ['filename' => $avatar_name];
    }

    protected function checkAllowedExtensionsOrFail()
    {
        $extension = strtolower($this->file->getClientOriginalExtension());
        if ($extension && ! in_array($extension, $this->allowed_extensions)) {
            throw new ImageException('You can only upload image with extensions: '.implode($this->allowed_extensions, ','));
        }
    }

    protected function saveImageToLocal($type, $resize, $filename = '')
    {
        $folderName = ($type == 'avatar')
            ? 'uploads/avatars'
            : 'uploads/attachments/'.date('Ym', time()).'/'.date('d', time()).'/'.Auth::user()->id;

        $destinationPath = storage_path('app/public').'/'.$folderName;
        $extension = $this->file->getClientOriginalExtension() ?: 'png';
        $safeName = $filename ?: str_random(10).'.'.$extension;
        $this->file->move($destinationPath, $safeName);

        if ($this->file->getClientOriginalExtension() != 'gif') {
            $img = Image::make($destinationPath.'/'.$safeName);
            $img->resize($resize, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save();
        }

        return $folderName.'/'.$safeName;
    }

    public function uploadImage($file)
    {
        $this->file = $file;
        $this->checkAllowedExtensionsOrFail();

        $local_image = $this->saveImageToLocal('post', 1440);

        return ['filename' => $local_image];
    }
}
