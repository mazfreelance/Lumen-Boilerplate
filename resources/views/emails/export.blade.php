@component('mail::message')
Hi <b>{{ $user->name }}</b>,

Your request export data for {{ $moduleName }} is ready for download, please check this email attachment.

<p>Thanks.</p>
{{ config('app.frontend.name') }}'s Team.
@endcomponent
