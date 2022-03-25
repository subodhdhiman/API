@component('mail::message')
# AI5 Mobile


Hello Customer,

Welcome. We are very happy to have you with us.


We hope our app will help in making Mobile experience much Better. Please follow the link below for availing our services.

@component('mail::button', ['url' => "abc", 'color' => 'success'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
