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
                        <br>
                        <h3>Company Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="address">Company Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Company Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="optional">
                            </div>
                            <div class="col-md-6">
                                <label for="contract_name">Company Contract Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_name" id="contract_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contract_phone">Company Contract Phone<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_phone" id="contract_phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contract_department">Company Contract Department<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contract_department" id="contract_department" required>
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
                            <div id="billing-handsontable"></div>
                            <input type="hidden" name="billing_info" id="billing-data">
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
                            <div id="technician-handsontable"></div>
                            <input type="hidden" name="technician_info" id="technician-data">
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
                                    <input type="text" class="form-control" name="md_name" id="md_name">
                                </div>
                                <div class="mb-3">
                                    <label for="md_phone">Phone number</label>
                                    <input type="text" class="form-control" name="md_phone" id="md_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="md_email">Email</label>
                                    <input type="text" class="form-control" name="md_email" id="md_email" placeholder="optional">
                                </div>
                            </div>
                        
                            <div class="col-md-1 d-flex align-items-stretch justify-content-center">
                                <div class="vr" style="height: 100%"></div>
                            </div>
                        
                            <div class="col-md-5">
                                <h3>Chairman Information</h3>
                                <div class="mb-3">
                                    <label for="chairman_name">Name</label>
                                    <input type="text" class="form-control" name="chairman_name" id="chairman_name">
                                </div>
                                <div class="mb-3">
                                    <label for="chairman_phone">Phone number</label>
                                    <input type="text" class="form-control" name="chairman_phone" id="chairman_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="chairman_email">Email</label>
                                    <input type="text" class="form-control" name="chairman_email" id="chairman_email" placeholder="optional">
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
        let billingData = [];
        let technicianData = [];

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
            requiredFields = ['trade_license'];
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
                        type: 'text'},
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