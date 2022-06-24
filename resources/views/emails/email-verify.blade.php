@component('mail::message')
Hi <b>{{ $user->name }}</b>,

Thank you for signing up {{ config('app.frontend.name') }} account. To complete your profile and fully start exploring {{ config('app.frontend.name') }}, we need you to
confirm that this is a valid email address.

Please click the button below to verify:

<a style="background-color: #6087d5; color: white; padding: 5px 10px; text-decoration: none; text-align: center; display: inline-block; border-radius: 5px;"
href="{{ $url }}">Verify</a>

<p>Once your email is verified, sign in to {{ config('app.frontend.name') }} to get started.</p>
<p>We're glad you're here</p>

<p>Thanks.</p>
{{ config('app.frontend.name') }}'s Team.
@endcomponent
