<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Items extends Model
{
    use HasFactory;
    protected static function boot(){
        parent::boot();

        static::creating(function ($data){
            if (empty($data->code)) {
                $data->code = self::generateItemCode();
            }
            if (request()->has('description')) {
                $data->description = request()->input('description');
            }
        });

    }

    /* Generate Random ItemCode */
    protected static function generateItemCode(){

        $item_prefix = 'i-';
        $lastItemCode = self::orderBy('id', 'desc')->first();
        if(empty($lastItemCode->code) || empty($lastItemCode->code)){
            $number  = str_pad(1 , 5, "0", STR_PAD_LEFT);
        }
        else{
            $remove_prefix = substr($lastItemCode->code, 2);
            $number  = str_pad(($remove_prefix + 1) , 5, "0", STR_PAD_LEFT);
        }
        
        $item_code = $item_prefix . $number;

        while (self::where('code', $item_code)->exists()) {
            return self::generateItemCode();
        }

        return $item_code;
    }
}
