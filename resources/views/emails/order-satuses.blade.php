@component('mail::message')


# @lang('mail.hello',['name'=>$name])

<hr>

{{--@lang('mail.order.message',['tracking'=>$tracking])--}}

{{ $message }}

{{--@lang('mail.order.note')--}}

<a target="_blank" href="https://kiwipost.ge"><img src="http://kiwipost.ge/images/logo.png" style="height: 40px;" alt=""></a><br>

{{--<a href="https://kiwipost.ge">{{ config('app.name') }}</a>--}}

@endcomponent


