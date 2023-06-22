@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            {{--            <a href=""><button type="button" class="col-sm-1 btn btn-block btn-outline-primary">Add Discount</button></a>--}}
            @if(session()->get('user')->hasPermissionTo('discount-create'))
                <button type="button" class="btn btn-success" id="create-button-click" data-toggle="modal" data-target="#exampleModal">
                    Create
                </button>
                @endif
                </br>

                <div class="row">
                    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog exampleModal" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Discount</h5>
                                    <button type="button" id="closeBtn" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modalShowHide">
                                    <form method="POST" id="discount" action="{{route('discount-create')}}">
                                        @csrf
                                        <input type="hidden" class="form-control" id="disc_id" value='{{$discount ? $discount->id : ""}}' name="did">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Discount Name</label>
                                            <input type="text" class="form-control" value='{{$discount ? $discount->name : ""}}' name="name" id="disc_name" placeholder="Discount Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Percentage</label>
                                            <input type="text" name="percentage" value='{{$discount ? $discount->percentage : ""}}' class="form-control" id="disc_percentage" placeholder="Percentage">
                                        </div>
                                        <div class="form-group">
                                            <label>Select</label>
                                            <select name="discountfor" id="product_disc" class="form-control">
                                                <option value="">Select</option>
                                                <option value="0">Product</option>
                                                <option value="1">Cart</option>
                                            </select>
                                        </div>
                                        <div class="form-group showDiv" id="showDiv" style="display: none">
                                            <label>Select Product</label></br>
                                            <select id="products" name="products[]" multiple class="custom-select js-example-basic-single" style="display: content !important;">
                                                {{--                                                onchange="getUser(this.options[this.selectedIndex].value)">--}}
                                                <option value="">Select Client</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary create_discount">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>List Discounts</h4>
                        </br>
                        <table border="1" class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Percentage</th>
                                <th>Discount For</th>
                                <th>Products</th>
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
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });

        $(document).on('click', '#create-button-click', function (e) {
            //console.log('dada');
            $("#disc_id").val('');
            $("#disc_name").val('');
            $("#disc_percentage").val('');
            $("#product_disc").val('');
            //$("#products").val('');
        });

        $('#closeBtn').click(function () {
            //$('#discount')[0].reset();
            // $(".js-example-basic-single").val('').trigger('change');
            // $(".js-example-basic-single").select2("val", "");
            $(".js-example-basic-single").empty().trigger('change')
        });

        $('#product_disc').change(function () {
            if ($(this).val() === '0') {
                $('.showDiv').show();
            } else {
                $('.showDiv').hide();
            }
        });

        $(document).on('click', '.create_discount', function (e) {
            e.preventDefault();
            var formData = new FormData($('#discount')[0]);
            //for (const value of formData.values()) {
            //    console.log(value);
            //}
            //console.log(formData);
            $.ajax({
                url: "{{ route('discount-create') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    var data = JSON.stringify(result)
                    $('#exampleModal').modal('toggle');
                    if ($('#disc_id').val() == '') {
                        toastr.success('Data Inserted')
                    } else {
                        toastr.success('Data Updated')
                    }
                    $('.data-table').DataTable().draw();
                    {{--window.location = "{{ route('discount-list') }}"--}}
                },
                error: function (error) {
                    console.log(error);
                    //alert('Something went wrong');
                }
            });
        });
        $(document).ready(function () {
            // $.ajaxSetup({
            //     headers:{
            //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            //     }
            //});
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('discount-show') }}",
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'percentage',
                        name: 'percentage'
                    },
                    {
                        data: 'discount_for',
                        name: 'discountfor'
                    },
                    {
                        data: 'products',
                        name: 'products'
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

        $('body').on('click', '.editDiscount', function () {
            //alert("ok");
            var id = $(this).data("id");
            console.log(id);
            $.ajax({
                url: "{{ route('discount-edit') }}" + "/" + id,
                type: 'GET',
                dataType: "JSON",
                //processData: false,
                //contentType: false,
                success: function (result) {
                    //alert("okay");
                    //var data = JSON.stringify(result)
                    //alert('ok');
                    //console.log(result);
                    //console.log(result.id);
                    $("#disc_id").val(result.id);
                    $("#disc_name").val(result.name);
                    $("#disc_percentage").val(result.percentage);
                    if (result.discount_for == 0) {
                        $('#product_disc').val(result.discount_for);
                        $('.showDiv').show();
                        //$('.showDiv')[0].reset();
                        //document.getElementById("#showDiv");
                        $.each(result.products, function (key, value) {
                            //console.log(value);
                            $('#products').append("<option selected value='" + value.id + "'>" + value.name + "</option>");
                        });
                    } else {
                        $('#product_disc').val(result.discount_for);
                        $('.showDiv').hide();
                    }
                    //$('.create_product').attr('data-url', "http://127.0.0.1:8000/product-update/" + result.id);
                    //$('.create_product').text('update');
                },
                error: function (error) {
                    console.log(error);
                    //alert('Something went wrong');
                }
            });
        });
    </script>
@endpush

