@extends('masterPage')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="d-flex justify-content-center fw-bold">Order Details</h5>
                <hr>
                <table class="table">
                    <tr>
                        <td class="bold">Customer Name</td>
                        <td>{{ $order_details->customers->name }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Customer Address</td>
                        <td>{{ $order_details->customers->address }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Contract Person Name</td>
                        <td>{{ $order_details->customers->contract_person_name }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Contract Person Number</td>
                        <td>{{ $order_details->customers->contract_person_number }}</td>
                    </tr>
                    @if(!empty($order_details->customers->contract_person_email))
                    <tr>
                        <td class="bold">Contract Person Email</td>
                        <td>{{ $order_details->customers->contract_person_email }}</td>
                    </tr>
                    @endif
                    @if(!empty($order_details->proposal))
                    <tr>
                        <td class="bold">Proposal</td>
                        <td>
                            <a href="{{ asset('storage/' . $order_details->proposal) }}" target="_blank" class="text-decoration-none">
                                {{ ucfirst(basename($order_details->proposal)) }}
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if(!empty($order_details->workorder))
                    <tr>
                        <td class="bold">Workorder</td>
                        <td>
                            <a href="{{ asset('storage/' . $order_details->workorder) }}" target="_blank" class="text-decoration-none">
                                {{ ucfirst(basename($order_details->workorder)) }}
                            </a>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="bold">Advance amount (in %) </td>
                        <td>{{ $order_details->advance_amount_percentage }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Expected GP (in BDT) </td>
                        <td>{{ $order_details->expected_gp_amount }}</td>
                    </tr>
                </table>   
                <hr>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive text-nowrap">
                            <table class="table custom_table">
                                <thead class="custom-header">
                                    <tr>
                                        <th >  Item Name     </th>
                                        <th >  OTC (BDT)     </th>
                                        <th >  MRC (BDT)     </th>
                                        <th >  YRC (BDT)     </th>
                                        <th >  VAT%          </th>
                                        <th >  Comn Date     </th>
                                        <th >  Bill Start    </th>
                                        <th >  Solution Type </th>
                                        <th >  Quantity      </th>
                                        <th >  Specification </th>
                                        <th >  Payment Type  </th>
                                        <th >  Sales Type    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr >
                                        <td> {{ $order_details->items->name          }} </td>
                                        <td> {{ $order_details->otc_amount           }} </td>
                                        <td> {{ $order_details->mrc_amount           }}  </td>
                                        <td> {{ $order_details->yrc_amount           }} </td>
                                        <td> {{ $order_details->vat                  }} </td>
                                        <td> {{ $order_details->comn_date            }} </td>
                                        <td> {{ $order_details->bill_start           }} </td>
                                        <td> {{ $order_details->soltuion_types->name }} </td>
                                        <td> {{ $order_details->quantity             }} </td>
                                        <td> {{ $order_details->specification        }} </td>
                                        <td> {{ $order_details->payment_types->name  }} </td>
                                        <td> {{ $order_details->sales_types->name    }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                 
                @if (!empty($order_details->comment))
                <br>
                <h5>Comment</h5>
                <p>{{ $order_details->comment }}</p>
                @endif
            </div>
        </div>
    </div>
 </div>
@endsection