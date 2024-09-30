<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /* Get Table Column List */
    private function getColumns(){
        $columns = ['#', 'user_name', 'full_name', 'email', 'phone'];
        return $columns;
    }

    /* Get DataTable Column List */

    private function getDataTableColumns(){
        $columns = ['#', 'user_name', 'full_name', 'email', 'phone'];
        return $columns;
    }

    public function index(Request $request){
        $user_list = '';
        $pageTitle = 'Users List';
        $columns = $this->getColumns();
        $dataTableColumns = $this->getDataTableColumns();
        if(isset($request->request_list)){
            if($request->request_list == 'pending'){
                $user_list = 'pending';
                $columns[] = "action";
                $dataTableColumns[] = "action";
                $pageTitle = 'Pending User List';
            }else{
                $user_list = 'rejected';
                $pageTitle = 'Rejected User List';
            }
            
        }
        if( $request->ajax() ){
            return $this->getDataTable($user_list);
        }
        $params = [
            'tableColumns'      => $columns,
            'dataTableColumns'  => $dataTableColumns,
            'dataTableUrl'      => Null,
            'pageTitle'         => $pageTitle ,
            'create'            => route('user_register')
        ];
   
        return view('datatable.table', $params);
    }


    /* Show Register Form */
    public function showRegisterForm(Request $request)
    {
        return view('admin.user.register');
    }

    /* Approve Pending Request */
    public function approve_pending_user(Request $request){
       if(!empty($request->id)){
           /* update approval details */
           $apporval_details = UserApproval::where('user_id', $request->id)->get();
           if(!empty($apporval_details)){
                UserApproval::where('user_id', $request->id)->update([ 
                    'approve' => $request->approve_staus,
                    'approved_by' => ($request->approve_staus == 1) ? Auth::user()->id : NULL,
                    'rejected_by' => ($request->approve_staus == 2) ? Auth::user()->id : NULL,
                ]);

                /* update main table */
                $user = User::find($request->id);
                if(!empty($user)){
                    $user->is_active = ($request->approve_staus == 1) ? 1 : 0;
                    $user->is_approved = $request->approve_staus;
                    $user->save();
                }
                $message = '';
                $message = ($request->approve_staus == 1) ? 'approved' : 'rejected';
                return response()->json([
                    'success' => true,
                    'alert_message' => ucfirst($message) . ' Successfully'
                ]);
           }
           
       }
    }

    /* Get user ajax */
    public function get_user(Request $request){
        $user = User::find($request->id);
        if( $request->ajax() ){
            if(!empty($user)){
                return response()->json([
                    'success' => true,
                    'user' => $user
                ]);
            }
        }
        if($user->id != current_user() && !is_admin()){
            set_alert('error', 'Not Allowed');
            return back();
        }
        $params = [
            'pageTitle' => 'Edit Profile',
            'user'      => $user
        ];
        return view('admin.user.register', $params);
    }

    /* Resend User Approve Request */
    public function resend_user_approve_request(Request $request){
       $resend_users =  User::leftJoin('user_approvals', 'users.id', '=', 'user_approvals.user_id')
            ->whereNull('users.is_approved')
            ->where('users.is_active', 0)
            ->whereNull('user_approvals.user_id')
            ->select('users.*')
            ->get();

        foreach($resend_users as $users){
            $approval = new UserApproval();
            $approval->user_id = $users->id;
            $approval->save();
        }
        set_alert('success', 'User Approve request resend');
        return redirect('user_list');
    }

    public function getDataTable($user_list = ''){
        if(!empty($user_list) && $user_list == 'pending'){
            $users = get_pending_users();
        }else if(!empty($user_list) && $user_list == 'rejected'){
            $users = get_rejected_users();
        }else{
            $users = User::where('is_active', 1)->where('is_admin', 0)->get();
        }
        $datatable =  DataTables::of($users)
                                ->addColumn('#', function(){ return ++$this->index; })
                                ->addColumn('user_name', function($row){ return $row->user_name; })
                                ->addColumn('full_name', function($row){ return ucwords($row->full_name); })
                                ->addColumn('email', function($row){ return $row->email; })
                                ->addColumn('phone', function($row){ return $row->phone; });

        if($user_list === ''){
            $datatable->addColumn('user_name', function($row) {
                $rowDetails = '<div class="row-option">';
                $rowDetails .= '<span>' . $row->user_name . '</span>';
                $rowDetails .= '<div class="button-group mt-2">';
                $rowDetails .= '<a href="#" class="text-decoration-none" onclick="user_view(' . $row->id . ')">Details</a> ';
                $rowDetails .= '</div>';
                $rowDetails .= '</div>';
                return $rowDetails;
            })->rawColumns(['user_name']);
        }
        else{
            $datatable->addColumn('user_name', function($row) { return $row->user_name; });
        }

        if ($user_list == 'pending') {
            $datatable->addColumn('action', function($row) {
                $actions  = '<a href="#" class="btn btn-primary btn-sm" onclick="user_view(' . $row->id . ')"><i class="fa-solid fa-eye"></i></a>';
                $actions  .= ' <a href="#" class="btn btn-success btn-sm" onclick="approve_request(' . $row->id . ',' . 1 .')"><i class="fa-solid fa-check"></i></a>';
                $actions  .= ' <a href="#" class="btn btn-danger btn-sm" onclick="approve_request(' . $row->id . ',' . 2 .')"><i class="fa-solid fa-ban"></i></a>';
                return $actions;
            });
        }
        
        return $datatable->make(true);
    }
}
