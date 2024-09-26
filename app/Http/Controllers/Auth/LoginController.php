<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo;
    protected $logout;

    function __construct()
    {
        $this->redirectTo = route("home");
        $this->logout = route("login");
    }

    // Show Login Form
    public function showloginform(Request $request){
        if( Auth::guard('user')->check() ){
            return redirect($this->redirectTo);
        }
        return view('auth.login');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username()   => 'required|string',
            'password'          => 'required|string|min:3',
        ]);
    }

    /**
     * After Logout the redirect location
     */
    protected function loggedOut(){
        Auth::guard('user')->logout();
        return redirect($this->logout);
    }

    // After Login Dashboard
    public function dashboard(Request $request){
        $params = [
        //    'active_users'  => User::where('is_active', 1)->get(),
        //    'pending_users' => get_pending_users(),
        //    'rejected_users' => get_rejected_users(),
           'active_companies'   => get_active_list('companies'),
           'pending_companies'  => get_pending_approvals('companies'),
           'rejected_companies' => get_rejected_list('companies'),
           'all_orders'         => get_active_list('orders')
        ];
        return view('admin.dashboard.home', $params);
    }
}
