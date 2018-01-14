<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index</title>

    {{--stylesheets--}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/index.css')}}" rel="stylesheet">
    <link href="{{asset('css/pikaday.css')}}" rel="stylesheet">

    {{--scripts--}}
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARE0iIj2L9WbEiuQ96FyU6ZdTNcJ85FPs&libraries=places"/>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARE0iIj2L9WbEiuQ96FyU6ZdTNcJ85FPs&libraries=places&callback=initMap" async defer></script>
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/pikaday.min.js')}}"></script>
</head>
<body>

<div class="wrapper">
    <div class="landing_image">
        <div class="form_wrapper">
            <div class="form_content">
                <div class="form_title">
                    <h2>Find the perfect place to stay</h2>
                </div>
                <div class="form_body">
                    <form action="{{url('apartments')}}" method="get" accept-charset="UTF-8">

                        <div class="form-group">
                            <label for="location">Pick a destination</label>
                            <input id="destination" name="destination" class="form-control" type="text" placeholder="Pick a destination...">
                        </div>

                        <div class="form-group">
                            <label for="from">Date from: </label>
                            <input class="form-control" id="from" name="from" type="text" placeholder="Pick date from...">
                        </div>
                        <div class="form-group">
                            <label for="to">Date to: </label>
                            <input class="form-control" id="to" type="text" name="to" placeholder="Pick  date to...">
                        </div>

                        <input type="submit" class="btn btn-default"  id="search"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
