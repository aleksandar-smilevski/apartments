@extends('layouts.app')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
@section('content')
<div class="wrapper">
    @foreach($apartments as $apartment)
        <div class="element-wrapper">
            <div class="element-title">
                <h4>{{$apartment -> name }}</h4>
                <h5>Appartment owner: {{$apartment -> user_id}}</h5>
            </div>
            <div class="element-body">
                <div class="element-picture">
                    <div class="element-price"> {{$apartment -> price}}$ </div>
                    <img src="../../img/app.jpg" alt="">
                </div>
                <div class="element-description">
                    <h5>{{$apartment -> description}}</h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div id="map"></div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARE0iIj2L9WbEiuQ96FyU6ZdTNcJ85FPs"></script>
<script>
    $(document).ready(function(){
        var map;
        var latlng = new google.maps.LatLng(42.009572,21.417419);
        map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 12
        });
    })
</script>

