@extends("master")

@section('title')
    @lang('pages.contact.page_to')
@endsection

@section ('fb-image', asset('kiwipost-ge.jpg'))
@section ('fb-title', 'კივი ფოსტა')
@section ('fb-description', 'დიდი ბრიტანეთიდან სიყვარულით')


@section('how')
@endsection

@section('video')
@endsection

@section('calculator')
@endsection

@section('news')
@endsection

@section('sections')
    <div class="c-page-container">
        <section id="page-title">
            <div class="overlay">
                <div class="contentWrapper">
                    <div class="title-wrapper vAlign geo upper">
                        <h1>@lang('pages.contact.page_title')</h1>
                        <p>@lang('pages.contact.page_from') - @lang('pages.contact.page_to')</p>
                    </div>
                </div>
            </div>
        </section>
        <contact-map></contact-map>
    </div>
@endsection

@section('slider')
@endsection

@section('slider_type', 'grey')