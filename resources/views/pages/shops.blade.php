@extends("master")

@section('how')
@endsection

@section('title')
    @lang('pages.news.page_to')
@endsection

@section('video')
@endsection


@section ('fb-image', asset('kiwipost-ge.jpg'))
@section ('fb-title', 'კივი ფოსტა')
@section ('fb-description', 'დიდი ბრიტანეთიდან სიყვარულით')


@section('calculator')
@endsection

{{--@section('news')--}}
{{--@endsection--}}

@section("slider")
@endsection

@section('sections')
<section id="page-title" class="news-lists-bg-title">
    <div class="overlay">
        <div class="contentWrapper">
            <div class="title-wrapper vAlign geo upper">
                <h1>@lang('pages.shops.page_title')</h1>
                <p>@lang('pages.shops.page_from') - @lang('pages.shops.page_to')</p>
            </div>
        </div>
    </div>
</section>
<shops> </shops>
@endsection

@section('slider_type', 'grey')