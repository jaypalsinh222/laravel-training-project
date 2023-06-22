@extends('user.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
{{--    <h1>Profile</h1>--}}
<div class="container">
    <div class="register-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b>{{session()->get('user')->name}}</b>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Change Your Profile Here</p>

                <form method="POST" action="{{route('profile.change')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{session()->get('user')->id}}"/>
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
                        <div class="col-5">
                            <a href="{{route('view.profile.password')}}">Change Password</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-7">
                            <button type="submit" class="btn btn-primary btn-block">Change Profile</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</div>
@endsection

@push('script_push')

@endpush