@component('mail::message')
# Introduction
Hello {{$mailData['name']}}</br>
Please click the below link for create a password.

{{--@dd(route('email-verify',['id'=>$mailData['id'],'token_key'=>$mailData['token_key']]))--}}
@component('mail::button', ['url' => $mailData['url']])
{{--        <a href="{{route('email-verify',['id'=>$mailData['id'],'token_key'=>$mailData['token_key']])}}">--}}
            Click Here to Confirm
{{--        </a>--}}
@endcomponent
@component('mail::button', ['url' => '', 'color' => 'success'])
    View Order
@endcomponent

{{--@component('mail::panel')--}}
{{--    This is the panel content.--}}
{{--@endcomponent--}}
{{--@component('mail::table')--}}
{{--    | Laravel       | Table         | Example  |--}}
{{--    | ------------- |:-------------:| --------:|--}}
{{--    | Col 2 is      | Centered      | $10      |--}}
{{--    | Col 3 is      | Right-Aligned | $20      |--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
