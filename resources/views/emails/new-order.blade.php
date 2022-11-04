@component('mail::message')


# @lang('mail.hello',['name'=>$name])

<hr>

@lang('mail.order.message',['tracking'=>$tracking])
<br>
@lang('mail.order.note')
<a href="http://kiwipost.ge/faq">@lang('mail.order.suggest')</a>

@if(!empty($invoice))
<a href="{{ $invoice }}" target="_blank">@lang('mail.order.invoice')</a>
@endif
<br>

<a href="https://kiwipost.ge"><img src="http://kiwipost.ge/images/logo.png" style="height: 40px;" alt=""></a><br>

<a href="https://kiwipost.ge">{{ config('app.name') }}</a>

@endcomponent


