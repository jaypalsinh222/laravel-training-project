@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('roles.create') }}">
                <button type="button" class="col-sm-1 btn btn-block btn-outline-primary">Add Role</button>
            </a>
            </br>
            <div class="row">
                <div class="col-md-12">
                    <h4>List Roles</h4>
                    </br>
                    <table border="1" class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- {{ dd($data) }} --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script_push')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function () {
            // $.ajaxSetup({
            //     headers:{
            //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            //     }
            //});
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            //Delete Role
            $('body').on('click', '.deleteRegister', function () {
                var id = $(this).data("id");
                var url = "{{ route('roles.destroy', ':id') }}";
                    url = url.replace(":id",id);
                $.ajax({
                    type: "delete",
                    url: url,
                    dataType:'json',
                    success: function () {
                        toastr.info('Role Deleted');
                        table.draw();
                    },
                    error: function () {
                        console.log('something went wrong');
                    }
                })
            });

            //Edit User

            // $('body').on('click', '.editRegister', function() {
            //     //alert("ok");
            //     var id = $(this).data("id");

            {{--//     $.post('{{ route('get.user.details') }}', {--}}
            {{--//         _token:"{{ csrf_token() }}",--}}
            //         id: id
            //     }, function(data) {
            //         // alert(data.details.name);
            //     }, 'json');
            // });

        });
    </script>
@endpush

