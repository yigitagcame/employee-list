<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

class ImageService{

    public function upload($file)
    {
        $name = time().'.'.$file->extension();
        $folder = env('UPLOAD_PHOTO_PATH');

        $file->move(public_path($folder), $name);

        return $folder.$name;
    }

    public function remove($file)
    {
        File::delete(public_path($file));
    }


}
