<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Items;
use App\Models\Orders;
use App\Models\PaymentTypes;
use App\Models\SalesTypes;
use App\Models\Solution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    //GetModel
    private function getModel(){
        return new Orders();
    }

    /* Get Table Column List */
    private function getColumns(){
        $columns = ['#','customer_name', 'domain_name', 'item_name', 'otc', 'mrc', 'yrc', 'bill_start', 'solution_type', 'quantity', 'sales_type', 'added_by'];
        return $columns;
    }

    /* Get DataTable Column List */
    private function getDataTableColumns(){
        $columns = ['#','customer_name', 'domain_name', 'item_name', 'otc', 'mrc', 'yrc', 'bill_start', 'solution_type', 'quantity', 'sales_type', 'added_by'];
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
            'pageTitle'         => 'Orders',
            'create'            => route('order_create')
        ];
        return view('datatable.table', $params);
    }

    /* Order create/edit view */
    public function create(Request $request){

        $params = [
            'page_title'          => 'Create',
            'customers'           => Customer::where('is_active', 1)->get(),
            'solutions'           => Solution::where('is_active', 1)->get(),
            'items'               => Items::where('is_active', 1)->get(),
            'payment_types'       => PaymentTypes::where('is_active', 1)->get(),
            'sales_types'         => SalesTypes::where('is_active', 1)->get(),
            'form_url'            => route('order_store')
        ];
        if(isset($request->id)){
            $order = Orders::find($request->id);
            if($order->added_by != current_user() && !is_admin()){
                set_alert('error', 'Access Denied');
                return back();
            }
            $params['order'] = $order;
            $params['page_title'] = 'Edit';
        }
        return view('admin.orders.create', $params);
    }

    /* Company store */
    public function store(Request $request){
        try{
            
            DB::beginTransaction();
            if( $request->id == 0 ){
                $data = $this->getModel();
                $data->added_by         =  current_user() ?? $request->user()->id;
                $message = "Order Added Successfully";
            }
            else{
                $data = $this->getModel()->find($request->id);
                $data->updated_by       =   current_user() ?? $request->user()->id;
                $message = "Order Updated Successfully";
            }

            $data->customer_id                = $request->customer_id;
            $data->advance_amount_percentage  = $request->advance_amount_percentage;
            $data->expected_gp_amount         = $request->expected_gp_amount;
            $data->item_id                    = $request->item_id;
            $data->otc_amount                 = $request->otc_amount;
            $data->mrc_amount                 = $request->mrc_amount;
            $data->yrc_amount                 = $request->yrc_amount;
            $data->vat                        = $request->vat;
            $data->comn_date                  = $request->comn_date;
            $data->bill_start                 = $request->bill_start;
            $data->solution_id                = $request->solution_id;
            $data->quantity                   = $request->quantity;
            $data->specification              = $request->specification;
            $data->comment                    = $request->comment;
            $data->payment_type_id            = $request->payment_type_id;
            $data->sale_type_id               = $request->sale_type_id;
            if($request->has('proposal')){
                $proposal = $request->file('proposal');
                $data->proposal = $this->uploadImage($proposal,$this->proposal, 'order');
            }
            if($request->has('workorder')){
                $workorder = $request->file('workorder');
                $data->workorder = $this->uploadImage($workorder,$this->workorder, 'order');
            }
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

    /* Order details */
    public function order_details(Request $request){
        if(!empty($request->id)){
            $order_details = Orders::find($request->id);
            if($order_details->added_by != current_user() && !is_admin()){
                set_alert('error', 'You don\'t have any permission to show is');
                return back();
            }
            $params = [
               'order_details' => $order_details
            ];
            return view('admin.orders.details', $params);
        }
    }

    public function getDataTable(){
        $customers = get_active_list('orders');
        $datatable =  DataTables::of($customers)
                                ->addColumn('#', function(){ return ++$this->index; })
                                ->addColumn('customer_name', function($row){
                                    $rowDetails = '<div class="row-option">';
                                    $rowDetails .= '<span>' . $row->customers->name . '</span>';
                                    $rowDetails .= '<div class="button-group mt-2">';
                                    $rowDetails .= '<a href="' . route('order_details', $row->id) . '" class="text-decoration-none">Details</a> '; 
                                    $rowDetails .= '| <a href="' . route('order_edit', $row->id) . '" class="text-decoration-none">Edit</a>'; 
                                    return $rowDetails; 
                                })
                                ->addColumn('domain_name', function($row){ return $row->customers->domain_name; })
                                ->addColumn('item_name', function($row){ return $row->items->name; })
                                ->addColumn('otc', function($row){ return $row->otc_amount; })
                                ->addColumn('mrc', function($row){ return $row->mrc_amount; })
                                ->addColumn('yrc', function($row){ return $row->yrc_amount; })
                                ->addColumn('bill_start', function($row){ return $row->bill_start; })
                                ->addColumn('solution_type', function($row){ return $row->soltuion_types->name; })
                                ->addColumn('quantity', function($row){ return $row->quantity; })
                                ->addColumn('sales_type', function($row){ return $row->sales_types->name; })
                                ->addColumn('added_by', function($row){ return get_user_name($row->added_by); })
                                ->rawColumns(['customer_name']);
                               

       
        
        return $datatable->make(true);
    }
}
