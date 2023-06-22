@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">

            </br>
            <div class="row">
                <div class="col-md-12">
                    <div class="Polaris-Page">
                        <div class="Polaris-Page-Header Polaris-Page-Header--isSingleRow Polaris-Page-Header--noBreadcrumbs Polaris-Page-Header--mediumTitle">
                            <div class="Polaris-Page-Header__Row">
                                <div class="Polaris-Page-Header__TitleWrapper">
                                    <h1 class="Polaris-Header-Title">Sales by product</h1>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="Polaris-Card">
                                <div class="">
                                    <div class="Polaris-DataTable Polaris-DataTable__ShowTotals">
                                        <div class="Polaris-DataTable__ScrollContainer">
                                            <table class="Polaris-DataTable__Table myTable" border="1" style="border: 1px solid black">
                                                <thead>
                                                <tr>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col">Sr.No</th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header" scope="col">First Name</th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric Polaris-DataTable__Cell--sortable" scope="col">
                                                        {{--<button class="Polaris-DataTable__Heading" tabindex="0">--}}
                                                        {{--  <span class="Polaris-DataTable__Icon">--}}
                                                        {{--    <span class="Polaris-Icon">--}}
                                                        {{--      <span class="Polaris-Text--root Polaris-Text--bodySm Polaris-Text--regular Polaris-Text--visuallyHidden">sort ascending by</span>--}}
                                                        {{--      <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">--}}
                                                        {{--        <path d="M12.324 9h-4.648c-.563 0-.878-.603-.53-1.014l2.323-2.746a.708.708 0 0 1 1.062 0l2.323 2.746c.349.411.033 1.014-.53 1.014Z" fill-opacity="50%">--}}
                                                        {{--        </path>--}}
                                                        {{--        <path d="M7.676 11h4.648c.563 0 .879.603.53 1.014l-2.323 2.746a.708.708 0 0 1-1.062 0l-2.324-2.746c-.347-.411-.032-1.014.531-1.014Z">--}}
                                                        {{--        </path>--}}
                                                        {{--      </svg>--}}
                                                        {{--    </span>--}}
                                                        {{--  </span>Email--}}
                                                        {{--</button>--}}Email
                                                    </th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Phone</th>
                                                    <th data-polaris-header-cell="true" aria-sort="descending" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric Polaris-DataTable__Cell--sortable Polaris-DataTable__Cell--sorted" scope="col">
                                                        {{--<button class="Polaris-DataTable__Heading" tabindex="0">--}}
                                                        {{--    <span class="Polaris-DataTable__Icon">--}}
                                                        {{--      <span class="Polaris-Icon">--}}
                                                        {{--        <span class="Polaris-Text--root Polaris-Text--bodySm Polaris-Text--regular Polaris-Text--visuallyHidden">sort ascending by</span>--}}
                                                        {{--        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">--}}
                                                        {{--          <path d="M12.324 9h-4.648c-.563 0-.878-.603-.53-1.014l2.323-2.746a.708.708 0 0 1 1.062 0l2.323 2.746c.349.411.033 1.014-.53 1.014Z" fill-opacity="50%">--}}
                                                        {{--          </path>--}}
                                                        {{--          <path d="M7.676 11h4.648c.563 0 .879.603.53 1.014l-2.323 2.746a.708.708 0 0 1-1.062 0l-2.324-2.746c-.347-.411-.032-1.014.531-1.014Z">--}}
                                                        {{--          </path>--}}
                                                        {{--        </svg>--}}
                                                        {{--      </span>--}}
                                                        {{--    </span>Gender--}}
                                                        {{--</button>--}}
                                                    </th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">City</th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Hobbies</th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Profile</th>
                                                    <th data-polaris-header-cell="true" aria-sort="none" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach($data as $row)
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    <tr>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$i}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->name}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->email}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->phone}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->gender}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->city}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->hobbies}}</td>
                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->profile}}</td>
                                                        {{--                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total">{{$row->name}}</td>--}}
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script_push')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        {{--$(document).ready(function () {--}}
        {{--    // $.ajaxSetup({--}}
        {{--    //     headers:{--}}
        {{--    //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')--}}
        {{--    //     }--}}
        {{--    //});--}}
        {{--    var table = $('.myTable').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        pageLength: 10,--}}
        {{--        deferRender: true,--}}
        {{--        destroy: true,--}}
        {{--        ajax: "{{ route('datatable') }}",--}}
        {{--        columns: [--}}
        {{--            {data: 'DT_RowIndex'},--}}
        {{--            {data: 'name'},--}}
        {{--            {data: 'email'},--}}
        {{--            {data: 'phone'},--}}
        {{--            {data: 'gender'},--}}
        {{--            {data: 'city'},--}}
        {{--            {data: 'hobbies'},--}}
        {{--            {data: 'profile'},--}}
        {{--            {--}}
        {{--                data: 'action',--}}
        {{--                name: 'action',--}}
        {{--                orderable: false,--}}
        {{--                searchable: false--}}
        {{--            },--}}
        {{--        ]--}}
        {{--    });--}}

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

        })
        ;
    </script>
@endpush

