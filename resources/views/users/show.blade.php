@extends('layouts.app')
<link href="{{ asset('css/show_user.css') }}" rel="stylesheet">

@section('content')
    <div class="wrapper">
        <div class="user-personal">
            <div class="user-picture">
                <img src="../../img/demi.jpg" alt="">
            </div>
            <hr>
            <div class="user-name">
                <h4>Personal information</h4>
                <h5><b>Name:</b> {{$user->name}}</h5>
                <h5><b>Email: </b> {{$user->email}}</h5>
                <h5><b>Phone: </b> {{$user->phone}}</h5>
            </div>
            <hr>
            <div class="user-apartments">
                <h4>Listings ({{$apartments->count()}})</h4>
                @foreach($apartments as $apartment)
                    <div class="apartment-wrapper">
                        <div class="apartment-title">
                            <h5><b>Apartment name: </b> {{$apartment->name}}</h5>
                        </div>
                        <div class="apartment-image">
                            <img src="../../img/app.jpg" alt="">
                        </div>

                    </div>
                @endforeach
            </div>


        </div>

        <div class="user-details">
            <div class="user-reviews">
                <h3><b>Reviews ({{$reviews->count()}})</b></h3>
                <h4>Reviews from guests</h4>
                <hr>
                <br>
                @foreach($reviews as $review)
                    <div class="review-wrapper">
                        <div class="review-body">
                            <div class="review-person-image">
                                <img src="../../img/app.jpg" alt="">
                            </div>
                            <div class="review-person-detail">
                                <h4>User: {{$review->user_id}}</h4>
                                <h4>Review: {{$review->review}}</h4>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    </div>
@endsection
