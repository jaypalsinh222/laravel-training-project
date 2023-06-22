@extends('layouts.layout')
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection


@push('script_push')
    <script>
        $(document).ready(function() {


            $("#country").change(function() {
                let cid = $(this).val();
                // alert(cid);
                $.ajax({
                    url: 'getState',
                    type: 'POST',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#state').html(result);
                    }
                });
            });

            $("#state").change(function() {
                let sid = $(this).val();
                // alert(cid);
                $.ajax({
                    url: 'getCity',
                    type: 'POST',
                    data: 'sid=' + sid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#city').html(result);
                    }
                });
            });

            $('#profile').change(function() {

                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);

            });

            $(document).on('click', '.add_register', function(e) {
                e.preventDefault();
                var formData = new FormData($('#register')[0]);
                for (const value of formData.values()) {
                    console.log(value);
                }
                //console.log(formData);
                $.ajax({
                    url: "{{ route('register') }}",
                    type: 'POST',
                    data: formData,
                    processData :false,
                    contentType: false,
                    success: function(result) {
                        console.log(result);
                        // $('#city').html(result);
                        alert('Data Inserted');

                    },
                    error : function(error){
                        console.log(error);
                        alert('Something went wrong');
                    }
                });
            });


        });
    </script>
@endpush
