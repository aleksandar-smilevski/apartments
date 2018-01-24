@extends('layouts.app')
<link href="{{ asset('css/show_user.css') }}" rel="stylesheet">

@section('content')
    <div class="wrapper">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif
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
                            <h5><b>Apartment name:</b> <a href="{{url('apartments/'. $apartment->id )}}"> {{$apartment->name}}</a></h5>
                        </div>
                        <div class="apartment-image">
                            <img src="../../img/app.jpg" alt="">

                            @if($apartment->user_id == Auth::user()->id)
                                <div>
                                    <button class="linkButton"><a href="{{ url('apartments/edit/' . $apartment->id)}}"> Edit apartment</a></button>

                                <form action="{{url ('apartments/delete/' . $apartment->id)}}" method="post">
                                    {{csrf_field()}}
                                    <button type="submit" class="linkButton"><a>Delete apartment</a></button>
                                </form>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>


        </div>

        <div class="user-details">
            <div class="user-reviews">
                <h4><b>Upcoming bookings ({{$upcoming->count()}})</b></h4>
                <h5>bookings for {{$user->name}}</h5>
                <hr>
                @foreach($upcoming as $reservation)
                    <div class="review-wrapper">
                        <div class="review-body">
                            <div class="review-person-image">
                                <img src="../../img/app.jpg" alt="">
                            </div>
                            <div class="review-person-detail">
                                    <h5><b>Apartment name:</b> <a   href="{{url('apartments/'. $reservation->apartment_id)}}">{{$reservation->apartment_name}}</a></h5>
                                <h5>From: {{$reservation->from}} - To: {{$reservation->to}} </h5>
                                <p><a href="/directions?apartment_id={{$reservation->apartment_id}}">Need directions?</a></p>
                            </div>

                        </div>
                    </div>
                    <div>

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

<style>
.linkButton {
background: none;
border: none;
color: #0066ff;
text-decoration: underline;
cursor: pointer;
}
</style>
