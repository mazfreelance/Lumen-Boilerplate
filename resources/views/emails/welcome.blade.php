@component('mail::message')
Hi <b>{{ $user->name }}</b>,

You have successfully created a {{ config('app.frontend.name') }} account and we’re excited to have you onboard!.

<p>In case you have any questions, just email us at {{ config('mail.support') }}.</p>

<p>Thanks.</p>
{{ config('app.frontend.name') }}'s Team.
@endcomponent
