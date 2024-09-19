<?php

namespace App\Http\Components\Traits;

trait Upload{
    /* Define Directories */
    protected  $trade_license = "trade_license";

    /* Check the Derectory If exists or Not */
    protected function CheckDir($dir){
        $fullPath = storage_path('app/public/' . $dir);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }
    }
    

    /* Upload an Image */
    protected function uploadImage($file, $dir, $oldFile = "")
    {
        if (!$file) {
            return $oldFile;
        }
        $this->CheckDir($dir);   
        $originalFilename = $file->getClientOriginalName();
        $path = $file->storeAs($dir, $originalFilename, 'public');
        return $path;
    }
    

}