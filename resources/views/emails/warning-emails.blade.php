@component('mail::message')

<h1>Warnings  mail - Action: {{$data['action']}}</h1>
<hr>
<p><b>Title:</b> {{$data['title']}}</p>
<p><b>Description: </b>  {{ $data['description'] }} </p>

<p><b>Action by:</b> {{ $data['user'] }} | KW: {{ $data['user_id'] }}</p>
<p><b>Action Time:</b> {{ $data['time'] }}</p>
<b>Mail:</b> <a href="mailto:{{$data['user_email']}}">{{ $data['user_email'] }}</a>
<hr>

@endcomponent


