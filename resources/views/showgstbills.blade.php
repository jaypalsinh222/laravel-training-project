@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">
{{--            <a href="{{ route('register') }}"><button type="button" class="col-sm-1 btn btn-block btn-outline-primary">Add User</button></a>--}}
            </br>
            <div class="row">
                <div class="col-md-12">
                    <h4>List Invoices</h4>
                    <h5><a href="{{route('users')}}">Add GST-Bill</a></h5>
                    </br>
                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (session()->has('fail'))
                        <div class="alert alert-danger">
                            @error('fail')
                            {{ $message }}
                            @enderror
                        </div>
                    @endif
                    <table border="1" class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Client ID</th>
                            <th>Sub Total</th>
                            <th>Total CGST</th>
                            <th>Total SGST</th>
                            <th>Total Discount</th>
                            <th>Grand Amount</th>
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
        $(document).ready(function() {
            // $.ajaxSetup({
            //     headers:{
            //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            //     }
            //});
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('view-gst-list') }}",
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'totalamount',
                        name: 'totalamount'
                    },
                    {
                        data: 'total_cgst',
                        name: 'total_cgst'
                    },
                    {
                        data: 'total_sgst',
                        name: 'total_sgst'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'grandtotal',
                        name: 'grandtotal'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        {{--    //Delete user--}}
        {{--    $('body').on('click', '.deleteRegister', function() {--}}
        {{--        var id = $(this).data("id");--}}
        {{--        confirm('Are you sure want to delete!');--}}
        {{--        $.ajax({--}}
        {{--            type: "DELETE",--}}
        {{--            url: "{{ route('register.delete') }}" + '/' + id,--}}
        {{--            data: {--}}
        {{--                "_token": "{{ csrf_token() }}",--}}
        {{--                "id": id--}}
        {{--            },--}}
        {{--            success: function(data) {--}}
        {{--                toastr.info('Data Deleted');--}}
        {{--                table.draw();--}}
        {{--            },--}}
        {{--            error: function(data) {--}}
        {{--                console.log('Error : ', error);--}}
        {{--            }--}}
        {{--        })--}}
        {{--    });--}}

            //Edit User

             {{--$('body').on('click', '.editInvoice', function() {--}}
             {{--    //alert("ok");--}}
             {{--    var id = $(this).data("id");--}}

             {{--    $.post('{{ route('get.user.details') }}', {--}}
             {{--        _token:"{{ csrf_token() }}",--}}
             {{--        id: id--}}
             {{--    }, function(data) {--}}
             {{--        // alert(data.details.name);--}}
             {{--    }, 'json');--}}
             {{--});--}}

        {{--});--}}
    </script>
    @endpush


