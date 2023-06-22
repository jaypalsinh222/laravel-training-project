@extends('user.layout')
@push('css_push')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('main-content')
<h1>Hello {{session()->get('user')->name}}  Namaste!</h1>
{{--    @dump(session()->get('user')->is_admin)--}}
@endsection

@push('script_push')

@endpush