@extends('layouts.layout')
@section('main-content')
    <h1>Import Excel File For Multiple Mail</h1>
    <div class="card-body">
        <form action="{{ route('users.excel.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control">
            <br>
            <button class="btn btn-success">Import User Data</button>
        </form>
    </div>
@endsection

@push('script_push')

@endpush
