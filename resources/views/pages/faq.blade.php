@extends("master")

@section('title')
    @lang('pages.faq.page_to')
@endsection

@section('how')
@endsection


@section ('fb-image', asset('kiwipost-ge.jpg'))
@section ('fb-title', 'კივი ფოსტა')
@section ('fb-description', 'დიდი ბრიტანეთიდან სიყვარულით')


@section('video')
@endsection

@section('calculator')
@endsection

@section('sections')
<section id="page-title" class="faq-title">
    <div class="overlay">
        <div class="contentWrapper">
            <div class="title-wrapper vAlign geo upper">
                <h1>@lang('pages.faq.page_title')</h1>
                <p>@lang('pages.faq.page_from')- @lang('pages.faq.page_to')</p>
            </div>
        </div>
    </div>
</section>
<section id="content" class="faq-content">
    <div class="contentWrapper pad">
        <faq></faq>
    </div>
</section>
@endsection

@section('slider_type', 'grey')