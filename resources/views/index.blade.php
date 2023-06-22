@extends('layouts.layout')
@section('main-content')

    <!-- left column -->
    <div class="container-fluid">
        <a href="{{ route('register.show') }}">
            <button type="button" class="col-sm-1 btn btn-block btn-outline-primary">List Register</button>
        </a>
        </br>
        <div class="row">

            <div class="col-md-12">

                {{--                 <td><a  class="btn btn-block btn-outline-primary">View Register</a></td>--}}
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Register</h3>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    {{--                    @if (session()->has('success'))--}}
                    {{--                        <div class="alert alert-success"></div>--}}
                    {{--                    @endif--}}
                    {{--                    @if (session()->has('fail'))--}}
                    {{--                        <div class="alert alert-danger">--}}
                    {{--                            @error('fail')--}}
                    {{--                                {{ $message }}--}}
                    {{--                            @enderror--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}

                    <form method="POST" action="" id="register" enctype="multipart/form-data">
                        <div>
                            <input type="hidden" name="id" id="id"
                                   value="{{ $details ? $details['id'] : '' }}"/>
                        </div>
                        <input type="hidden" id="test" name="hidden_name" value="12345">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control"
                                       value="{{ $details ? $details['name'] : old('name') }}" name="name"
                                       placeholder="Enter ...">
                                <span class="text-danger">
{{--                                    @error('name')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" {{ old('role') }} id="role" name="role">

                                    <option value="">Please select role</option>

                                    @foreach($roles as $data)
                                        @if($data->name == $role[0])
                                            <option selected value="{{$data->id}}">{{$data->name}}</option>
                                        @endif
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>

                                <span class="text-danger">
{{--                                    @error('state')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" value="{{ $details ? $details['email'] : old('email') }}"
                                       class="form-control" name="email" id="email" placeholder="Enter email">
                                <span class="text-danger">
{{--                                    @error('email')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>
                            @if(!$details)
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" value="{{ $details ? $details['password'] : old('password') }}"
                                           class="form-control" name="password" id="" placeholder="Enter Password">
                                    <span class="text-danger">
{{--                                    @error('password')--}}
                                        {{--                                        {{ $message }}--}}
                                        {{--                                    @enderror--}}
                                </span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Confirm Password</label>
                                    <input type="password"
                                           value="{{ $details ? $details['password'] : old('password_confirmation') }}"
                                           class="form-control" name="password_confirmation" id=""
                                           placeholder="Enter Confirm Password">
                                    <span class="text-danger">
{{--                                    @error('password_confirmation')--}}
                                        {{--                                        {{ $message }}--}}
                                        {{--                                    @enderror--}}
                                </span>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone</label>
                                <input type="text" value="{{ $details ? $details['phone'] : old('phone') }}"
                                       class="form-control" name="phone" {{ old('phone') }} id=""
                                       placeholder="Enter Phone Number">
                                <span class="text-danger">
{{--                                    @error('phone')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Country</label>
                                @if (!isset($details))
                                    <select class="form-control" {{ old('country') }} name="country" id="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="form-control" {{ old('country') }} name="country" id="country">
                                        @foreach ($countries as $list)
                                            @if ($country['state']['county_id'] == $list['id'])
                                                <option selected value="{{ $list['id'] }}">
                                                    {{ $list['name'] }}</option>
                                            @else
                                                <option value="{{ $list['id'] }}">{{ $list['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                                <span class="text-danger">
{{--                                    @error('country')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>
                            <div class="form-group">
                                <label>State</label>

                                <select class="form-control" {{ old('state') }} id="state" name="state">
                                    @if (!isset($details))
                                        <option value="">Please select state</option>
                                    @else
                                        <option selected value="{{ $country['state']['id'] }}">{{ $country['state']['name'] }}
                                        </option>
                                    @endif
                                </select>

                                <span class="text-danger">
{{--                                    @error('state')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>

                            <div class="form-group">
                                <label>City</label>
                                <select class="form-control" {{ old('city') }} id="city" name="city">
                                    @if (!isset($details))
                                        <option value="">Please select state</option>
                                    @else
                                        @foreach ($cities as $city)
                                            @if ($city['id'] == $details['city'])
                                                <option selected value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                                <span class="text-danger">
{{--                                    @error('city')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           {{ old('gender') == 0 || (isset($details) && $details['gender'] == 0) ? 'checked="checked"' : '' }}
                                           type="radio" value="0" name="gender">
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           {{ old('gender') == 1 || (isset($details) && $details['gender'] == 1) ? 'checked="checked"' : '' }}
                                           value="1" name="gender">
                                    <label class="form-check-label">Female</label>
                                </div>
                                <span class="text-danger">
{{--                                    @error('gender')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                            </div>
                            @if(!$details)
                                <div class="form-group">
                                    @php
                                        $details ? ($data = explode(',', $details['hobbies'])) : '';

                                    @endphp
                                    <label>Hobbies</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="cricket"
                                               {{ $details && in_array('cricket', $data) ? 'checked' : '' }} name="chk[]"/>
                                        <label class="form-check-label">Cricket</label>
                                    </div>
                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" name="chk[]"
                                               {{ $details && in_array('chess', $data) ? ' checked' : '' }} value="chess"/>
                                        <label class="form-check-label">Chess</label>
                                    </div>
                                    <span class="text-danger">
{{--                                    @error('chk')--}}
                                        {{--                                        {{ $message }}--}}
                                        {{--                                    @enderror--}}
                                </span>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Upload Profile</label>
                                <input type="file" name="profile" id="profile"/>
                                <span class="text-danger">
{{--                                    @error('profile')--}}
                                    {{--                                        {{ $message }}--}}
                                    {{--                                    @enderror--}}
                                </span>
                                <img id="preview-image"
                                     src="{{ $details ? asset('/storage/uploads/' . $details['profile_photo']) : asset('/assets/img/avtar.jpg') }}"
                                     height="100px" width="100px"/>
                            </div>

                            <div class="form-group">
                                <button type="button" id="update"
                                        class="btn btn-block btn-primary btn-lg add_register">{{ $details ? 'Update' : 'Create' }}</button>
                            </div>

                        </div>
                        <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
@endsection


@push('script_push')
    <script>

        $(document).ready(function () {

            $("#country").change(function () {
                let cid = $(this).val();
                $.ajax({
                    url: '{{ route('getState') }}',
                    type: 'GET',
                    data: {
                        cid: cid
                    },
                    datatype: "json",
                    success: function (result) {
                        $('#state').html(result);
                    },
                    error: function (error) {
                        alert('Error...');
                    }
                });
            });

            $("#state").change(function () {
                let sid = $(this).val();
                $.ajax({
                    url: '{{ route('getCity') }}',
                    type: 'GET',
                    data: {
                        sid: sid
                    },
                    datatype: "json",
                    success: function (result) {
                        $('#city').html(result);
                    },
                    error: function (error) {
                        alert("Error...")
                    }
                });
            });

            $('#profile').change(function () {

                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $(document).on('click', '.add_register', function (e) {
                e.preventDefault();
                var formData = new FormData($('#register')[0]);
                //for (const value of formData.values()) {
                //    console.log(value);
                //}
                //console.log(formData);
                $.ajax({
                    url: "{{ route('register') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        var data = JSON.stringify(result)
                        if ($('#id').val() == '') {
                            toastr.success('Data Inserted')
                        } else {
                            toastr.success('Data Updated')
                        }
                        window.location = "{{ route('view-user-admin') }}"

                    },
                    error: function (error) {
                        console.log(error);
                        //alert('Something went wrong');
                    }
                });

            });
        });
        {{--$(document).on('click', '.add_register', function (e) {--}}
        {{--    let test = $('#test').val();--}}

        {{--    $.ajax({--}}
        {{--        url: "{{ route('test') }}",--}}
        {{--        type: 'get',--}}
        {{--        data: {--}}
        {{--            test: test--}}
        {{--        },--}}
        {{--        //processData: false,--}}
        {{--        //contentType: false,--}}
        {{--        success: function (result) {--}}
        {{--            --}}{{--var data = JSON.stringify(result)--}}
        {{--            --}}{{--if ($('#id').val() == '') {--}}
        {{--            --}}{{--    toastr.success('Data Inserted')--}}
        {{--            --}}{{--} else {--}}
        {{--            --}}{{--    toastr.success('Data Updated')--}}
        {{--            --}}{{--}--}}
        {{--            --}}{{--window.location = "{{ route('view-user-admin') }}"--}}

        {{--        },--}}
        {{--        error: function (error) {--}}
        {{--            console.log(error);--}}
        {{--            //alert('Something went wrong');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

    </script>
@endpush
