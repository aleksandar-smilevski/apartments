@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Input an address or POI to get directions to {{$apartment->name}}</h3>
        <form class="form-inline">
            <div class="form-group">
                <label for="origin">Origin:</label>
                <input type="text" class="form-control" id="origin" placeholder="" style="width:300px">
            </div>
            <button id="submit" type="button" class="btn btn-default">Get Directions</button>
            <button id="get-my-location" type="button" class="btn btn-default">Get Current Location</button>
        </form>

        <div id="map" style="display: block; height: 50%;"></div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var map = new GMaps({
            div: '#map',
            lat: "{{$apartment->latitude}}",
            lng: "{{$apartment->longitude}}",
            scrollwheel: true
        });

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

        $("#submit").click(function(){
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
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.addMarker({
                            lat: latlng.lat(),
                            lng: latlng.lng()
                        });
                        map.drawRoute({
                            origin: [latlng.lat(), latlng.lng()],
                            destination: ["{{$apartment->latitude}}", "{{$apartment->longitude}}"],
                            travelMode: 'driving',
                            strokeColor: 'red',
                            strokeOpacity: 0.5,
                            strokeWeight: 6
                        });
                    }
                }
            })
        });

        $( "#get-my-location" ).click( function(e) {
            e.preventDefault();

            /* HTML5 Geolocation */
            navigator.geolocation.getCurrentPosition(
                function( position ){ // success cb

                    /* Current Coordinate */
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var google_map_pos = new google.maps.LatLng( lat, lng );

                    /* Use Geocoder to get address */
                    var google_maps_geocoder = new google.maps.Geocoder();
                    google_maps_geocoder.geocode(
                        { 'latLng': google_map_pos },
                        function( results, status ) {
                            if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
                                $("#origin").val(results[0].formatted_address);
                                $("#submit").trigger("click");
                            }
                        }
                    );
                },
                function(){
                    alert("We cannot access your current location");
                }
            );
        });
    });

</script>