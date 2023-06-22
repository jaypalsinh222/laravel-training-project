@component('mail::message')
# Your GST Bill created successfully.
Client Name is : {{$gstData['name']}}


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
