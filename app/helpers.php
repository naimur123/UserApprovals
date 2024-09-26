<?php

/* Get alert Message */

use App\Models\Approvals;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Items;
use App\Models\Orders;
use App\Models\PaymentTypes;
use App\Models\SalesTypes;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/* Is admin or not */
if(!function_exists('is_admin()')){
    function is_admin(){
       if(Auth::user()->is_admin == 1)
          return true;
       else
          return false;
    }
}

/* Current user */
if(!function_exists('current_user()')){
    function current_user(){
        return Auth::check() ? Auth::user()->id : false;
    }
}

/* Get User full name by id */
if(!function_exists('get_user_name()')){
    function get_user_name($id = ''){
        if(!empty($id)){
            $user = User::find($id);
            if(!empty($user))
                return $user->full_name;
            else
               return '';
            
            
        }
        else{
            return Auth::check() ? Auth::user()->full_name : '';
        }
        
    }
}

/* Set Alert */
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

/* Get active list */
if (!function_exists('get_active_list')) {
    function get_active_list($rel_type)
    {
        $models = [
            'companies' => Company::class,
            'customers' => Customer::class,
            'payment_type' => PaymentTypes::class,
            'sales_type' => SalesTypes::class,
            'solution' => Solution::class,
            'items' => Items::class,
            'orders' => Orders::class
        ];
    
        if (!array_key_exists($rel_type, $models)) {
            return '';
        }
    
        $model = $models[$rel_type];
    
        return $model::where('is_active', 1)
                     ->when(!is_admin(), function($query) {
                         return $query->where('added_by', current_user());
                     })
                     ->get();
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
                                    ->where('co.is_active', 0)
                                    ->where('co.approve_status', 1)
                                    ->when(!is_admin(), function($query) {
                                        return $query->where('co.added_by', current_user());
                                    }, function($query) {
                                        return $query->where('ap.user_id', Auth::user()->id);
                                    })
                                    ->get();
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
                                    ->where('co.approve_status', 3)
                                    ->when(!is_admin(), function($query) {
                                        return $query->where('added_by', current_user());
                                    })->get();
        }
        
        return $rejected_list;
    }
}

