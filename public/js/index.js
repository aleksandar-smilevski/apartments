$(document).ready(function(){
    var destination = document.getElementById('destination');
    var autocomplete = new google.maps.places.Autocomplete(destination);

    var location = [];

    var pickerDateFrom = new Pikaday({ field: document.getElementById('from') });
    var pickerDateTo = new Pikaday({ field: document.getElementById('to') });

    google.maps.event.addDomListener(destination, 'keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var place = autocomplete.getPlace();

        var lat = place.geometry.location.lat(),
            lng = place.geometry.location.lng();

        location.push(lat);
        location.push(lng);
    });

    $('#search').on('click', function(){
        document.getElementById("destination").value = location;
    });

});