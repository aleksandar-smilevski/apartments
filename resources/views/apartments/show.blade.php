@extends('layouts.app')
<link href="{{ asset('css/show.css') }}" rel="stylesheet">

@section('content')
    <div class="wrapper">
        <div class="apartment-landing-image">
            <img src="../../img/app.jpg" alt="">
        </div>
        <div class="apartment-wrapper">
            <div class="apartment-information">
                <div class="apartment-title">
                    <h3>{{$apartment -> name}}</h3>
                    <h4>Owner:  <a   href="{{url('users/'. $apartment->user_id)}}">{{$user -> name}}</a></h4>
                </div>
                <hr>
                <div class="apartment-body">
                    <p>
                        Description
                    </p>
                    <p>
                        {{$apartment->description}}
                    </p>
                </div>
            </div>
            <div class="element-reservation">
                <a   href="{{url('apartments/'. $apartment->id . '/reservations')}}"> <button class="btn-primary btn">Make a reservation</button></a>
            </div>
            <br>
            <hr>
            <div class="apartment-reviews">
                <h3>Reviews</h3>
                @foreach($reviews as $review)
                    <div>
                        <h4>User:  <a   href="{{url('users/'. $apartment->user_id)}}">{{$review -> username}}</a></h4>
                        <h5>{{$review->review}}</h5>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
