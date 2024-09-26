@extends('masterPage')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form class="row form-horizontal" action="{{ $form_url }}" method="POST" enctype="multipart/form-data" id="orderAddEdit">
                    @csrf
                    <div class="col-12 mt-10">
                        <h3>Order {{ $page_title ?? "" }}</h3>
                        <input type="hidden" name="id" value="{{ $order->id ?? 0 }}">
                        <hr/>
                    </div>
                    <div class="row">
                        <!-- Customer Name -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cusotmer name<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="customer_id" id="customer_id">
                                    <option value="">Select</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ (isset($order->customer_id) && $customer->id == $order->customer_id) ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Advance Amount -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Advance amount (in %) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " value="{{ old("advance_amount_percentage") ?? ($order->advance_amount_percentage ?? "")}}" name="advance_amount_percentage">
                                @error('advance_amount_percentage')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Expected GP -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Expected GP (in BDT) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " value="{{ old("expected_gp_amount") ?? ($order->expected_gp_amount ?? "")}}" name="expected_gp_amount">
                                @error('expected_gp_amount')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Insert Proposal (PDF) -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Insert Proposal </label>
                                @if(isset($order->proposal) && !empty($order->proposal))
                                    <div id="proposal_container">
                                        <a href="{{ asset('storage/' . $order->proposal) }}" target="_blank" class="text-decoration-none">
                                            {{ ucfirst(basename($order->proposal)) }}
                                        </a>
                                        <i class="fa-solid fa-square-xmark" style="cursor: pointer; margin-left: 10px;" id="proposal_delete"></i>
                                    </div>
                                    <input type="file" class="form-control" name="proposal" id="proposal_edit" style="display: none;">
                                @else
                                    <input type="file" class="form-control" name="proposal" id="proposal-input">
                                @endif
                            </div>
                        </div>

                        <!-- Insert Workorder (PDF) -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Insert Workorder </label>
                                @if(isset($order->workorder) && !empty($order->workorder))
                                    <div id="workorder_container">
                                        <a href="{{ asset('storage/' . $order->workorder) }}" target="_blank" class="text-decoration-none">
                                            {{ ucfirst(basename($order->workorder)) }}
                                        </a>
                                        <i class="fa-solid fa-square-xmark" style="cursor: pointer; margin-left: 10px;" id="workorder_delete"></i>
                                    </div>
                                    <input type="file" class="form-control" name="workorder" id="workorder_edit" style="display: none;">
                                @else
                                    <input type="file" class="form-control" name="workorder">
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Item Name -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Item name <span class="text-danger">*</span></label>
                                <select class="form-control" name="item_id" id="item_id">
                                    <option value="">Select</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" {{ (isset($order->item_id) && $item->id == $order->item_id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- OTC -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>OTC (BDT) </label>
                                <input type="text" class="form-control " value="{{ old("otc_amount") ?? ($order->otc_amount ?? "")}}" name="otc_amount">
                                @error('otc_amount')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- MRC -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>MRC (BDT) </label>
                                <input type="text" class="form-control " value="{{ old("mrc_amount") ?? ($order->mrc_amount ?? "")}}" name="mrc_amount">
                                @error('mrc_amount')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- YRC -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>YRC (BDT) </label>
                                <input type="text" class="form-control " value="{{ old("yrc_amount") ?? ($order->yrc_amount ?? "")}}" name="yrc_amount">
                                @error('yrc_amount')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- VAT -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>VAT% </label>
                                <input type="text" class="form-control " value="{{ old("vat") ?? ($order->vat ?? "")}}" name="vat">
                                @error('vat')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Comn Date -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Comn Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                   <input type="text" class="form-control datepicker" name="comn_date" value="{{ $order->comn_date ?? "" }}">
                                   <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('comn_date')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Bill Date -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Bill Start <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="bill_start" value="{{ $order->bill_start ?? "" }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('bill_start')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Solutions -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Solution Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="solution_id" id="solution_id">
                                    <option value="">Select</option>
                                    @foreach($solutions as $solution)
                                        <option value="{{ $solution->id }}" {{ (isset($order->solution_id) && $solution->id == $order->solution_id) ? 'selected' : '' }}>{{ $solution->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Quantity </label>
                                <input type="number" class="form-control" value="{{ old("quantity") ?? ($order->quantity ?? "")}}" name="quantity">
                                @error('quantity')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Specification -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Specification </label>
                                <input type="text" class="form-control " value="{{ old("specification") ?? ($order->specification ?? "")}}" name="specification">
                                @error('specification')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Comment </label>
                                <textarea class="form-control " name="comment">{{ old("comment") ?? ($order->comment ?? "") }}</textarea>
                                @error('comment')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Types -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Payment Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="payment_type_id" id="payment_type_id">
                                    <option value="">Select</option>
                                    @foreach($payment_types as $payment_type)
                                        <option value="{{ $payment_type->id }}" {{ (isset($order->payment_type_id) && $payment_type->id == $order->payment_type_id) ? 'selected' : '' }}>{{ $payment_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Sales Types -->
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label>Sales Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="sale_type_id" id="sale_type_id">
                                    <option value="">Select</option>
                                    @foreach($sales_types as $sales_type)
                                        <option value="{{ $sales_type->id }}" {{ (isset($order->sale_type_id) && $sales_type->id == $order->sale_type_id) ? 'selected' : '' }}>{{ $sales_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--submit -->
                    <div class="col-12 text-right py-2">
                        <div class="form-group text-left">
                            <button type="button" class="btn btn-success" id="submitOrder">Submit </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function(){
        $("#proposal_delete").on('click', function(){
            $('#proposal_container').addClass('d-none');
            $('#proposal_edit').removeClass('d-none').show(); 
        });

        $("#workorder_delete").on('click', function(){
            $('#workorder_container').addClass('d-none');
            $('#workorder_edit').removeClass('d-none').show(); 
        });


        $('#submitOrder').click(function(){
            let requiredFields = [];
            requiredFields = ['advance_amount_percentage', 'expected_gp_amount', 'comn_date', 'bill_start'];
            if (validateInput(requiredFields)) {
                $('#orderAddEdit').submit();
            }
        });
      
    });
</script>
 
@endsection