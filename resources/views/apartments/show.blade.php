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
                   <h4>{{$user->name}}</h4>
               </div>
               <div class="apartment-body">
                   <p>
                       {{$apartment->description}}
                   </p>
               </div>
           </div>
           <div class="element-reservation">

               <a   href="{{url('apartments/'. $apartment->id . '/reservations')}}"> <button class="btn-primary btn">Make a reservation</button></a>
           </div>
           <div class="apartment-reviews">
               <h3>Reviews</h3>
               @foreach($reviews as $review)
                   <h4>{{$review -> username}}</h4>
                   <h5>{{$review->review}}</h5>
               @endforeach
           </div>
       </div>
   </div>
@endsection
