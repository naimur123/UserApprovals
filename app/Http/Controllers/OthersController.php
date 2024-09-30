<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\PaymentTypes;
use App\Models\SalesTypes;
use App\Models\Solution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class OthersController extends Controller
{
    /* Get Payment Types Model */
    private function getPaymentTypes(){
        return new PaymentTypes();
    }
    /* Get Sales Types Model */
    private function getSalesTypes(){
        return new SalesTypes();
    }
    /* Get Solutions Model */
    private function getSolution(){
        return new Solution();
    }
    /* Get Item Model */
    private function getItem(){
        return new Items();
    }

    /* Get Table Column List */
    private function getColumns($current_route){
        $columns = ['#'];
        if ($current_route == 'item_list') {
            $columns[] = 'item_code';
            $columns[] = "description";
        }
        $columns[] = 'types_name';
        $columns[] = 'added_by';
        $columns[] = 'action';
        return $columns;
    }

    /* Get DataTable Column List */
    private function getDataTableColumns($current_route){
        $columns = ['#'];
        if ($current_route == 'item_list') {
            $columns[] = 'code';
            $columns[] = "description";
        }
        $columns[] = 'types_name';
        $columns[] = 'added_by';
        $columns[] = 'action';
        return $columns;
    }

    /* Customer Dashboard */
    public function index(Request $request){
        $current_route = Route::currentRouteName();
        $pageTitle = '';
        $create = '';
        $columns = $this->getColumns($current_route);
        $dataTableColumns = $this->getDataTableColumns($current_route);
        if($current_route == 'payment_type_list'){
            $pageTitle = 'Payment Types';
            $create = route('payment_type_create');
        }else if($current_route == 'sales_type_list'){
            $pageTitle = 'Sales Types';
            $create = route('sales_type_create');
        }else if($current_route == 'solution_list'){
            $pageTitle = 'Solutions';
            $create = route('solution_create');
        }else if($current_route == 'item_list'){
            $pageTitle = 'Items';
            $create = route('item_create');
        }

        if( $request->ajax() ){
            return $this->getDataTable($current_route);
        }
        $params = [
            'tableColumns'      => $columns,
            'dataTableColumns'  => $dataTableColumns,
            'dataTableUrl'      => Null,
            'pageTitle'         => $pageTitle,
            'create'            => $create
        ];
        return view('datatable.table', $params);
    }

    /* Create view */
    public function create(Request $request){
        $current_route = Route::currentRouteName();
        $page_title = '';
        $store = '';
        if($current_route == 'payment_type_create'){
            $page_title = 'Payment Types';
            $store = route('payment_type_create');
        }else if($current_route == 'sales_type_create'){
            $page_title = 'Sales Types';
            $store = route('sales_type_create');
        }else if($current_route == 'solution_create'){
            $page_title = 'Solutions';
            $store = route('solution_create');
        }else if($current_route == 'item_create'){
            $page_title = 'Item';
            $store = route('item_create');
        }
        $params = [
            'page_title'    => $page_title . ' Create',
            'form_url'      => $store,
            'current_route' => $current_route
        ];
        return view('admin.others.create', $params);
    }

    /* Store */
    public function store(Request $request){
        try{
            $current_route = Route::currentRouteName();
            if($current_route == 'payment_type_store'){
                $table = $this->getPaymentTypes();
            }else if($current_route == 'sales_type_store'){
                $table = $this->getSalesTypes();
            }else if($current_route == 'solution_store'){
                $table = $this->getSolution();
            }else if($current_route == 'item_store'){
                $table = $this->getItem();
            }

            DB::beginTransaction();
            if( $request->id == 0 ){
                $data = $table;
                $data->added_by         =  current_user() ?? $request->user()->id;
            }
            else{
                $data = $table->find($request->id);
                $data->updated_by       =   current_user() ?? $request->user()->id;
            }

            $data->name = $request->name;
            $data->is_active = 1;
            $data->save();
            DB::commit();
            
            set_alert("success", 'Addedd Successfully');
            return back();

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function getDataTable($current_route){
        if($current_route == 'payment_type_list'){
            $get_data = get_active_list('payment_type');
        }else if($current_route == 'sales_type_list'){
            $get_data = get_active_list('sales_type');
        }else if($current_route == 'solution_list'){
            $get_data = get_active_list('solution');
        }else if($current_route == 'item_list'){
            $get_data = get_active_list('items');
        }

        $datatable =  DataTables::of($get_data)
                                ->addColumn('#', function(){ return ++$this->index; })
                                ->addColumn('types_name', function($row){ return $row->name; })
                                ->addColumn('added_by', function($row){ return get_user_name($row->added_by); })
                                ->addColumn('action', function($row){ return ''; });

        if ($current_route == 'item_list') {
            $datatable->addColumn('code', function($row) {
                return $row->code;
            });
            $datatable->addColumn('description', function($row) {
                return $row->description;
            });
        }
        
        return $datatable->make(true);
    }
}
