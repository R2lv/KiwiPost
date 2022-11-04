@component('mail::message')


# @lang('mail.hello',['name'=>$name])




<p>@lang('mail.user_login')</p>

@component('mail::table')
    | @lang('mail.Username')| @lang('mail.Password')  |
    | :-------------------- |------------------------:|
    | {{ $email }}          |{{ $password }}          |
@endcomponent

<hr>

@lang('mail.password_recovery_why')


<a href="kiwipost.ge"><img src="http://kiwipost.ge/images/logo.png" style="height: 40px;" alt=""></a><br>

<a href="kiwipost.ge">{{ config('app.name') }}</a>

@endcomponent


