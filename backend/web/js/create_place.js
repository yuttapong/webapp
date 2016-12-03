/**
 * Created by RB on 21/6/2559.
 */

function setupListeners() {
    google.maps.event.addListener(searchbox, 'place_changed', function() {
        var place = searchbox.getPlace();
        if (!place.geometry) {
            return;
        }  else {
            populateResult(place);
        }
    });
}

function populateResult(place) {
    $('#googleplaces-location').val(JSON.stringify(place['geometry']['location']));
    $('#googleplaces-google_place_id').val(place['place_id']);
    $('#googleplaces-full_address').val(place['formatted_address']);
    $('#googleplaces-website').val(place['website']);
    $('#googleplaces-vicinity').val(place['vicinity']);
    $('#googleplaces-name').val(place['name']);
    loadMap(place['geometry']['location'],place['name']);
}

function loadMap(gps,name) {
    var mapcanvas = document.createElement('div');
    mapcanvas.id = 'mapcanvas';
    mapcanvas.style.height = '300px';
    mapcanvas.style.width = '300px';
    mapcanvas.style.border = '1px solid black';
    document.querySelector('article').appendChild(mapcanvas);
    var latlng = new google.maps.LatLng(gps['k'], gps['D']);
    var myOptions = {
        zoom: 16,
        center: latlng,
        mapTypeControl: false,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title:name
    });
}