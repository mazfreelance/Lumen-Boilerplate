@component('mail::message')
Hi <b>{{ $user->name }}</b>,

Please click on the link below to reset your password. Link expires in 60 minutes.

Please click the button below to reset your password:

<a style="background-color: #6087d5; color: white; padding: 5px 10px; text-decoration: none; text-align: center; display: inline-block; border-radius: 5px;"
    href="{{ $url }}">Reset Password</a>

<p>Thanks.</p>
{{ config('app.frontend.name') }}'s Team.
@endcomponent
