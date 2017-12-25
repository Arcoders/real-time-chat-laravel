<?php

namespace App\Traits;
use Intervention\Image\Facades\Image;

trait UploadFiles
{

    protected function processImage($requestFile, $userId, $folder, $avatar = true)
    {

        $data = $requestFile;
        $name = $data->getClientOriginalName();
        $ext = $data->getClientOriginalExtension();

        $image = Image::make($data);

        if ($avatar) $image->fit(500, 500);

        $image_name = rand(0, time()) . '_' . $userId . str_shuffle(md5($name)) . '.' . $ext;

        $image->save(public_path() . $folder . $image_name);

        return $folder.$image_name;

    }

    protected function deleteImage($name)
    {
        $file = public_path() . $name;
        if (file_exists($file)) @unlink($file);
    }

}