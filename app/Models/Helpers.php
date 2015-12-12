<?php

namespace App\Models;

use Request;
use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class Helpers extends Model
{
    public static function setActive($path, $route = null, $active = 'active')
    {
        if( is_object($route) )
        {
            return $route->getName() == $path ? $active : '';
        }

        return Request::is($path) || Request::is($path.'/*') ? $active : '';
    }

    public static function setActiveStrict($path, $route = null, $active = 'active')
    {
        if( is_object($route) )
        {
            return $route->getName() == $path ? $active : '';
        }

        return Request::is($path) ? $active : '';
    }
    
    public static function uploadPhoto(File $file, $key)
    {
        if( ! $file->isValid() || ! $key ) return null;
        
        $imageDirectory = 'images/profile';
        $imageExtension = $file->getClientOriginalExtension();
        $imageHashName = $key;
        $imageFilePath = "{$imageDirectory}/{$imageHashName}";
        
        // resize image
        $image = Image::make($file->getRealPath())
            ->resize(300, 300, function ($constraint) {
                // prevent possible upsizing
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        );
        $imageBinary = $image->stream();//->__toString();
        
        return Storage::put($imageFilePath, $imageBinary);
    }
}
