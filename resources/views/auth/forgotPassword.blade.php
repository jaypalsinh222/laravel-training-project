@extends('auth.login-layout')
@section('login-content')
    <div class="container">

        <form method="POST" action="{{route('email-check')}}">
            @csrf
            <div class="login-box" style="display: inline-block;margin-left:370px;margin-top: 280PX ">

                <!-- /.login-logo -->
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="" class="h1"><b>Admin</b>LTE</a>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter Your Registered Email">
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
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <p class="mb-1">
                            <a href="{{route('login')}}">Already User?</a>
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

