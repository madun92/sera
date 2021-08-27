@component('mail::message')
# Registration Succesfully!

{{ $maildata['greeting'] }}<br>
{{ config('app.name') }}
@endcomponent