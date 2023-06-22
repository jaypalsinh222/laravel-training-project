@extends('auth.login-layout')
@section('login-content')
    <div class="container">

        <form method="POST" action="{{route('check-login')}}">
            @csrf
            <div class="login-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">

                <!-- /.login-logo -->
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="" class="h1"><b>Admin</b>LTE</a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Please Log In to your Account</p>
                            <div class="input-group mb-3">
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        <span class="text-danger">
                                    @error('email')
                            {{ $message }}
                            @enderror
                                </span>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        <span class="text-danger">
                                    @error('password')
                            {{ $message }}
                            @enderror
                                </span>
                            <div class="row">
                                <div class="col-8">

                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->
                            </div>


                        {{--            <div class="social-auth-links text-center mt-2 mb-3">--}}
                        {{--                <a href="#" class="btn btn-block btn-primary">--}}
                        {{--                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
                        {{--                </a>--}}
                        {{--                <a href="#" class="btn btn-block btn-danger">--}}
                        {{--                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
                        {{--                </a>--}}
                        {{--            </div>--}}
                        <!-- /.social-auth-links -->

                        <p class="mb-1">
                            <a href="{{route('forgot-password')}}">forgot my password</a>
                        </p>
                        <p class="mb-0">
                            <a href="{{route('registerLogin')}}" class="text-center">Register!</a>
                        </p>
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

