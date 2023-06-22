@extends('auth.login-layout')
@section('login-content')
    <div class="container">
        <div class="register-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <form method="POST" action="{{route('register-user')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$register ? $register->id : ''}}"/>
                        <div class="input-group mb-3">
                            <input type="text" name="fullname" value="{{old('fullname')}}" class="form-control" placeholder="Full name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger">
                            @error('fullname')
                            {{ $message }}
                            @enderror
                        </span>
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        <div class="input-group mb-3">
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control" placeholder="phone">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>

                        </div>
                        <span class="text-danger">
                                    @error('phone')
                            {{ $message }}
                            @enderror
                                </span>
                        <div class="form-group">

                            <div class="form-check">
                                <input class="form-check-input"
                                       {{ old('gender') == 0 ? 'checked="checked"' : ''  }}
                                       type="radio" value="0" name="gender">
                                <label class="form-check-label">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="form-check-input" type="radio"
                                       {{ old('gender') == 1 ? 'checked="checked"' : '' }}
                                       value="1" name="gender">
                                <label class="form-check-label">Female</label>
                            </div>

                        </div>
                        <span class="text-danger">
                                    @error('gender')
                            {{ $message }}
                            @enderror
                                </span>
                        <div class="row">
                            <div class="col-8">

                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    {{--                    <div class="social-auth-links text-center">--}}
                    {{--                        <a href="#" class="btn btn-block btn-primary">--}}
                    {{--                            <i class="fab fa-facebook mr-2"></i>--}}
                    {{--                            Sign up using Facebook--}}
                    {{--                        </a>--}}
                    {{--                        <a href="#" class="btn btn-block btn-danger">--}}
                    {{--                            <i class="fab fa-google-plus mr-2"></i>--}}
                    {{--                            Sign up using Google+--}}
                    {{--                        </a>--}}
                    {{--                    </div>--}}

                    <a href="{{route('login')}}" class="text-center">Already User?</a>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
        <!-- /.register-box -->
    </div>
@endsection

@push('script_push')

@endpush


