@extends('layouts.layout')
@section('main-content')
    <h1>GST Invoice</h1>
    {{-- <div class="col-sm-6">

        <div class="form-group col-md-2">
            <label>Select Client</label>
            <select id="client" name="client" class="custom-select">
                @foreach ($users as $user)
                    <option {{ $user->id }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div> --}}

    <form method="POST" action="{{route('invoice.store')}}" id="gst" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$invoice ? $invoice->id : ''}}" name="invoiceId"/>
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Client Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">

                        <div class="form-group">
                            <select id="client" name="client"  class="custom-select js-example-basic-single"
                                    onchange="getUser(this.options[this.selectedIndex].value)">
                            </select>

{{--                            <select id="client" name="client" class="custom-select js-example-basic-single"--}}
{{--                                    onchange="getUser(this.options[this.selectedIndex].value)">--}}
{{--                                <option value="0">Select Client</option>--}}
{{--                                @if($invoice)--}}
{{--                                    @foreach ($users as $user)--}}
{{--                                        @if($user->id == $invoice->user_id)--}}
{{--                                            <option selected value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                        @else--}}
{{--                                            <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
{{--                                    @foreach ($users as $user)--}}
{{--                                        <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </select>--}}
                        </div>

                    </div>
                    @if($invoice)
                        <div id="show" class="row col-sm-6">
                            <tr>
                                <div class="col-3">
                                    <input type="text" value="{{$invoice ? $invoice->user->name : ''}}" id="name" name="name" class="form-control" placeholder=".col-3">
                                </div>

                                <div class="col-4">
                                    <input type="text" value="{{$invoice ? $invoice->user->email : ''}}" id="email" name="email" class="form-control" placeholder=".col-3">
                                </div>

                                <div class="col-5">
                                    <input type="text" id="phone" name="phone" value="{{$invoice ? $invoice->user->phone : ''}}" class="form-control" placeholder=".col-3">
                                </div>
                        </div>
                    @endif
                    <div id="show" class="row col-sm-6" style="display: none">
                        <tr>
                            <div class="col-3">
                                <input type="text" value="{{$invoice ? $invoice->user->name : ''}}" id="name" name="name" class="form-control" placeholder=".col-3">
                            </div>

                            <div class="col-4">
                                <input type="text" value="{{$invoice ? $invoice->user->email : ''}}" id="email" name="email" class="form-control" placeholder=".col-3">
                            </div>

                            <div class="col-5">
                                <input type="text" id="phone" name="phone" value="{{$invoice ? $invoice->user->phone : ''}}" class="form-control" placeholder=".col-3">
                            </div>
                    </div>
                    </tr>
                </div>
            </div>

        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Invoice Details</h3>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="card-body table-responsive p-0">
                            <table class="addDiv">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @if($invoice)
                                    @php
                                        $row_id = 0
                                    @endphp
                                    {{--                                    {{dd($invoice->invoiceItems)}}--}}
                                    @foreach($invoice->invoiceitems as $invoiceItems)

                                        @php
                                            $row_id++
                                        @endphp
                                        <tr id="row{{$row_id}}">
                                            <input type="hidden" value="{{$invoiceItems->row_key}}" name='data[{{$row_id}}][row_key]'/>
                                            <td>
                                                <div class='form-group'>
                                                    <select id='product{{$row_id}}' name='data[{{$row_id}}][product]' class='custom-select js-example-basic-single' onchange='getProducts(this.options[this.selectedIndex].value,this,{{$row_id}})'>

                                                        <option value='0'>Select Product</option>

                                                        @foreach ($products as $product)
                                                            @if($product->id == $invoiceItems->product_id)
                                                                <option selected data-cgst={{$product->cgst}} data-sgst={{$product->sgst}} value='{{ $product->id }}'>{{ $product->product_name }}</option>
                                                            @else
                                                                <option data-cgst={{$product->cgst}} data-sgst={{$product->sgst}} value='{{ $product->id }}'>{{ $product->product_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>

                                            <td>
                                                <input type='text' class='form-control' value="{{$invoiceItems->price}}" name='data[{{$row_id}}][price]' id='price{{$row_id}}' readonly placeholder='Price'>
                                            </td>
                                            <td>
                                                <input type='text' value="{{$invoiceItems->quantity}}" name='data[{{$row_id}}][quantity]' onkeyup='sum({{$row_id}})' id='quantity{{$row_id}}' class='form-control' placeholder='Quantity'>
                                            </td>

                                            <td>
                                                <input type='text' id='subtotal{{$row_id}}' value="{{$invoiceItems->totalsubtotal}}" readonly name='data[{{$row_id}}][subtotal]' class='form-control subtotal' placeholder='SUB TOTAL'>
                                            </td>
                                            <td>
                                                @foreach ($products as $product)
                                                    @if($product->id == $invoiceItems->product_id)
                                                        <input type='text' id='cgst{{$row_id}}' value="{{$product->cgst}}" readonly class='form-control'/>
                                                        <input type='hidden' id='1_cgst{{$row_id}}' value="{{$invoiceItems->cgst}}" name='data[{{$row_id}}][cgst]' readonly class='form-control cgst'/>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($products as $product)
                                                    @if($product->id == $invoiceItems->product_id)
                                                        <input type='text' id='sgst{{$row_id}}' value="{{$product->sgst}}" readonly class='form-control'/>
                                                        <input type='hidden' id='1_sgst{{$row_id}}' value="{{$invoiceItems->sgst}}" name='data[{{$row_id}}][sgst]' readonly class='form-control sgst'/>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <input type='text' id='amount{{$row_id}}' value="{{$invoiceItems->totalamount}}" class='form-control totalamount' name='data[{{$row_id}}][amount]' readonly placeholder='Amount'>
                                            </td>

                                            <td class='form-group col-md-2'><a href='javascript:;'>
                                                    <button style='padding-left:20px;padding-right: 20px; background-color: red;border-radius:10px;border:none;color: white !important' type='button' onclick='deleteDiv({{$row_id}})'>Delete
                                                    </button>
                                                </a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div style="float: right;display:flex">
                <div class="form-group col-md-2">
                    <label for="exampleInputEmail1">Action</label></br>
                    <button
                            style="padding-left:20px;padding-right: 20px;background-color:#007bff;border-radius:10px;border:none;color: white"
                            type="button" id="getDiv">+
                    </button>
                </div>
                <div class="form-group col-md-2">
                    <label for="exampleInputPassword1"></label>

                </div>
                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Sub Total</label>
                    <input readonly type="text" id="total_sub_total" value="{{$invoice ? $invoice->subtotal : ''}}" name="total_sub_total" class="form-control" placeholder="Sub Total">
                </div>
                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Total CGST</label>
                    <input readonly type="text" id="total_cgst" value="{{$invoice ? $invoice->total_cgst : ''}}" name="total_cgst" class="form-control" placeholder="CGST">
                </div>
                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Total SGST</label>
                    <input readonly type="text" id="total_sgst" name="total_sgst" value="{{$invoice ? $invoice->total_sgst : ''}}" class="form-control" id="exampleInputPassword1" placeholder="SGST">
                </div>

                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Total Amount</label>
                    <input readonly type="text" class="form-control" value="{{$invoice ? $invoice->totalamount : ''}}" name="total_amount" id="total_amount" placeholder="Amount">
                </div>

                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Discount</label>
                    <input type="text" id="discount" onkeyup="discount1()" value="{{$invoice ? $invoice->discount : ''}}" name="discount" class="form-control" id="exampleInputPassword1" placeholder="Discount">
                </div>


                <div class="form-group col-md-1">
                    <label for="exampleInputFile">Grand Total</label>
                    <input readonly type="text" class="form-control" value="{{$invoice ? $invoice->grandtotal : ''}}" name="grand_total_amount" id="grand_total_amount" placeholder="Amount">
                </div>


            </div>
            <div class="card-footer">
                <button style="float: right;display:flex" type="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection

@push('script_push')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder:"Select",
                ajax: {
                    url: '{{ route('get.users') }}',
                    type: 'GET',
                    datatype: "json",
                    data: function (data) {
                        return {
                            term: data.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                item.text = item.name;
                                item.value = item.id;
                                return item;
                            }),
                        };
                    }
                }
            });


        });

        function sum(id) {
            $('#discount').val(0);
            //console.log(t.dataset.cgst);
            //console.log(t.dataset.sgst);

            var quantity = $('#quantity' + id).val();

            var price = $('#price' + id).val();

            amount = quantity * price;
            //alert(amount);
            //console.log(quantity, price);
            if (!isNaN(amount)) {
                $('#subtotal' + id).val(amount);
            }
            localStorage.setItem('cgst' + id, $("#cgst" + id).val());
            //console.log($("#cgst" + id));

            var cgst = parseFloat(amount * (localStorage.getItem('cgst' + id)) / 100);
            console.log(cgst);

            if (!isNaN(amount)) {

                $('#1_cgst' + id).val(cgst);

            }

            localStorage.setItem('sgst' + id, $("#sgst" + id).val());

            var sgst = parseFloat(amount * (localStorage.getItem('sgst' + id)) / 100);

            if (!isNaN(amount)) {

                $('#1_sgst' + id).val(sgst);

            }

            var tr_amount = parseFloat(amount + cgst + sgst);
            //alert(tr_amount);
            if (!isNaN(amount)) {
                $('#amount' + id).val(tr_amount);

            }


            sumRow(id);
        }

        @if($invoice)
        var row_id = {{$row_id}};
        //alert(row_id);
        @else
        var row_id = 0;
        @endif

        $(document).on('click', '#getDiv', function () {


            row_id++;

            var elements = "<tr id='row" + row_id + "'> " +

                "<td>" +
                "<div class='form-group'>" +
                "<select id='product" + row_id + "' name='data[" + row_id + "][product]' class='custom-select js-example-basic-single' onchange='getProducts(this.options[this.selectedIndex].value,this," + row_id + ")'>" +
                "<option value='0'>Select Client</option>" +
                    @foreach ($products as $product)
                        "<option data-cgst={{$product->cgst}} data-price={{$product->price}} data-sgst={{$product->sgst}} value='{{ $product->id }}'>{{ $product->product_name }}</option>" +
                    @endforeach
                        "</select>" +
                "<div>" +
                "</td>" +
                "<td><input type='text' class='form-control' name='data[" + row_id + "][price]' id='price" + row_id + "' readonly placeholder='Price'>" +
                "</td>" +
                "<td>" +
                "<input type='text' onchange='sumRow(" + row_id + ")'  name='data[" + row_id + "][quantity]'  onkeyup='sum(" + row_id + ")' id='quantity" + row_id + "' class='form-control' placeholder='Quantity'>" +
                "</td>" +

                "<td><input  type='text' id='subtotal" + row_id + "' readonly name='data[" + row_id + "][subtotal]' class='form-control subtotal' placeholder='SUB TOTAL'>" +
                "</td>" +
                "<td>" +

                //"<select id='cgst" + row_id + "'  class='custom-select js-example-basic-single'>" +
                //
                //
                //"</select>" +
                "<input  type='text' id='cgst" + row_id + "' name='data[" + row_id + "][cgst]' readonly class='form-control' />" +
                "<input type='hidden' id='1_cgst" + row_id + "' name='data[" + row_id + "][cgst]' readonly class='form-control cgst'/>" +
                "</td>" +

                "<td>" +

                //"<select id='sgst" + row_id + "'   class='custom-select js-example-basic-single'>" +
                //
                //
                //"</select>" +
                "<input  type='text' id='sgst" + row_id + "' name='data[" + row_id + "][sgst]' readonly class='form-control'  />" +
                "<input type='hidden' id='1_sgst" + row_id + "' name='data[" + row_id + "][sgst]' readonly class='form-control sgst'/>" +
                "</td>" +
                "<td><input type='text' id='amount" + row_id + "' class='form-control totalamount' name='data[" + row_id + "][amount]' readonly placeholder='Amount'></td>";

            if (row_id != 1) {
                elements += "<td class='form-group col-md-2'><a href='javascript:;'>" +
                    "<button style='padding-left:20px;padding-right: 20px; background-color: red;border-radius:10px;border:none;color: white !important' " +
                    "type='button' onclick='deleteDiv(" + row_id + ")'>Delete</a></button></td></tr></div>";
            } else {
                elements += "<td class='form-group col-md-2'><a href='javascript:;'></td></tr></div>";
            }

            $('.addDiv').append(elements);
            $('.js-example-basic-single').select2();

        });

        function deleteDiv(id) {
            $('#row' + id).remove();
            sumRow(id);
        }

        function sumRow(row_id) {
            //alert("hello");
            var total_cgst = 0;
            var total_sgst = 0;
            var billamount = 0;
            var totalbillamt = 0;
            var subtotal = 0;

            $('table  tr').each(function (index, tr) {
                //alert("hello");
                $(this).children('td').each(function (index, td) {
                    $(this).children('.subtotal').each(function (index, td) {
                        //console.log("hello");
                        subtotal += parseFloat($(this).val());
                    });
                    $(this).children('.cgst').each(function (index, td) {
                        //console.log($(this).val());
                        total_cgst += parseFloat($(this).val());
                    });
                    $(this).children('.sgst').each(function (index, td) {
                        total_sgst += parseFloat($(this).val());
                    });
                    $(this).children('.totalamount').each(function (index, td) {
                        totalbillamt += parseFloat($(this).val());
                    });
                });
            });
            document.getElementById('total_cgst').value = total_cgst;
            document.getElementById('total_sgst').value = total_sgst;
            document.getElementById('total_sub_total').value = subtotal;
            //totalbillamt = parseFloat(billamount) + parseFloat(total_cgst) + parseFloat(total_sgst);
            //alert(document.getElementById('discount').value);
            document.getElementById('total_amount').value = totalbillamt;
            document.getElementById('grand_total_amount').value = totalbillamt;
        }

        function discount1() {
            var discount = document.getElementById('discount').value;
            var amount = document.getElementById('total_amount').value;

            var grand_total = amount - discount;

            if (!isNaN(grand_total)) {
                document.getElementById('grand_total_amount').value = grand_total;
            }

        }


        function getUser(id) {
            //alert(id);
            $.ajax({
                url: "{{ route('getUser') }}",
                type: "POST",
                data: 'id=' + id + '&_token={{ csrf_token() }}',
                success: function (result) {
                    var data = JSON.stringify(result);
                    console.log(data);
                    var data1 = jQuery.parseJSON(data);
                    console.log(data1);
                    // for (const value of data) {
                    //     console.log(value);
                    // }
                    // console.log(data);
                    $("#show").show();
                    $("#name").val(data1.name)
                    $("#email").val(data1.email)
                    $("#phone").val(data1.phone)
                }
            });
        }
            {{--//$("#name").html({{ $user }})--}}

        {{--}--}}


        function getProducts(id, t, row_id) {

            var ctax = t.options[t.selectedIndex].dataset.cgst;
            var stax = t.options[t.selectedIndex].dataset.sgst;
            var price = t.options[t.selectedIndex].dataset.price;
            $("#sgst" + row_id).val(stax);
            $("#cgst" + row_id).val(ctax);
            $("#price" + row_id).val(price);

            //console.log(id);
            //console.log($('#product'+id).val().remove());

            // $("#product option:selected").remove();

            //$('#quantity' + id).attr('data-cgst', ctax);
            //$('#quantity' + id).attr('data-sgst', stax);
            //console.log($('#quantity' + id).attr('data-cgst'));


            //alert(id);
            {{--$.ajax({--}}
            {{--    url: "{{ route('getProducts') }}",--}}
            {{--    type: "POST",--}}
            {{--    data: 'id=' + id + '&_token={{ csrf_token() }}',--}}
            {{--    success: function (result) {--}}
            {{--        var data = JSON.stringify(result);--}}
            {{--        //console.log(data);--}}
            {{--        var data1 = jQuery.parseJSON(data);--}}
            {{--        //console.log(data1);--}}
            {{--        // for (const value of data) {--}}
            {{--        //     console.log(value);--}}
            {{--        // }--}}
            {{--        //console.log(data1.id);--}}

            {{--        //$("#cgst" + row_id).append('<option selected value="' + data1.cgst + '">' + data1.cgst + '</option>');--}}
            {{--        //$("#sgst" + row_id).append('<option selected value="' + data1.sgst + '">' + data1.sgst + '</option>');--}}

            {{--    }--}}
            {{--});--}}
        }
    </script>
@endpush
