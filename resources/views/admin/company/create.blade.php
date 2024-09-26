@extends('masterPage')

@section('content')
 <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Progress Bar -->
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 33%;" id="progressBar"></div>
                </div>
                <form class="row form-horizontal" action="{{ route('company_store') }}" method="POST" id="companyAddEdit" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1 -->
                    <div class="step step-1">
                        <input type="hidden" name="id" value="{{ $company->id ?? 0 }}">
                        <br>
                        <h3>Company Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old("name") ?? ($company->name ?? "")}}">
                            </div>
                            <div class="col-md-6">
                                <label for="address">Company Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ old("address") ?? ($company->address ?? "")}}">
                            </div>
                            <div class="col-md-6">
                                <label for="email">Company Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="optional" value="{{ old("email") ?? ($company->email ?? "")}}">
                            </div>
                            <div class="col-md-6">
                                <label for="contract_name">Company Contract Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_name" id="contract_name" value="{{ old("contract_name") ?? ($company->contract_name ?? "")}}">
                            </div>
                            <div class="col-md-6">
                                <label for="contract_phone">Company Contract Phone<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_phone" id="contract_phone" value="{{ old("contract_phone") ?? ($company->contract_phone ?? "")}}">
                            </div>
                            <div class="col-md-6">
                                <label for="contract_department">Company Contract Department<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_department" id="contract_department" value="{{ old("contract_department") ?? ($company->contract_department ?? "")}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm text-end next-step">Next</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step step-2" style="display: none;">
                        <br>
                        <h3>Billing Information</h3>
                        <div class="col-md-12">
                            {{-- <div id="handsontable-wrapper"> --}}
                               <div id="billing-handsontable"></div>
                               <input type="hidden" name="billing_info" id="billing-data">
                            {{-- </div> --}}
                        </div>
                        <br>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary btn-sm prev-step">Previous</button>
                            <button type="button" class="btn btn-primary btn-sm next-step">Next</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step step-3" style="display: none;">
                        <br>
                        <h3>Technician Information</h3>
                        <div class="col-md-12">
                            {{-- <div id="handsontable-wrapper"> --}}
                                <div id="technician-handsontable"></div>
                                <input type="hidden" name="technician_info" id="technician-data">
                            {{-- </div> --}}
                        </div>
                        <br>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary btn-sm prev-step">Previous</button>
                            <button type="button" class="btn btn-primary btn-sm next-step">Next</button>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="step step-4" style="display: none;">
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <h3>M.D. Information</h3>
                                <div class="mb-3">
                                    <label for="md_name">Name</label>
                                    <input type="text" class="form-control" name="md_name" id="md_name" value="{{ old("md_name") ?? ($company->md_name ?? "")}}">
                                </div>
                                <div class="mb-3">
                                    <label for="md_phone">Phone number</label>
                                    <input type="text" class="form-control" name="md_phone" id="md_phone" value="{{ old("md_phone") ?? ($company->md_phone ?? "")}}">
                                </div>
                                <div class="mb-3">
                                    <label for="md_email">Email</label>
                                    <input type="text" class="form-control" name="md_email" id="md_email" placeholder="optional" value="{{ old("md_email") ?? ($company->md_email ?? "")}}">
                                </div>
                            </div>
                        
                            <div class="col-md-1 d-flex align-items-stretch justify-content-center">
                                <div class="vr" style="height: 100%"></div>
                            </div>
                        
                            <div class="col-md-5">
                                <h3>Chairman Information</h3>
                                <div class="mb-3">
                                    <label for="chairman_name">Name</label>
                                    <input type="text" class="form-control" name="chairman_name" id="chairman_name" value="{{ old("chairman_name") ?? ($company->chairman_name ?? "")}}">
                                </div>
                                <div class="mb-3">
                                    <label for="chairman_phone">Phone number</label>
                                    <input type="text" class="form-control" name="chairman_phone" id="chairman_phone" value="{{ old("chairman_phone") ?? ($company->chairman_phone ?? "")}}">
                                </div>
                                <div class="mb-3">
                                    <label for="chairman_email">Email</label>
                                    <input type="text" class="form-control" name="chairman_email" id="chairman_email" placeholder="optional" value="{{ old("chairman_email") ?? ($company->chairman_email ?? "")}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Trade License<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="trade_license">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary btn-sm prev-step">Previous</button>
                            <button type="button" class="btn btn-success btn-sm hide" id="submitForm">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>

 <script type="module">
    $(document).ready(function () {
        const steps = $('.step');
        const progressBar = $('#progressBar');
        let currentStep = 0;
        let billingHot = null;
        let technicianHot = null;
        // let billingData = [];
        var billingData = [
            @if(old('billing_info'))
                {!! old('billing_info') !!}
            @elseif(isset($company->billing_info))
                 @php
                     $billing_infos = json_decode($company->billing_info);
                 @endphp
                @foreach($billing_infos as $billing_info)
                  ["{{ $billing_info->customer_name }}", "{{ $billing_info->customer_phone }}", "{{ $billing_info->customer_email }}", "{{ $billing_info->customer_designation }}"],
                @endforeach
            @else
                ["", "", "", ""]
            @endif
        ];

        var technicianData = [
            @if(old('technician_info'))
                {!! old('technician_info') !!}
            @elseif(isset($company->technician_info))
                 @php
                     $technician_infos = json_decode($company->technician_info);
                 @endphp
                @foreach($technician_infos as $technician_info)
                  ["{{ $technician_info->technician_name }}", "{{ $technician_info->technician_phone }}", "{{ $technician_info->technician_email }}", "{{ $technician_info->technician_designation }}"],
                @endforeach
            @else
                ["", "", "", ""]
            @endif
        ];
        // let technicianData = [];

        // var trade_license = $('#trade_license').val();
        // alert(trade_license);
        
        function showStep(step) {
            steps.each(function (index) {
                $(this).css('display', index === step ? 'block' : 'none');
            });

            if (step === 0) {
                progressBar.css('width', '25%');
            } else if (step === 1) {
                progressBar.css('width', '50%');
                if (!billingHot) {
                    billingHandson();
                } else {
                    billingHot.render();
                }
            } else if (step === 2) {
                progressBar.css('width', '75%');
                if (!technicianHot) {
                    technicianHandson();
                } else {
                    technicianHot.render();
                }
            } else if (step === 3) {
                progressBar.css('width', '100%');
            }
        }

        $('.next-step').click(function () {
            if (currentStep === 0) {
                let requiredFields = [];
                requiredFields = ['name', 'address', 'contract_name', 'contract_phone', 'contract_department'];
                /* Validate the current step before proceeding */
                if (validateInput(requiredFields)) {
                    currentStep++;
                    showStep(currentStep);
                }
            } 
            else if (currentStep === 1) {
                const billingData = billingHot.getData();
                let from = 'billing';
                /* Validate the current step before proceeding */
                if (validateHandson(billingData, from)) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else if (currentStep === 2) {
                const technicianData = technicianHot.getData();
                let from = 'technician';
                /* Validate the current step before proceeding */
                if (validateHandson(technicianData, from)) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });

        $('.prev-step').click(function () {
            currentStep--;
            showStep(currentStep);
        });

        $('#submitForm').click(function(){
            let requiredFields = [];
            @if(!isset($company->trade_license))
               requiredFields = ['trade_license'];
            @endif
            
            if (validateInput(requiredFields)) {
                const billingData = billingHot.getData();
                const technicianData = technicianHot.getData();
                $('#billing-data').val(JSON.stringify(billingData));
                $('#technician-data').val(JSON.stringify(technicianData));
                $('#companyAddEdit').submit();
            }
        });

        showStep(currentStep);

        /* Billing handson */
        function billingHandson() {
            var container = document.getElementById('billing-handsontable');
            billingHot = new Handsontable(container, { 
                licenseKey: 'non-commercial-and-evaluation',
                data: billingData,
                startRows: 1,
                startCols: 4,
                rowHeaders: true,
                colHeaders: ['Customer Name', 'Customer Phone', 'Customer Email', 'Customer Designation'],
                columns: [
                    { 
                        data: 0, 
                        type: 'text'
                    },
                    {  
                        data: 1, 
                        type: 'text'
                    },
                    {
                        data: 2, 
                        type: 'text'
                    },
                    {
                        data: 3, 
                        type: 'text'
                    },
                ],
                stretchH: 'all',
                minSpareRows: 1,
                autoWrapRow: true,
                autoWrapCol: true,
                contextMenu: true,
                rowHeights: 40,
                width: '100%',
            });
        }

        /* Technician handson */
        function technicianHandson() {
            var container = document.getElementById('technician-handsontable');
            technicianHot = new Handsontable(container, {
                licenseKey: 'non-commercial-and-evaluation',
                data: technicianData,
                startRows: 1,
                startCols: 4,
                rowHeaders: true,
                colHeaders: ['Technician Name', 'Technician Phone', 'Technician Email', 'Technician Designation'],
                columns: [
                    {
                        data: 0, 
                        type: 'text'
                    },
                    {
                        data: 1, 
                        type: 'text'
                    },
                    {
                        data: 2, 
                        type: 'text'
                    },
                    {
                        data: 3, 
                        type: 'text'
                    },
                ],
                stretchH: 'all',
                minSpareRows: 1,
                autoWrapRow: true,
                autoWrapCol: true,
                contextMenu: true,
                rowHeights: 40,
                width: '100%',
            });
        }

   });

 </script>
 
@endsection