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
        $item_code = 'i-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        while (self::where('code', $item_code)->exists()) {
            $item_code = 'i-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }

        return $item_code;
    }
}
