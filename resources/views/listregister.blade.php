@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('view-user-admin') }}">
                <button type="button" class="col-sm-1 btn btn-block btn-outline-primary">Add User</button>
            </a>
            </br>
            <div class="row">
                <div class="col-md-12">
                    <h4>List Registers</h4>
                    </br>
                    <table class="table mdl-data-table table-striped table-hover dataTable myTable">
                        <thead style="color: black;border-bottom-color: black !important;">
                        <tr>
                            <th>Sr.No</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>City</th>
                            <th>Hobbies</th>
                            <th>Profile</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

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
            var table = $('.myTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                deferRender: true,
                destroy: true,
                ajax: "{{ route('register.show') }}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'phone'},
                    {data: 'gender'},
                    {data: 'city'},
                    {data: 'hobbies'},
                    {data: 'profile'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            //Delete user
            $('body').on('click', '.deleteRegister', function () {
                var id = $(this).data("id");
                $.ajax({
                    type: "delete",
                    url: "{{ route('register.delete') }}" + '/' + id,
                    data: {
                        {{--"_token": "{{ csrf_token() }}",--}}
                        "id": id
                    },
                    success: function (data) {
                        toastr.info('Data Deleted');
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error : ', error);
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

