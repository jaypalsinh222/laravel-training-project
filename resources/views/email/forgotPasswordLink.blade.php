@extends('auth.login-layout')
@section('login-content')
    <div class="container">
        <div class="login-box" style="display: inline-block;margin-left:370px;margin-top: 150PX ">
            <h1>Verification User</h1>
{{--            @dd($mailData);--}}
            <h3>
                verification Link : <a href="{{route('view-forget-password',['id'=>$mailData['id'],'token_key'=>$mailData['token_key']])}}"> Click Here to Confirm</a>
            </h3>
        </div>
    </div>
@endsection

@push('script_push')

@endpush