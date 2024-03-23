<?php

namespace App\Helpers;

trait ImageManager
{

    public function uploadImage($path, $file)
    {
        if ($file) {
            $file_name = $file->hashName() . '.' . $file->hashName();
            $file_type = $file->getClientOriginalExtension();
            $file->move($path, $file_name);
            $filePath = $path;
            return $file = [
                'fileName' => $file_name,
                'fileType' => $file_type,
                'filePath' => $filePath,
                'fileSize' => '100kb'
            ];
        }
    }
}
