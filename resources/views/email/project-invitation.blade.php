@component('mail::message')
# Project Invite

You received an invitation to collaborate in: {{$project->name}}. To accept just click the button bellow, and to decline just ignore this email.
This invite is only valid for 10 days.

@component('mail::button', ['url' => $url])
Accept invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent