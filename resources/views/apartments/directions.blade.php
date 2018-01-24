@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Input an address or POI to get directions to {{$apartment->name}}</h3>
        <form class="form-inline">
            <div class="form-group">
                <label for="origin">Origin:</label>
                <input type="text" class="form-control" id="origin" style="width:300px">
            </div>
            <button id="submit" type="button" class="btn btn-default">Get Directions</button>
        </form>

        <div id="map" style="display: block; height: 50%;"></div>

        {{--<div class="step-title">--}}
            {{--<hr>--}}
            {{--<form class="form-inline">--}}
                {{--<h4 style="display: inline-block">Need step-by-step directions?</h4>--}}
                {{--<button id="step-yes" type="button" class="btn btn-default">Yes, please!</button>--}}
            {{--</form>--}}

        {{--</div>--}}

        <hr>
        <div class="step" style="margin-bottom: 20px">
            <h3>Step-by-step directions</h3>

            <hr>
            <form class="form-inline">
                <button id="back" type="button" class="btn btn-default">Back <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                <button id="forward" type="button" class="btn btn-default">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </form>

            <div class="row">
                <ul id="steps"></ul>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var route;
        $('#forward').attr('disabled', 'disabled');
        $('#back').attr('disabled', 'disabled');
//        $('.step').hide();

        var map = new GMaps({
            div: '#map',
            lat: "{{$apartment->latitude}}",
            lng: "{{$apartment->longitude}}",
            scrollwheel: true
        });
        var originLatLng;
        var origin = document.getElementById('origin');
        var autocomplete = new google.maps.places.Autocomplete(origin);

        map.addMarker({
            lat: "{{$apartment->latitude}}",
            lng: "{{$apartment->longitude}}",
            title: "{{$apartment->name}}",
            infoWindow: {
                content: "<p>{{$apartment->name}}</p>"
            }
        });

        {{--map.drawCircle({--}}
            {{--lat: "{{$apartment->latitude}}",--}}
            {{--lng: "{{$apartment->longitude}}",--}}
            {{--radius: 500--}}
        {{--});--}}

        {{--console.log(circle.getBounds());--}}

        $("#submit").click(function(){
            var origin = $("#origin").val();
            if(origin == null || origin == undefined || origin == ""){
                alert("Please input a value in the origin field");
            } else {
                map.removeMarkers();
                map.cleanRoute();
                route = null;
                $("#steps").html("");
                GMaps.geocode({
                    address: $("#origin").val(),
                    callback: function (results, status) {
                        map.cleanRoute();
                        map.removeMarkers();
                        if(status == "OK"){
                            map.addMarker({
                                lat: "{{$apartment->latitude}}",
                                lng: "{{$apartment->longitude}}",
                                title: "{{$apartment->name}}",
                                infoWindow: {
                                    content: "<p>{{$apartment->name}}</p>"
                                }
                            });
                            var latlng = results[0].geometry.location;
                            originLatLng = latlng;
                            map.setCenter(latlng.lat(), latlng.lng());
                            map.addMarker({
                                lat: latlng.lat(),
                                lng: latlng.lng()
                            });
                            {{--map.drawRoute({--}}
                                {{--origin: [originLatLng.lat(), originLatLng.lng()],--}}
                                {{--destination: ["{{$apartment->latitude}}", "{{$apartment->longitude}}"],--}}
                                {{--travelMode: 'driving',--}}
                                {{--strokeColor: 'red',--}}
                                {{--strokeOpacity: 0.6,--}}
                                {{--strokeWeight: 6--}}
                            {{--});--}}
                            setNewDestination();
                        }
                    }
                })
            }

        });

        $('#forward').click(function(e){
            e.preventDefault();
            route.forward();

            if(route.step_count < route.steps_length) {
                $('#steps').append('<li>'+route.steps[route.step_count].instructions+'</li>');
                var step = route.steps[route.step_count - 1];
                console.log(step.end_location.lat(), step.end_location.lng());
                map.setCenter(step.end_location.lat(), step.end_location.lng());
            }

        });
        $('#back').click(function(e){
            e.preventDefault();
            route.back();

            if(route.step_count >= 0) {
                $('#steps').find('li').last().remove();
                if(route.steps[route.step_count - 1] == undefined) {
                    var step = route.steps[route.step_count + 1];
                    map.setCenter(step.end_location.lat(), step.end_location.lng());
                }
                var step = route.steps[route.step_count - 1];
                map.setCenter(step.end_location.lat(), step.end_location.lng());
            }
        });

        $("#step-yes").click(function () {
            $('.step').show();
            $('.step-title').hide();
//            map.cleanRoute();
//            map.removeMarkers();
            {{--map.getRoutes({--}}
                {{--origin: [originLatLng.lat(), originLatLng.lng()],--}}
                {{--destination: ["{{$apartment->latitude}}", "{{$apartment->longitude}}"],--}}
                {{--travelMode: 'driving',--}}
                {{--callback: function(e){--}}
                    {{--route = new GMaps.Route({--}}
                        {{--map: map,--}}
                        {{--route: e[0],--}}
                        {{--strokeColor: 'red',--}}
                        {{--strokeOpacity: 0.5,--}}
                        {{--strokeWeight: 10,--}}
                        {{--zoom: 8--}}
                    {{--});--}}
                    {{--$('#forward').removeAttr('disabled');--}}
                    {{--$('#back').removeAttr('disabled');--}}
                {{--}--}}
            {{--});--}}
            {{--map.setCenter(originLatLng.lat(), originLatLng.lng());--}}
            {{--map.addMarker({--}}
                {{--lat: originLatLng.lat(),--}}
                {{--lng: originLatLng.lng()--}}
            {{--});--}}
            {{--map.addMarker({--}}
                {{--lat: "{{$apartment->latitude}}",--}}
                {{--lng: "{{$apartment->longitude}}"--}}
            {{--});--}}
        });

        function setNewDestination(){
            map.getRoutes({
                origin: [originLatLng.lat(), originLatLng.lng()],
                destination: ["{{$apartment->latitude}}", "{{$apartment->longitude}}"],
                travelMode: 'driving',
                callback: function(e){
                    route = new GMaps.Route({
                        map: map,
                        route: e[0],
                        strokeColor: 'red',
                        strokeOpacity: 0.5,
                        strokeWeight: 10,
                        zoom: 8
                    });
                    $('#forward').removeAttr('disabled');
                    $('#back').removeAttr('disabled');
                }
            });
            map.setCenter(originLatLng.lat(), originLatLng.lng());
        }

    });


</script>