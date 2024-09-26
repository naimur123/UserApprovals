@extends('masterPage')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form class="row form-horizontal" action="{{ $form_url }}" method="POST" enctype="multipart/form-data" id="othersAddEdit">
                    @csrf
                    <div class="col-12 mt-10">
                        <h3>{{ $page_title ?? "" }}</h3>
                        <input type="hidden" name="id" value="{{ $customer->id ?? 0 }}">
                        <hr/>
                    </div>
    
                    <!-- Name -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control " value="{{ old("name") ?? ($customer->name ?? "")}}" name="name">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>

                    @if(isset($current_route) && $current_route == 'item_create')
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " value="{{ old("description") ?? ($customer->name ?? "")}}" name="description">
                                @error('description')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    @endif
                  
                    <!--submit -->
                    <div class="col-12 text-right py-2">
                        <div class="form-group text-left">
                            <button type="button" class="btn btn-success" id="submitOthers">Submit </button>
                        </div>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function(){
        $('#submitOthers').click(function(){
            let requiredFields = [];
            requiredFields = ['name'];
            if (validateInput(requiredFields)) {
                $('#othersAddEdit').submit();
            }
        });
    });
</script>
 
@endsection