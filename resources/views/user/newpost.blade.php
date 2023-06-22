@extends('user.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    {{--    <h1>Profile</h1>--}}
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary" style="margin-top: 80px;margin-left: 200px">
                        <div class="card-header text-center">
                            <b>Add New Post</b>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">Please Select a Photo</p>

                            <form method="POST" action="{{route('posts.store')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{session()->get('user')->id}}"/>
                                <div class="form-group">
                                    <label>Upload Post</label>
                                    <input type="file" name="new_post" id="profile"/>
                                    <span class="text-danger">
{{--                                    @error('profile')--}}
                                        {{--                                        {{ $message }}--}}
                                        {{--                                    @enderror--}}
                                </span>
                                    <img id="preview-image"
                                         src="{{ asset('/assets/img/avtar.jpg') }}"
                                         height="300px" width="300px" style="margin-left: 100px;margin-top: 20px"/>
                                </div>
                                <span class="text-danger">
                            @error('new_post')
                                    {{ $message }}
                                    @enderror
                                </span>
                                <div class="form-group">
                                    <label>Textarea</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Write about post..."></textarea>
                                </div>
                                <span class="text-danger">
                                    @error('description')
                                    {{ $message }}
                                    @enderror
                                </span>
                                <div class="row">
                                    <div class="col-5">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-success btn-flat">Add Post</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.form-box -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.register-box -->
    </div>
@endsection

@push('script_push')

    <script type="text/javascript">
        $('#profile').change(function () {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>

@endpush