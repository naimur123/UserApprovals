<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    //GetModel
    private function getModel(){
        return new Company();
    }

     /* Get Table Column List */
     private function getColumns(){
        $columns = ['#', 'company_name', 'company_address', 'company_email'];
        return $columns;
    }

    /* Get DataTable Column List */
    private function getDataTableColumns(){
        $columns = ['#', 'company_name', 'company_address', 'company_email'];
        return $columns;
    }

    /* Company Dashboard */
    public function index(Request $request){
        $company_list = '';
        $pageTitle = 'Comapny List';
        $columns = $this->getColumns();
        $dataTableColumns = $this->getDataTableColumns();
        if(isset($request->request_list)){
            if($request->request_list == 'pending'){
                $company_list = 'pending';
                $columns[] = "action";
                $dataTableColumns[] = "action";
                $pageTitle = 'Pending Company List';
            }else{
                $company_list = 'rejected';
                $pageTitle = 'Rejected Company List';
            }
            
        }
        if( $request->ajax() ){
            return $this->getDataTable($company_list);
        }
        $params = [
            'tableColumns'      => $columns,
            'dataTableColumns'  => $dataTableColumns,
            'dataTableUrl'      => Null,
            'pageTitle'         => $pageTitle ,
            'create'            => route('company_create')
        ];
        return view('datatable.table', $params);
    }

    /* Create view */
    public function create(Request $request){
        return view('admin.company.create');
    }

    /* Company Store */
    public function store(Request $request){
        try{
            $billing_info = [];
            $technician_info = [];
            if(!empty($request->billing_info)){
                $decodedBillingInfos = json_decode($request->billing_info, true);
                foreach($decodedBillingInfos as $billing_infos){
                    if(!is_null($billing_infos) && array_filter($billing_infos)){
                        $billing_info[] = [
                            'customer_name' => $billing_infos[0],
                            'customer_phone' => $billing_infos[1],
                            'customer_email' => $billing_infos[2],
                            'customer_designation' => $billing_infos[3],
                        ];
                    }
                }
            }
            $billing_info_json = json_encode($billing_info);

            if(!empty($request->technician_info)){
                $decodedTechinicansInfos = json_decode($request->technician_info, true);
                foreach($decodedTechinicansInfos as $technician_infos){
                    if(!is_null($technician_infos) && array_filter($technician_infos)){
                        $technician_info[] = [
                            'technician_name' => $technician_infos[0],
                            'technician_phone' => $technician_infos[1],
                            'technician_email' => $technician_infos[2],
                            'technician_designation' => $technician_infos[3],
                        ];
                    }
                }
            }
            $technician_info_json = json_encode($technician_info);
            
            DB::beginTransaction();
            $data = $this->getModel();
            $data->name                 =  $request->name;
            $data->address              =  $request->address;
            $data->email                =  $request->email;
            $data->contract_name        =  $request->contract_name;
            $data->contract_phone       =  $request->contract_phone;
            $data->contract_department  =  $request->contract_department;
            $data->billing_info         =  $billing_info_json;
            $data->technician_info      =  $technician_info_json;
            $data->md_name              =  $request->md_name;
            $data->md_phone             =  $request->md_phone;
            $data->md_email             =  $request->md_email;
            $data->chairman_name        =  $request->chairman_name;
            $data->chairman_phone       =  $request->chairman_phone;
            $data->chairman_email       =  $request->chairman_email;
            if($request->has('trade_license')){
                $trade_license = $request->file('trade_license');
                $data->trade_license = $this->uploadImage($trade_license,$this->trade_license);
            }
            $data->is_active = 0;
            $data->approve_status = 1;
            $data->save();
            DB::commit();
            $approval_data = [
                'rel_id' => $data->id,
                'rel_type' => 'companies'
            ];
            auto_send_approval_request($approval_data);
            set_alert("success", "Company Added Successfully");
            return back();

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /* COmpany Details */
    public function company_details(Request $request){
        if(!empty($request->id)){
            $company = Company::find($request->id);
            $params = [
               'company_details' => $company
            ];
            return view('admin.company.details', $params);
        }  
    }

    public function getDataTable($company_list = ''){
        if(!empty($company_list) && $company_list == 'pending'){
            $company = get_pending_approvals('companies');
        }else if(!empty($company_list) && $company_list == 'rejected'){
            $company = get_rejected_list('companies');
        }else{
            $company = Company::where('is_active', 1)->get();
        }
        $datatable =  DataTables::of($company)
            ->addColumn('#', function(){ return ++$this->index; })
            ->addColumn('company_name', function($row){ return $row->name; })
            ->addColumn('company_address', function($row){ return ucwords($row->address); })
            ->addColumn('company_email', function($row){ return $row->email; });

        if($company_list === ''){
            $datatable->addColumn('company_name', function($row) {
                $rowDetails = '<div class="row-option">';
                $rowDetails .= '<span>' . $row->name . '</span>';
                $rowDetails .= '<div class="button-group mt-2">';
                $rowDetails .= '<a href="' . route('company_details', $row->id) . '" class="text-decoration-none">Details</a> ';
                // $rowDetails .= ' <a href="#" class="text-decoration-none">Edit</a> ';
                $rowDetails .= '</div>';
                $rowDetails .= '</div>';
                return $rowDetails;
            })->rawColumns(['company_name']);
        }
        else{
            $datatable->addColumn('company_name', function($row) { return $row->name; });
        }

        if ($company_list == 'pending') {
            $datatable->addColumn('action', function($row) {
                $rel_type = "companies";
                $actions = '<a href="#" class="btn btn-success btn-sm" onclick="approve_request(' . $row->id . ', 2, \'' . $rel_type . '\')"><i class="fa-solid fa-check"></i></a>';
                $actions  .= ' <a href="#" class="btn btn-danger btn-sm" onclick="approve_request(' . $row->id . ', 3, \'' . $rel_type . '\')"><i class="fa-solid fa-ban"></i></a>';
                return $actions;
            });
        }
        
        return $datatable->make(true);
    }
}
