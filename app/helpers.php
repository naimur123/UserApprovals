<?php

/* Get alert Message */

use App\Models\Approvals;
use Illuminate\Support\Facades\Auth;
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

/* Auto send Approval request */
if (!function_exists('auto_send_approval_request')) {
    function auto_send_approval_request($approval_data)
    {
        $data = new Approvals();
        $data->rel_id     =  $approval_data['rel_id'];
        $data->rel_type   =  $approval_data['rel_type'];
        $data->user_id    =  1;
        $data->save();
    }
}

/* Get Pending Approvals */
if (!function_exists('get_pending_approvals')) {
    function get_pending_approvals($rel_type)
    {
        $pending_approvals = '';
        if($rel_type === 'companies'){
            $pending_approvals = DB::table('companies as co')
                                    ->select('co.*')
                                    ->leftJoin('approvals as ap', 'ap.rel_id', '=', 'co.id')
                                    ->whereNull('ap.approve')
                                    ->where('ap.user_id', Auth::user()->id)
                                    ->where('co.is_active', 0)
                                    ->where('co.approve_status', 1)->get();
        }
        
        return $pending_approvals;
    }
}

/* Get Rejected List */
if (!function_exists('get_rejected_list')) {
    function get_rejected_list($rel_type)
    {
        $rejected_list = '';
        if($rel_type === 'companies'){
            $rejected_list = DB::table('companies as co')
                                    ->select('co.*')
                                    ->leftJoin('approvals as ap', 'ap.rel_id', '=', 'co.id')
                                    ->where('ap.approve', 3)
                                    ->where('co.is_active', 0)
                                    ->where('co.approve_status', 3)->get();
        }
        
        return $rejected_list;
    }
}

