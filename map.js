function initMap() {

    var latlng = new google.maps.LatLng(35.308401,136.131592);
    var opts = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map"), opts);
  
    // move to point
    map.panTo(new google.maps.LatLng(35.308401, 136.131592));

  // Create the first marker
  var marker1 = new google.maps.Marker({
      position: { lat: -34.397, lng: 150.644 },
      map: map,
      draggable: true,
      title: "Drag me!",
      icon: {
          url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
      }
  });

  document.getElementById("point_A").value =
      marker1.getPosition().lat() + "," + marker1.getPosition().lng();

  // Create the second marker
  var marker2 = new google.maps.Marker({
      position: { lat: -35.397, lng: 151.644 },
      map: map,
      draggable: true,
      title: "Drag me!",
      icon: {
          url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
      }
  });
 
  document.getElementById("point_B").value =
      marker2.getPosition().lat() + ", " + marker2.getPosition().lng();


  // Add event listener for the first marker
  google.maps.event.addListener(marker1, "dragend", function (event) {
      document.getElementById("point_A").value =
          this.getPosition().lat() + ", " + this.getPosition().lng();
      validateInput();
      checkInput();      
  });

 
  // Add event listener for the second marker
  google.maps.event.addListener(marker2, "dragend", function (event) {
      document.getElementById("point_B").value =
          this.getPosition().lat() + ", " + this.getPosition().lng();
      validateInput();
      checkInput();      
  });

  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();

    if (!bounds.contains(marker1.getPosition())) {
        marker1.setPosition(bounds.getCenter());
    }

    if (!bounds.contains(marker2.getPosition())) {
        marker2.setPosition(bounds.getNorthEast())
    }
});

// draw line 
var coordinates = [
    marker1.getPosition(),
    marker2.getPosition()
  ];
  
  var line = new google.maps.Polyline({
    path: coordinates,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });
  
  line.setMap(map);
//   draw line and update every 20 ms
setInterval(function(){
    coordinates = [
      marker1.getPosition(),
      marker2.getPosition()
    ];
    line.setPath(coordinates);
}, 20);

//search feature

}

