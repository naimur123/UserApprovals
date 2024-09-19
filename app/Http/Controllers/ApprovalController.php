<?php

namespace App\Http\Controllers;

use App\Models\Approvals;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /* Pending requst approve by rel_type */
   public function approve_request(Request $request){
    if(!empty($request->id)){
        /* update approval details */
        $apporval_details = Approvals::where('rel_id', $request->id)->where('rel_type', $request->rel_type)->where('user_id', Auth::user()->id)->get();
        if(!empty($apporval_details)){
             $updatedRows = Approvals::where('rel_id', $request->id)->where('rel_type', $request->rel_type)->update([ 
                 'approve' => $request->approve_staus,
                 'approved_by' => ($request->approve_staus == 2) ? Auth::user()->id : NULL,
                 'rejected_by' => ($request->approve_staus == 3) ? Auth::user()->id : NULL,
             ]);

             if($updatedRows > 0){
                $this->update_base_table($request);
             }

             $message = '';
             $message = ($request->approve_staus == 2) ? 'approved' : 'rejected';
             return response()->json([
                 'success' => true,
                 'alert_message' => ucfirst($message) . ' Successfully'
             ]);
        }
        
    }
   }

   public function update_base_table($data){
      if(!empty($data)){
        $rel_type = $data->rel_type;
        switch($rel_type){
            case 'companies':
                $company = Company::find($data->id);
                $company->approve_status = $data->approve_staus;
                $company->is_active = ($data->approve_staus == 2) ? 1 : 0;
                $company->save();
                break;
                
            default: break;
        }
      }
   }
}
