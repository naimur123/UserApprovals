@extends('masterPage')

@section('content')
<div class="row mx-2">
    <div class="col-md-12">
        <div class="row">
            <!-- Active Users -->
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($active_users) }}</h4>
                                <h6 class="text-white mx-2">Total Active Users</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('user_list') }}" class="text-white text-decoration-none">Active Users</a>
                    </div>
                </div>
            </div>
            <!-- Pending Users -->
            <div class="col-md-4">
                <div class="card bg-warning">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($pending_users) }}</h4>
                                <h6 class="text-white mx-2">Total Pending Users</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('user_pending_list', 'pending') }}" class="text-white text-decoration-none">Pending Users</a>
                    </div>
                </div>
            </div>
            <!-- Rejected Users -->
            <div class="col-md-4">
                <div class="card bg-danger">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white mx-2 my-2">{{ count($rejected_users) }}</h4>
                                <h6 class="text-white mx-2">Total Rejected Users</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('user_pending_list', 'rejected') }}" class="text-white text-decoration-none">Rejected Users</a>
                    </div>
                </div>
            </div>  
        </div> 
    </div>
</div>

@endsection
