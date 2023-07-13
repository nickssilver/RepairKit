@component('mail::message')
# From: {{$data['name']}}

{{$data['message']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
