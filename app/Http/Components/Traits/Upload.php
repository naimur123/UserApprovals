<?php

namespace App\Http\Components\Traits;

trait Upload{

    /* Define Directories */
    protected  $user          = "user";
    protected  $trade_license = "trade_license";
    protected  $proposal      = "proposal";
    protected  $workorder     = "workorder";

    /* Check the Derectory If exists or Not */
    protected function CheckDir($dir){
        $fullPath = storage_path('app/public/' . $dir);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }
    }
    

    /* Upload an Image */
    protected function uploadImage($file, $dir, $from = '')
    {

        $this->CheckDir($dir);
        $originalFilename = $file->getClientOriginalName();
        $randomNumber = rand(1000, 9999); 
        $timestamp = time();
        if(!empty($from) && $from == 'order'){
            $originalFilename = $dir . '_' . $randomNumber . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
        } else if(!empty($from) && $from == 'user'){
            $originalFilename = get_user_name() . '_' . $randomNumber . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
        }
        $path = $file->storeAs($dir, $originalFilename, 'public');
        return $path;

    }
    

}