@extends('masterPage')

@section('content')
 <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="d-flex justify-content-center fw-bold">Company Details</h5>
                <hr>
                {{-- Company Information --}}
                <table class="table">
                    <h5 class="fw-bold" width="30%">Company Information</h5>
                    <tr>
                       <td class="bold" width="30%">Company Name</td>
                       <td >{{ $company_details->name }}</td>
                    </tr>
                    <tr>
                       <td class="bold" width="30%">Company Address</td>
                       <td >{{ $company_details->address }}</td>
                    </tr>
                    <tr>
                       <td class="bold" width="30%">Company Email</td>
                       <td >{{ $company_details->email }}</td>
                    </tr>
                    <tr >
                       <td class="bold" width="30%">Company Contract Name</td>
                       <td >{{ $company_details->contract_name }}</td>
                    </tr>
                    <tr >
                       <td class="bold" width="30%">Company Contract Phone</td>
                       <td >{{ $company_details->contract_phone }}</td>
                    </tr>
                    <tr >
                       <td class="bold" width="30%">Company Contract Department</td>
                       <td >{{ $company_details->contract_department }}</td>
                    </tr> 
                </table>
                <hr>

                {{-- Billing Information --}}
                <div class="row">
                    <h5 class="fw-bold" width="30%">Billing Information</h5>
                    @if (!empty($company_details->billing_info))
                        @php
                            $billing_infos = json_decode($company_details->billing_info);
                        @endphp
                        @forelse ($billing_infos as $index => $billing_info)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header fw-bold">Bill Info {{ $index + 1 }}</div>
                                    <div class="card_body">
                                        <table class="table">
                                            @foreach (['Name' => 'customer_name', 'Phone' => 'customer_phone', 'Email' => 'customer_email', 'Designation' => 'customer_designation'] as $label => $field)
                                                <tr>
                                                    <td class="bold" width="30%">{{ $label }}</td>
                                                    <td>{{ $billing_info->$field }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No billing information available.</p>
                        @endforelse
                    @endif
                </div>
               
                <hr>

                {{-- Technician Information --}}
                <div class="row">
                    <h5 class="fw-bold" width="30%">Technician Information</h5>
                    @if (!empty($company_details->technician_info))
                        @php
                            $technician_infos = json_decode($company_details->technician_info);
                        @endphp
                        @forelse ($technician_infos as $index => $technician_info)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header fw-bold">Technician Info {{ $index + 1 }}</div>
                                    <div class="card_body">
                                        <table class="table">
                                            @foreach (['Name' => 'technician_name', 'Phone' => 'technician_phone', 'Email' => 'technician_email', 'Designation' => 'technician_designation'] as $label => $field)
                                                <tr>
                                                    <td class="bold" width="30%">{{ $label }}</td>
                                                    <td>{{ $technician_info->$field }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No technician information available.</p>
                        @endforelse
                    @endif
                </div>
                
                <hr>

                <h5 class="fw-bold" width="30%">Other Information</h5>
                <br>
                <div class="row">
                    <div class="col-md-5">
                        <h5>M.D. Information</h5>
                        <table class="table">
                            <tr>
                               <td class="bold" width="30%">Name</td>
                               <td >{{ $company_details->md_name }}</td>
                            </tr>
                            <tr>
                               <td class="bold" width="30%">Phone</td>
                               <td >{{ $company_details->md_phone }}</td>
                            </tr>
                            <tr>
                               <td class="bold" width="30%">Email</td>
                               <td >{{ $company_details->md_email }}</td>
                            </tr>
                        </table>
                    </div>
                
                    <div class="col-md-1 d-flex align-items-stretch justify-content-center">
                        <div class="vr" style="height: 100%"></div>
                    </div>
                
                    <div class="col-md-5">
                        <h5>Chairman Information</h5>
                        <table class="table">
                            <tr>
                                <td class="bold" width="30%">Name</td>
                                <td >{{ $company_details->chairman_name }}</td>
                            </tr>
                            <tr>
                                <td class="bold" width="30%">Phone</td>
                                <td >{{ $company_details->chairman_phone }}</td>
                            </tr>
                            <tr>
                                <td class="bold" width="30%">Email</td>
                                <td >{{ $company_details->chairman_email }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <p class="fw-bold">
                        Trade License: 
                        <a href="{{ asset('storage/' . $company_details->trade_license) }}" class="text-decoration-none" download>
                            {{ basename($company_details->trade_license) }}
                        </a>
                    </p>
                </div>
                

            </div>
        </div>
    </div>
 </div>

@endsection