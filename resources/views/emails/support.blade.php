@component('mail::message')

<h1>Support mail</h1>

<hr>
<p><b>Title:</b> {{ $title }}</p>
<p><b>Text: </b> <br> {{ $text }}</p>

<p><b>From:</b> {{ $name }}</p>
<b>Mail:</b> <a href="mailto:{{$email_from}}">{{ $email_from }}</a>
<hr>
<p>Message was sent from website </p>
@endcomponent


