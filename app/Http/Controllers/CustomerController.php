<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    //GetModel
    private function getModel(){
        return new Customer();
    }

    /* Get Table Column List */
    private function getColumns(){
        $columns = ['#', 'domain_name', 'customer_name', 'customer_address', 'customer_contract_person', 'customer_contract_person_number', 'added_by', 'action'];
        return $columns;
    }

    /* Get DataTable Column List */
    private function getDataTableColumns(){
        $columns = ['#', 'domain_name', 'customer_name', 'customer_address', 'customer_contract_person', 'customer_contract_person_number', 'added_by', 'action'];
        return $columns;
    }

    /* Customer Dashboard */
    public function index(Request $request){
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        $params = [
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Customers',
            'create'            => route('customer_create')
        ];
        return view('datatable.table', $params);
    }

    /* Create view */
    public function create(Request $request){
        $params = [
            'page_title'    => 'Create',
            'form_url' => route('customer_store')
        ];
        if(isset($request->id)){
            $company = Customer::find($request->id);
            if($company->added_by != current_user() && !is_admin()){
                set_alert('error', 'Access Denied');
                return back();
            }
            $params['company'] = $company;
        }
        return view('admin.customer.create', $params);
    }

    /* Company Store */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            if( $request->id == 0 ){
                $data = $this->getModel();
                $data->added_by         =  current_user() ?? $request->user()->id;
                $message = "Customer Added Successfully";
            }
            else{
                $data = $this->getModel()->find($request->id);
                $data->updated_by       =   current_user() ?? $request->user()->id;
                $message = "Customer Updated Successfully";
            }

            $data->name = $request->name;
            $data->address = $request->address;
            $data->contract_person_name = $request->contract_person_name;
            $data->contract_person_number = $request->contract_person_number;
            $data->contract_person_email = $request->contract_person_email;
            $data->domain_name = $request->domain_name;
            $data->is_active = 1;
            $data->save();
            DB::commit();
            
            set_alert("success", $message);
            return back();

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function getDataTable(){
        $customers = get_active_list('customers');
        $datatable =  DataTables::of($customers)
                                ->addColumn('#', function(){ return ++$this->index; })
                                ->addColumn('domain_name', function($row){ return $row->domain_name; })
                                ->addColumn('customer_name', function($row){ return ucwords($row->name); })
                                ->addColumn('customer_address', function($row){ return $row->address; })
                                ->addColumn('customer_contract_person', function($row){ return $row->contract_person_name; })
                                ->addColumn('customer_contract_person_number', function($row){ return $row->contract_person_number; })
                                ->addColumn('added_by', function($row){ return get_user_name($row->added_by); })
                                ->addColumn('action', function($row){ return ''; });

       
        
        return $datatable->make(true);
    }
}
