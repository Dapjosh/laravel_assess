<!-- Hi,</h1>
<p>Please click this <a href="{{ $invitation_link }}">invite link</a> to register on our website.</p><h1> -->

@component('mail::message')
# Link Sent

Hello, this is your invite link

@component('mail::button', ['url' => $invitation_link])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

