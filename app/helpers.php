<?php

/* Get alert Message */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

if(!function_exists('set_alert()')){
    function set_alert($type = '', $message = ''){
        clear_alert($type);
        session()->flash($type, $message);
    }
}

/* Clear alert */
if(!function_exists('clear_alert()')){
    function clear_alert($type = '') {
        session()->forget($type);
    }
}

/* Get Pending Users */
if(!function_exists('get_pending_users()')){
    function get_pending_users(){
        $users = DB::table('users as us')
        ->select('us.*')
        ->leftJoin('user_approvals as ap', 'ap.user_id', '=', 'us.id')
        ->whereNULL('ap.approve')
        ->where('us.is_active', 0)
        ->where('us.is_admin',0)->get();

        return $users;
    }
}

/* Get Pending Users */
if(!function_exists('get_rejected_users()')){
    function get_rejected_users(){
        $users = DB::table('users as us')
        ->select('us.*')
        ->leftJoin('user_approvals as ap', 'ap.user_id', '=', 'us.id')
        ->where('ap.approve', 2)
        ->where('us.is_active', 0)
        ->where('us.is_approved', 2)
        ->where('us.is_admin',0)->get();

        return $users;
    }
}

/* Get Route Names */

if (!function_exists('getRouteName')) {
    function getRouteName()
    {
        $routeName = Route::currentRouteName();
        $requestList = request()->route('request_list');

        if ($requestList) {
            return ucfirst($requestList) . ' Users';
        }

        return str_replace('_', ' ', ucfirst($routeName)); 
    }
}

