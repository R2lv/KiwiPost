@extends("master")

@section('title')
    @lang('pages.pricing.page_to')
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

@section('sections')
<section id="page-title" class="price-title">
    <div class="overlay">
        <div class="contentWrapper">
            <div class="title-wrapper vAlign geo upper">
                <h1>@lang('pages.pricing.page_title')</h1>
                <p>@lang('pages.pricing.page_from') - @lang('pages.pricing.page_to')</p>
            </div>
        </div>
    </div>
</section>
<pricing></pricing>
@endsection



@section('slider_type', 'grey')

@push('scripts:before')
<script>
    var pricing = @json($pricing);
</script>
@endpush