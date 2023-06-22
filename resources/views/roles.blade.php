@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <div class="container-fluid">
        <a href="{{ route('roles.index') }}">
            <button type="button" class="col-sm-1 btn btn-block btn-outline-primary">List Roles</button>
        </a>
        </br>
        <div class="row">

            <div class="col-md-12">

                {{--                 <td><a  class="btn btn-block btn-outline-primary">View Register</a></td>--}}
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Roles</h3>
                    </div>
                    <form method="POST" action="{{route('roles.store')}}" id="register" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="hid" name="hid" value="{{$role ? $role->id : ''}}">
                        <div class="card-body">
                            <div class="form-group col-md-2">
                                <label>Role Name</label>
                                <input type="text" class="form-control"
                                       value="{{$role? $role->name : ''}}" name="roleName"
                                       placeholder="Enter Role Name">
                                <span class="text-danger">
                                    @error('roleName'){{ $message }}@enderror
                                </span>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Permissions</label>
                                @forelse($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$permission->id}}" name="chk[]" {{ in_array($permission->name, $getPermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{$permission->name}}</label>
                                    </div>
                                @empty
                                    <h3>Permission not found</h3>
                                @endforelse
                                <span class="text-danger">
                                    @error('chk'){{ $message }}@enderror
                                </span>
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-block btn-primary btn-lg add_register">{{$role ? 'Update Role' :'Create Role'}}</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_push')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
    </script>

@endpush