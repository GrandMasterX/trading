var geocoder;
var map;
var map;
var markers = [];
function initialize(adr, update) {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(55.7522222, 37.6155556);
    var mapOptions = {
      zoom: 12,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map_holder'), mapOptions);
//    marker = new google.maps.Marker({
//        map: map,
//        position: latlng
//    });

    addMarker(latlng);
    
    if (update) {
        codeAddress(adr);    
    }
}

function codeAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        deleteOverlays();
        addMarker(results[0].geometry.location);        
//        marker = new google.maps.Marker({
//            map: map,
//            position: results[0].geometry.location
//        });
        $("#Object_latitude").val(results[0].geometry.location.lat());
        $("#Object_longitude").val(results[0].geometry.location.lng());

      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
}

// Add a marker to the map and push to the array.
function addMarker(location) {
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
    markers.push(marker);
}

// Sets the map on all markers in the array.
function setAllMap(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
}

// Removes the overlays from the map, but keeps them in the array.
function clearOverlays() {
    setAllMap(null);
}

// Shows any overlays currently in the array.
function showOverlays() {
    setAllMap(map);
}

// Deletes all markers in the array by removing references to them.
function deleteOverlays() {
    clearOverlays();
    markers = [];
}

