@extends("master")


@section('title')
    @lang('pages.dashboard.page_to')
@endsection


@section ('fb-image', asset('kiwipost-ge.jpg'))
@section ('fb-title', 'კივი ფოსტა')
@section ('fb-description', 'დიდი ბრიტანეთიდან სიყვარულით')


@section('sections')



{{--<section id="address"></section>--}}
<addresses></addresses>
<notifications></notifications>

<section id="search" class="">
    <div class="search-form">
        <div class="input vAlign">
            <input placeholder="Enter your tracking number">
            <div class="search-icon"> </div>
        </div>
    </div>
</section>



<parcels></parcels>


@section("calculator")
    <section id="calculator" style="padding-top: 70px;background: #23262D;margin-bottom: 35px;">
        <div id="calc-skew-wrapper">
            <div id="calc-skew">
                <div class="contentWrapper">
                    <div class="left-block geo upper">
                        <calculator></calculator>
                    </div>
                </div>
            </div>
        </div>
    </section>
@show

@endsection