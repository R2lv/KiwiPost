@extends("master")

@section('title')
    @lang('pages.about.page_to')
@endsection


@section ('fb-image', asset('kiwipost-ge.jpg'))
@section ('fb-title', asset('კივი ფოსტა'))
@section ('fb-description', asset('დიდი ბრიტანეთიდან სიყვარულით'))


@section('how')
@endsection

@section('video')
@endsection

@section('calculator')
@endsection

@section('sections')
<section id="page-title" class="about-title">
    <div class="overlay">
        <div class="contentWrapper">
            <div class="title-wrapper vAlign geo upper">
                <h1>@lang('pages.about.page_title')</h1>
                <p>@lang('pages.about.page_from') - @lang('pages.about.page_to')</p>
            </div>
        </div>
    </div>
</section>


<section id="content" class="geo upper">
    <div class="content-wrapper">
        <p class="about-text">{!!  $data['about_us']['description']  !!}</p>
        <div class="why-kiwi-title geo upper">{!!  $data['about_us']['title']  !!}</div>
    </div>
</section>

<section id="why-kiwi" class="geo lower">
    <div class="">
        <div class="" style="margin-bottom: 15px;">
            <div class="contentWrapper geo upper">
                {{--<p class="about-text">@lang('pages.pricing.page_text')</p>--}}
{{--                <div class="why-kiwi-title">{{ $data['about_us']['title'] }}</div>--}}
                <div class="why-blocks">
                    @foreach($data['about_us']['bullet_points'] as $point)
                        <div class="why-block">
                            <div class="image">
                                <img src="{{ $point['image_url'] }}" alt="">
                            </div>
                            <div class="block-footer">
                                <div class="title">
                                    {{ $point['title'] }}
                                </div>
                                <div class="mini-title">
                                    {!!  $point['description']  !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@section('slider_type', 'grey')