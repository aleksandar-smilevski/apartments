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
                <h4><b>Reviews ({{$reviews->count()}})</b></h4>
                <h5>Reviews from {{$user->name}}</h5>
                <hr>
                @foreach($reviews as $review)
                    <div class="review-wrapper">
                        <div class="review-body">
                            <div class="review-person-image">
                                <img src="../../img/app.jpg" alt="">
                            </div>
                            <div class="review-person-detail">
                                <h5><b>Apartment name:</b> <a   href="{{url('apartments/'. $review->apartment_id)}}">{{$review->apartment}}</a></h5>
                                <h5>Review: {{$review->review}}</h5>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    </div>
@endsection
