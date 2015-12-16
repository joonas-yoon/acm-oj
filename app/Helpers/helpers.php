<?php

use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use Intervention\Image\ImageManagerStatic as Image;

if (!function_exists('if_uri_start')) {
    function if_uri_start(array $array)
    {
        if( ! function_exists('if_uri') || ! function_exists('if_uri_pattern') )
            return false;
            
        if( if_uri($array) ) return true;
        
        $asterisk = function($str){ return $str.'*'; };
        
        return if_uri_pattern(array_map($asterisk, $array));
    }
}

if (!function_exists('upload_photo_on_storage')) {
    /**
     * Uplaod Image on Storage
     *
     * @param File $file
     * @param      $key
     *
     * @return string
     */
    function upload_photo_on_storage(File $file, $key)
    {
        if( ! $file->isValid() || ! $key ) return null;
        
        $imageDirectory = 'images/profile';
        
        if( ! Storage::has($imageDirectory) )
            Storage::makeDirectory($imageDirectory, 0777);
            
        $imageExtension = $file->getClientOriginalExtension();
        $imageHashName = $key;
        $imageFilePath = "app/{$imageDirectory}/{$imageHashName}";
        $imageFileAbsolutePath = storage_path($imageFilePath);
        
        // resize image
        $image = Image::make($file->getRealPath())
            ->resize(300, 300, function ($constraint) {
                // prevent possible upsizing
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($imageFileAbsolutePath);
            
        return $image ? $imageFilePath : null;
    }
}
