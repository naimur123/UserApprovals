@extends('masterPage')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ $pageTitle ?? __('User Registration Form') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="userAddEdit" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id ?? 0 }}">
                    <div class="row mb-3">
                        <label for="full_name" class="col-md-4 col-form-label text-md-end">{{ __('Full Name') }}</label>

                        <div class="col-md-6">
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old("full_name") ?? ($user->full_name ?? "")}}" autocomplete="full_name">

                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?? ($user->phone ?? "") }}" autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? ($user->email ?? "") }}" autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                        @if(isset($user) && !empty($user->image))
                            <div class="col-md-6" id="profile_image">
                                <a ><img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle mb-2" alt="Profile Image"
                                    style="height: 80px; width: 80px;">
                                </a>
                                <i class="fa-solid fa-square-xmark" style="cursor: pointer; margin-left: 10px;" id="image_delete"></i>
                            </div>
                            <div class="col-md-6">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image_edit" style="display: none;">
                            </div>
                        @else
                         <div class="col-md-6">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                         </div>
                        @endif
                        {{-- <div class="col-md-6">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                        </div> --}}
                        @error('image')
                            <span class="text-danger text-center" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if (!isset($user))
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    @endif

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-primary" id="submitUser">
                                {{ isset($user) ? 'Update' : __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="module">
  $(document).ready(function(){
        $("#image_delete").on('click', function(){
            $('#profile_image').addClass('d-none');
            $('#image_edit').removeClass('d-none').show(); 
        });
        $('#submitUser').click(function(){
            let requiredFields = [];
            requiredFields = ['full_name', 'phone', 'email', 'password'];
            if (validateInput(requiredFields)) {
                $('#userAddEdit').submit();
            }
        });
  });
</script>
@endsection
