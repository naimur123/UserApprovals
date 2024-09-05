<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($data) {
            if (empty($data->user_name)) {
                $data->user_name = self::generateUsername($data->email);
            }
        });

    }

    protected static function generateUsername($email){
        $extratUsername = Str::before($email, '@');
        $username = $extratUsername . '_' . rand(1000, 9999);

        while (self::where('user_name', $username)->exists()) {
            $username = $extratUsername . '_' . rand(0001, 9999);
        }

        return $username;
    }

    
}
