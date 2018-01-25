@extends('layouts.app')
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/pikaday.css')}}" rel="stylesheet">
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/pikaday.min.js')}}"></script>


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
                    <div class="panel-heading">Make Reservation</div>

                    <div class="panel-body">
                        <form id="form" class="form-horizontal" method="POST" action="{{ route('create') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$apartment -> id}}" name="apartment_id">

                            <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }}">
                                <label for="from" class="col-md-4 control-label">Date from</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="from" name="from" type="text" placeholder="Pick date from...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="to" class="col-md-4 control-label">Date to</label>

                                <div class="col-md-6">
                                    <input class="form-control" id="to" name="to" type="text" placeholder="Pick date to...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value="" autofocus>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="pricePerNight" class="col-md-4 control-label">Price per night in $</label>

                                <div class="col-md-6">
                                    <input id="pricePerNight" type="text" class="form-control" name="pricePerNight" value="{{$apartment -> price}}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-md-4 control-label">Total price</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control" name="price" value="" readonly>
                                </div>
                            </div>

                            <p class="text-center">
                                <button id="submitForm" type="submit" class="btn btn-primary">
                                    Make reservation
                                </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var reservedDays = [];
            restrictDatePickers();

            var daysBetween;
            var pickerDateFrom = new Pikaday({
                field: document.getElementById('from'),
                minDate: new Date(),
                onSelect: function(){
                    var date1 = pickerDateFrom.getDate();
                    pickerDateTo.setMinDate(date1);
                    document.getElementById('to').value = "";
                },
                format: 'YYYY-MM-DD',
                disableDayFn: function (date) {
                    console.log(reservedDays);
                    for(var i=0;i<reservedDays.length;i++){

                        if(formatDate(reservedDays[i]) == formatDate(date))
                            return date
                    }

                }

            });
            var pickerDateTo = new Pikaday({
                field: document.getElementById('to'),
                onSelect: function(){
                    calculatePrice();
                },
                format: 'YYYY-MM-DD',
                disableDayFn: function (date) {
                    console.log(reservedDays);
                    for(var i=0;i<reservedDays.length;i++){

                        if(formatDate(reservedDays[i]) == formatDate(date))
                            return date
                    }

                }
            });

            function calculatePrice(){
                var from = pickerDateFrom.getDate();

                var to = pickerDateTo.getDate();
                console.log(from);
                daysBetween = (to - from)/1000/60/60/24;
                var pricePerNight = $('#pricePerNight').val();
                var price = pricePerNight * daysBetween;


                $('#price').val((daysBetween * pricePerNight));


            }
            function formatDate(date) {
                console.log('date'+ date);
                var datestring = date.getFullYear()+ "-" + (date.getMonth()+1) +"-"+ date.getDate() ;
                return datestring;
            }
            $('#submitForm').on('click', function(){

                var from1 = pickerDateFrom.getDate();
                var to1 = pickerDateTo.getDate();

                $('#from').val( formatDate(from1));
                $('#to').val(formatDate(to1));

                console.log();
            });

            function restrictDatePickers(){
                        @foreach ($reservations as $reservation)
                var from = "{{$reservation['from']}}";
                var to = "{{$reservation['to']}}";
                from = new Date(from.valueOf());
                to = new Date(to.valueOf());
                var dates = getDates(from, to);
                for(var j=0;j<dates.length;j++){
                    reservedDays.push(dates[j]);
                }




                @endforeach
                console.log(dates);
                function getDates(startDate, endDate) {

                    var dates = [],
                        currentDate = startDate,
                        addDays = function(days) {
                            var date = new Date(this.valueOf());
                            date.setDate(date.getDate() + days);
                            return date;
                        };
                    while (currentDate <= endDate) {
                        dates.push(currentDate);
                        currentDate = addDays.call(currentDate, 1);

                    }
                    return dates;
                };
            }


        });




    </script>
@endsection