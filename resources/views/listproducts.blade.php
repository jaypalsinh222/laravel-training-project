@extends('layouts.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            {{--            <a href=""><button type="button" class="col-sm-1 btn btn-block btn-outline-primary">Add Discount</button></a>--}}
            @if(session()->get('user')->hasPermissionTo('product-create'))
                <button type="button" class="btn btn-success" id="create-button-click" data-toggle="modal" data-target="#exampleModal">
                    Create
                </button>
                @endif
                </br>
                <form method="POST" id="product" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" id="prod_id" value='{{$product ? $product->id : ""}}' name="hidden" placeholder="Product Name">
                                        <div class="form-group">

                                            <input type="text" class="form-control" value='{{$product ? $product->name : ""}}' name="name" id="prod_name" placeholder="Product Name">
                                        </div>
                                        <div class="form-group">

                                            <input type="text" name="price" value='{{$product ? $product->price : ""}}' class="form-control" id="prod_price" placeholder="Price">
                                        </div>
                                        <div class="form-group">

                                            <div class="custom-file">
                                                <input type="file" name="image" value="" class="form-control" id="profile">
                                                <img id="preview-image" style="margin-top: 10px;margin-left: 150px"
                                                     src="{{ $product ? asset('/storage/uploads/' . $product->image) : asset('/assets/img/avtar.jpg') }}"
                                                     height="80px" width="80px"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer" style="margin-top: 60px">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary create_product" data-url="{{ route('product-create') }}"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <h4>List Registers</h4>
                        </br>
                        <table border="1" class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Image</th>
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
        $('#profile').change(function () {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $(document).on('click', '#create-button-click', function (e) {
            //console.log('dada');
            $("#prod_id").val('');
            $("#prod_name").val('');
            $("#prod_price").val('');
            $('.create_product').attr('data-url', "{{ route('product-create')}}");
            $('.create_product').text('create');
            $('.create_product').removeAttr('id');
        });


        $(document).on('click', '.create_product', function (e) {

            e.preventDefault();
            var formData = new FormData($('#product')[0]);
            //for (const value of formData.values()) {
            //    console.log(value);
            //}


            if ($('#prod_id').val() == '') {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        var data = JSON.stringify(result)
                        //if ($('#id').val() == '') {
                        toastr.success('Data Inserted')
                        //} else {
                        //    toastr.success('Data Updated')
                        //}
                        //$('.modal-content').attr('data-dismiss', 'modal');
                        window.location.reload();
                        //$('.data-table').DataTable().draw();
                        {{--window.location = "{{ route('product-list') }}"--}}

                    },
                    error: function (error) {
                        console.log(error);
                        //alert('Something went wrong');
                    }
                });
            } else {
                var id = $('#prod_id').val();

                $.ajax({
                    url: "{{ route('product-create') }}" + "/" + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        var data = JSON.stringify(result)
                        //alert(data);
                        if ($('#prod_id').val() == '') {
                            toastr.success('Data Inserted')
                        } else {
                            toastr.success('Data Updated')
                        }
                        //$('.modal-content').attr('data-dismiss', 'modal');
                        window.location.reload();
                        //$('.data-table').DataTable().draw();
                        {{--window.location = "{{ route('product-list') }}"--}}
                    },
                    error: function (error) {
                        console.log(error);
                        //alert('Something went wrong');
                    }
                });
            }

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
                ajax: "{{ route('product-show') }}",
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'image',
                        name: 'image'
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


        //Edit User

        $('body').on('click', '.editProduct', function () {
            //alert("ok");
            var id = $(this).data("id");
            $.ajax({
                url: "{{ route('product-edit') }}" + "/" + id,
                type: 'GET',
                dataType: "JSON",
                //processData: false,
                //contentType: false,
                success: function (result) {
                    //alert("okay");
                    //var data = JSON.stringify(result)
                    $("#prod_id").val(result.id);
                    $("#prod_name").val(result.name);
                    $("#prod_price").val(result.price);
                    $("#preview-image").attr('src', '{{asset("/storage/uploads")}}' + '/' + result.image);
                    $('.create_product').attr('data-url', "http://127.0.0.1:8000/product-update/" + result.id);
                    $('.create_product').text('update');
                },
                error: function (error) {
                    console.log(error);
                    //alert('Something went wrong');
                }
            });

        });


    </script>
    @endpush

    </body>

    </html>
