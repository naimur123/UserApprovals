@extends('masterPage')

@section('content')
<div class="row mx-2">
    <div class="col-md-12">
        <div class="row">
            <!-- Active Users -->
            <div class="col-md-4">
                <div class="card bg-success bg-gradient">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($active_companies) }}</h4>
                                <h6 class="text-white mx-2">Total Active Companies</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('company_list') }}" class="text-white text-decoration-none">Active Companies</a>
                    </div>
                </div>
            </div>
            <!-- Pending Users -->
            <div class="col-md-4">
                <div class="card bg-warning bg-gradient">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($pending_companies) }}</h4>
                                <h6 class="text-white mx-2">Total Pending Companies</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('company_pending_list', 'pending') }}" class="text-white text-decoration-none">Pending Companies</a>
                    </div>
                </div>
            </div>
            <!-- Rejected Users -->
            <div class="col-md-4">
                <div class="card bg-danger bg-gradient">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($rejected_companies) }}</h4>
                                <h6 class="text-white mx-2">Total Rejected Companies</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('company_pending_list', 'rejected') }}" class="text-white text-decoration-none">Rejected Companies</a>
                    </div>
                </div>
            </div>  
        </div> 
    </div>
</div>

@endsection
