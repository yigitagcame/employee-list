<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

class ImageService{

    public function upload($file)
    {
        $name = time().'.'.$file->extension();

        $file->move(public_path('uploads'), $name);

        return $name;
    }

    public function remove($file)
    {
        File::delete(public_path('uploads').'/'.$file);
    }


}
