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

@section('news')
@endsection

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
<section id="content" class="news">
    <div class="contentWrapper pad">
        <div class="news-list geo lower">

            @foreach ($news as $key => $value)
                <div class="news-view news-tiny clearfix">
                    <a  class="image" href="/news/{{ $value['id'] }}" style="background-image: url({{$value['image_url']}})"></a>
                    <div class="contents geo upper">
                        <a href="/news/{{ $value['id'] }}"><div class="title">{{ $value['title'] }}</div></a>
                        <div class="date">{{ $value['date'] }}</div>
                        <div class="text">
                            {{ $value['list_description'] }}
                        </div>
                        <div class="read-more upper"><a href="/news/{{ $value['id'] }}">@{{'read_more' | translate}}...</a></div>
                    </div>
                </div>
            @endforeach
            {{--<ul>--}}
                {{--{{ $news->links() }}--}}
            {{--</ul>--}}

            <div class="clearfix"></div>

        </div>
    </div>
</section>
@endsection

@section('slider_type', 'grey')