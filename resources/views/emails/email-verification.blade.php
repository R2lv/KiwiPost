@component('mail::message')


# @lang('mail.hello',['name'=>$name])

@lang('mail.intro',['mail'=>$email])

@component('mail::button', ['url' => $url,'color' => 'green'])
@lang('mail.verify')
@endcomponent

<hr>

@lang('mail.not_working')
{{ $url }}

@lang('mail.info_why')


<a href="kiwipost.ge"><img src="http://kiwipost.ge/images/logo.png" style="height: 40px;" alt=""></a><br>

<a href="kiwipost.ge">{{ config('app.name') }}</a>

@endcomponent


