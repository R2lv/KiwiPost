@extends("master")

@section('how')
@endsection

@section('video')
@endsection

@section('title')
    {{$page}}
@endsection
@section('calculator')
@endsection

@section('sections')
<div class="popup in-page">
<{{$page}} @if(request()->has("data")) custom-data="{{request()->get('data')}}" @endif></{{$page}}>
</div>
@endsection



@section('slider_type', 'grey')