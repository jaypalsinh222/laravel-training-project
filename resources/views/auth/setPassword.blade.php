@extends('auth.login-layout')
@section('login-content')
    <div class="container">

        <form method="POST" action="{{route('set-new-password')}}">
            @csrf
            <div class="login-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">

                <!-- /.login-logo -->
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="" class="h1"><b>Admin</b>LTE</a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Change Your Password Here</p>
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <input type="hidden" name="token_key" value="{{$user->remember_token}}">
                            <div class="input-group mb-3">
                                <input type="password" value=""
                                       class="form-control" name="password" id="" placeholder="Enter Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        <span class="text-danger">
                                    @error('password')
                            {{ $message }}
                            @enderror
                                </span>
                            <div class="input-group mb-3">
                                <input type="password"
                                       value=""
                                       class="form-control" name="password_confirmation" id=""
                                       placeholder="Enter Confirm Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger">
                                        @error('password_confirmation')
                                {{ $message }}
                                @enderror
                                    </span>
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-6">

                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">New Password</button>
                                </div>
                                <!-- /.col -->
                            </div>



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </form>
    </div>
    <!-- /.login-box -->
@endsection

@push('script_push')

@endpush

