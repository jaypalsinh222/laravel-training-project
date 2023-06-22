@extends('user.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    {{--    <h1>Profile</h1>--}}
    <div class="container">
        <form method="POST" action="{{route('change.profile.password')}}">
            @csrf
            <div class="register-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <b>{{session()->get('user')->name}}</b>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Change Your Password Here</p>
                        <input type="hidden" name="id" value="">
                        <div class="input-group mb-3">
                            <input type="password" value=""
                                   class="form-control" name="old_password" id="" placeholder="Enter Old Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger">@error('old_password'){{ $message }}@enderror</span>
                        <div class="input-group mb-3">
                            <input type="password" value=""
                                   class="form-control" name="password" id="" placeholder="Enter Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
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
                        <span class="text-danger">@error('password_confirmation'){{ $message }}@enderror</span>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                            </div>
                            <!-- /.col -->
                        </div>


                    </div>
                    <!-- /.form-box -->
                </div><!-- /.card -->
            </div>
        </form>
        <!-- /.register-box -->
    </div>
@endsection

@push('script_push')

@endpush