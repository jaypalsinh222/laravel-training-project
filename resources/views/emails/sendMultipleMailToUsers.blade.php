@component('mail::message')
    # Introduction
    Hello {{$mailData['name']}}</br>
    Please click the below link for create a password.

    @component('mail::button', ['url' => ''])
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
