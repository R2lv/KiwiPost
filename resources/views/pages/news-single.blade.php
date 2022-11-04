@extends("master")

@section('title')
    @lang('pages.news.page_to')
@endsection

@section('how')
@endsection

@section('video')
@endsection

@section('calculator')
@endsection

@section ('fb-image',asset($current['image_url']))

@section ('fb-title',$current['title'])

@section ('fb-description', $current['list_description'])



@section('sections')
<section id="page-title" class="news-lists-bg-title">
    <div class="overlay">
        <div class="contentWrapper">
            <div class="title-wrapper vAlign geo upper">
                <h1>@lang('pages.news.page_title')</h1>
                <p>@lang('pages.news.page_from') - @lang('pages.news.page_to')</p>
            </div>
        </div>
    </div>
</section>
<section id="content" class="geo lower">
    <div class="news-full">
        <div class="image">
            <img src="{{ $current['image_url'] }}" alt="">
        </div>
        <div class="date">
            {{ $current['date'] }}
        </div>
        <div class="title-box clearfix">
            <div class="title">
            {{ $current['title'] }}
            </div>
            <div class="sharing">
                {{--<a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" target="_blank"><img src="/images/share-fb.png" alt=""></a>--}}
                <div class="fb-share-button" data-href="{{ request()->url() }}" data-layout="button" data-size="small" data-mobile-iframe="true"></div>
                {{--<a href="#"><img src="/images/share-g+.png" alt=""></a>--}}
            </div>
        </div>
        <div class="text">
             {!! $current['full_description'] !!}
        </div>
    </div>
</section>
@endsection



@section('slider_type', 'grey')