@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div><br />
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Create Apartment</div>

                    <div class="panel-body">
                        <form id="form" class="form-horizontal" method="POST" action="{{ action('ApartmentsController@update', $id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{$apartment->name}}" autofocus>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value="{{$apartment->description}}" autofocus>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address" value="{{$apartment->address}}" autofocus>
                                </div>
                            </div>



                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-4 control-label">Price</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control" name="price" value="{{$apartment->price}}" autofocus>
                                </div>
                            </div>

                            <input type="hidden" id="addressLat" name="addressLat" value="{{$apartment->latitude}}">
                            <input type="hidden" id="addressLng" name="addressLng" value="{{$apartment->longitude}}">

                            <p class="text-center"><label for="location" class="col-md-12">Please set the marker on the exact location of your apartment</label></p>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="map" style="height: 500px"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function initialize() {
            var input = document.getElementById('address');
            var latlng = new google.maps.LatLng($("#addressLat").val(), $("#addressLng").val());
            var marker = new google.maps.Marker;
            var geocoder = new google.maps.Geocoder;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: latlng,
                gestureHandling: 'greedy'
            });
            marker.setMap(map);
            marker.setPosition(latlng);
            marker.setDraggable(true);
            marker.addListener('dragend', handleEvent);

            function handleEvent(event){
                geocodeLatLng(geocoder, map, event.latLng, marker);
            }

            function geocodeLatLng(geocoder, map, latlng, marker) {
                var latLng = {lat: parseFloat(latlng.lat()), lng: parseFloat(latlng.lng())};
                geocoder.geocode({'location': latLng}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $("#addressLat").val(results[0].geometry.location.lat());
                            $("#addressLng").val(results[0].geometry.location.lng());
                            console.log($("#addressLat").val());
                            console.log($("#addressLng").val());
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }

            $("#address").focusout(function () {
                var address = $("#address").val();
                $.ajax({
                    url: '/geocode',
                    type: 'get',
                    data: {
                        address: address
                    },
                    success: function (data) {
                        var latlng = new google.maps.LatLng(data.latitude, data.longitude);
                        map.setCenter(latlng);
                        marker.setPosition(latlng);
                        $("#addressLat").val(data.latitude);
                        $("#addressLng").val(data.longitude);
                        map.setZoom(15);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $('#form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection