<?php

use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use Intervention\Image\ImageManagerStatic as Image;

if (!function_exists('if_uri_start')) {
    /**
     * extending hieu-le/active function
     *
     * @param array $array
     *
     * @return bool
     */
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

if (!function_exists('is_admin')) {
    /**
     * extending hieu-le/active function
     *
     * @param int $user_id
     *
     * @return bool
     */
    function is_admin($user_id = null)
    {
        if( $user_id ) {
            $user = Sentinel::findById($user_id);
        }
        else if( Sentinel::check() ) {
            $user = Sentinel::getUser();
        }
        else return false;
        
        $admin = Sentinel::findRoleByName('Administrator');
        return $user && $user->inRole($admin);
    }
}

if (!function_exists('paging_query')) {
    /**
     * Add or Change value of query named 'page' on current url
     * 
     * @param string  $url
     * @param int     $page
     *
     * @return bool
     */
    function paging_query($query, $page, $lastPage = null)
    {
        parse_str($query, $params);
        if( $page < 1 ) $page = 1;
        if( $lastPage && $page > $lastPage ) $page = $lastPage;
        $params['page'] = $page;
        return implode('&', array_map(function ($v, $k) { return sprintf("%s=%s", $k, $v); }, $params, array_keys($params)));
    }
}

if (!function_exists('diff_timestamp')) {
    /**
     * Laravel (Carbon) display date difference only in timestamp
     * 
     * @param string $datetime_a
     * @param string $datetime_b
     *
     * @return DateInterval
     */
    function diff_timestamp($datetime_a, $datetime_b = null)
    {
        if( $datetime_b == null ) $datetime_b = date('Y-m-d H:i:s');
        $diff = strtotime($datetime_a) - strtotime($datetime_b);
        return abs($diff);
    }
}