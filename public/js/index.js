$(document).ready(function(){
    var destination = document.getElementById('destination');
    var autocomplete = new google.maps.places.Autocomplete(destination);

    var pickerDateFrom = new Pikaday({ field: document.getElementById('from') });
    var pickerDateTo = new Pikaday({ field: document.getElementById('to') });

    google.maps.event.addDomListener(destination, 'keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
});