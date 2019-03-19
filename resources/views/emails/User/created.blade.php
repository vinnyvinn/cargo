@component('mail::message')

Hello, {{ ucwords($data['name']) }}, <br>
Your account has been created successfully on ESL ~ Transport System.
#Account Details
Name : {{ ucwords($data['name']) }} <br>
Email : {{ $data['email'] }} <br>

#Login credentials
Email : {{ $data['email'] }} <br>
Password : {{ $data['password'] }} <br>

<strong>DO NOT SHARE YOUR CREDENTIALS WITH ANYONE</strong>

@component('mail::button', ['url' => 'http://esl-transport.dnsalias.com'])
CLICK TO LOGIN
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
