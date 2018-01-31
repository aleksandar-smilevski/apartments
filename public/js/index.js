$(document).ready(function(){
    var destination = document.getElementById('destination');
    var autocomplete = new google.maps.places.Autocomplete(destination);

    var location;

    var pickerDateFrom = new Pikaday({
        field: document.getElementById('from'),
        minDate: new Date(),
        onSelect: function(){
            var date1 = pickerDateFrom.getDate();
            pickerDateTo.setMinDate(date1);
        }
    });
    var pickerDateTo = new Pikaday({ field: document.getElementById('to'), minDate: new Date(),
        onSelect: function () {
            var date1 = pickerDateTo.getDate();
            pickerDateFrom.setMaxDate(date1);
        }
    });

    google.maps.event.addDomListener(destination, 'keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        location = place.formatted_address;
    });

    $('#search').on('click', function(){
        if(location != undefined){
            document.getElementById("destination").value = location;
        }
    });

});