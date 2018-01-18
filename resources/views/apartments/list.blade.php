@extends('layouts.app')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
@section('content')
<div class="wrapper">
    @foreach($apartments as $apartment)
        <div class="element-wrapper">
            <div class="element-title">
                <h2>{{$apartment -> name }}</h2>
                <h5>Location: {{$apartment -> longitude}}, {{$apartment -> latitude}}</h5>
            </div>
            <div class="element-body">
                <div class="element-picture">
                    <div class="element-price"> {{$apartment -> price}}$ </div>
                    <img src="../../img/app.jpg" alt="">
                </div>
                <div class="element-description">
                    <h3>{{$apartment -> description}}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
