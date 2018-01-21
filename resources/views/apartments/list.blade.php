@extends('layouts.app')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
@section('content')
<div class="wrapper">
    <h1> You searched for: {{$location["locality"]}}</h1>
    @if(!empty($dates))
        <h3>From: {{$dates["from"]}} - To: {{$dates["to"]}}</h3>
    @endif
    <hr>
    @if(count($apartments) != 0)
        @foreach($apartments as $apartment)
            <div class="element-wrapper">
                <div class="element-title">
                    <h4><a   href="{{url('apartments/'. $apartment["id"])}}">{{$apartment["name"]}}</a></h4>
                    <h5>Owner:  <a   href="{{url('users/'. $apartment["user_id"])}}">{{$apartment["username"]}}</a></h5>
                </div>
                <div class="element-body">
                    <div class="element-picture">
                        <div class="element-price"> {{$apartment["price"]}}$ </div>
                        <a   href="{{url('apartments/'. $apartment["user_id"])}}"> <img src="../../img/app.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h4 class="text-center">Sorry! No listings for your search</h4>
    @endif

</div>
<div id="map"></div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var map;
        var latlng = new google.maps.LatLng("{{$location["latitude"]}}","{{$location["longitude"]}}");
        map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 12,
            gestureHandling: 'greedy'
        });

        var markers = [];
        var infowindow = new google.maps.InfoWindow;

        @foreach ($apartments as $apartment)
            var latlng = new google.maps.LatLng("{{$apartment["latitude"]}}", "{{$apartment["longitude"]}}");
            var marker = new google.maps.Marker;
            marker.setPosition(latlng);
            marker.setMap(map);
            markers.push(marker);
            google.maps.event.addListener(marker,'click',function() {
                var infoWindowHtml = "<div class='element-wrapper-infowindow'>" +
                    "<div><h4><a href='{{url('apartments/'. $apartment["id"])}}'>{{$apartment["name"]}}</a></h4></div>" +
                    "<div class='element-body'>" +
                    "<div class='element-picture'>" +
                        "<div class='element-price'> {{$apartment["price"]}}$ </div>" +
                        "<a href='{{url('apartments/'. $apartment["user_id"])}}'><img src='../../img/app.jpg' alt=''></a>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
                infowindow.setContent(infoWindowHtml);
                infowindow.open(map, this);
                map.setCenter(latlng);
            });
        @endforeach

    });
</script>

