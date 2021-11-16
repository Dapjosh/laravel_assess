@component('mail::message')
# Your Pin

Hello, this is your pin


{{ $data['pin'] }} 


You can visit the link below to finish your registration

@component('mail::button', ['url' => $data['register_link']])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent