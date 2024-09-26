@extends('masterPage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12 mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                <form class="row form-horizontal" action="{{ $form_url }}" method="POST" enctype="multipart/form-data" id="customerAddEdit">
                    @csrf
                    <div class="col-12 mt-10">
                        <h3>Customer {{ $page_title ?? "" }}</h3>
                        <input type="hidden" name="id" value="{{ $customer->id ?? 0 }}">
                        <hr/>
                    </div>
    
                    <!-- Customer Name -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control " value="{{ old("name") ?? ($customer->name ?? "")}}" name="name">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Address -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control " value="{{ old("address") ?? ($customer->address ?? "")}}" name="address">
                            @error('address')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Contract Person Name -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Contract Person Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control " value="{{ old("contract_person_name") ?? ($customer->contract_person_name ?? "")}}" name="contract_person_name">
                            @error('contract_person_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Contract Person Number -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Contract Person Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control " value="{{ old("contract_person_number") ?? ($customer->contract_person_number ?? "")}}" name="contract_person_number">
                            @error('contract_person_number')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Contract Person Email -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Contract Person Email</label>
                            <input type="text" class="form-control " value="{{ old("contract_person_email") ?? ($customer->contract_person_email ?? "")}}" name="contract_person_email">
                            @error('contract_person_email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Domain Name -->
                    <div class="col-12 col-sm-6 col-md-4 my-2">
                        <div class="form-group">
                            <label>Domain Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control " value="{{ old("domain_name") ?? ($customer->domain_name ?? "")}}" name="domain_name">
                            @error('domain_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                  
                    <!--submit -->
                    <div class="col-12 text-right py-2">
                        <div class="form-group text-end">
                            <button type="button" class="btn btn-info" id="submitCustomer">Submit </button>
                        </div>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function(){
        $('#submitCustomer').click(function(){
            let requiredFields = [];
            requiredFields = ['name', 'contract_person_name', 'contract_person_number', 'domain_name'];
            if (validateInput(requiredFields)) {
                $('#customerAddEdit').submit();
            }
        });
    });
</script>
 
@endsection