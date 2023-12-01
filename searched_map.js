function initMap() {
    const point_a = document.getElementById("point_a").innerText;
    const point_b = document.getElementById("point_b").innerText;

    const [lat_a, lng_a] = point_a.split(",").map(parseFloat);
    const [lat_b, lng_b] = point_b.split(",").map(parseFloat);

    const pointA = new google.maps.LatLng(lat_a, lng_a);
    const pointB = new google.maps.LatLng(lat_b, lng_b);

    const avgLat = (lat_a + lat_b) / 2;
    const avgLng = (lng_a + lng_b) / 2;
    const latlng = new google.maps.LatLng(avgLat, avgLng);


    var opts = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map"), opts);

    //マップのズームをぬけ道の長さに合わせる
    const bounds = new google.maps.LatLngBounds();
    bounds.extend(pointA);
    bounds.extend(pointB);
    map.fitBounds(bounds);

    // move to point
    map.panTo(latlng);
    // Create the first marker
    var marker1 = new google.maps.Marker({
        position: {
            lat: pointA.lat(),
            lng: pointA.lng()
        },
        map: map,
        draggable: false,
        title: "point A",
        icon: {

            url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
        }
    });


    // Create the second marker
    var marker2 = new google.maps.Marker({
        position: {
            lat: pointB.lat(),
            lng: pointB.lng()
        },
        map: map,
        draggable: false,
        title: "point B",
        icon: {
            url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        }
    });
    // 線を引く
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
    line.setPath(coordinates);
}

// Wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', function () {

    // Get all .search-result elements
    var searchResults = document.querySelectorAll('.search-result');

    // Loop through all .search-result elements and add a click event listener
    for (var i = 0; i < searchResults.length; i++) {
        searchResults[i].addEventListener('click', function () {
            console.log("clicked");
            // Get the data to populate the popup from the clicked element
            var routeName = this.querySelector('.route-name').textContent;
            var point_a = this.querySelector('#result-point_a').textContent;
            var point_b = this.querySelector('#result-point_b').textContent;
            var shortcut_id = this.querySelector('#result-shortcut_id').textContent;

            // Create the popup and background
            var popup = document.createElement('div');
            popup.classList.add('popup');
            var background = document.createElement('div');
            background.classList.add('popup-background');

            // Create the close button
            var closeButton = document.createElement('span');
            closeButton.classList.add('popup-close');
            closeButton.innerHTML = '&times;';

            // Add the data and close button to the popup
            popup.innerHTML = '<div class="map-box">\
                    <div id="map"></div>\
                    <p id="point_a" style="display:none;"></p>\
                    <p id="point_b" style="display:none;"></p>\
                    <div id="votingBtns"></div>\
                    <h1 id="route-name" ></h1>\
                  </div>';

            popup.querySelector('#point_a').textContent = point_a;
            popup.querySelector('#point_b').textContent = point_b;
            popup.querySelector('#route-name').textContent = routeName;
            popup.appendChild(closeButton);

            // Append the popup and background to the body
            document.body.appendChild(background);
            document.body.appendChild(popup);

            // Show the popup and background
            popup.style.display = 'block';
            background.style.display = 'block';
            //votes btns
            var formData = new FormData();
            formData.append('shortcut_id', shortcut_id);

            fetch("myvote.php", { method: "POST", body: formData })
                .then(response => response.json())
                .then(data => {
                    var demo = lidi({

                        hWrap: popup.querySelector("#votingBtns"),
                        //set current vote status
                        status : data.vote ? data.vote[0].vote : 0,
                        count : data.sum ? data.sum[0].total_votes : 0,

                        //update votes realtime
                        change: status => {
                            console.log(shortcut_id);
                            var data = new FormData();
                            data.append("shortcut_id", shortcut_id);
                            data.append("vote", status);
                            console.log(status);
                            fetch("insertvote.php", { method: "POST", body: data })
                                .then(res => res.json())
                                .then(count => {
                                    status = count.vote[0].vote;
                                    count = count.sum[0].total_votes;
                                    demo.recount(count);
                                    demo.status(status);
                                })
                                .catch(err => console.error(err));
                        }

                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Close the popup when the close button is clicked
            closeButton.addEventListener('click', function () {
                popup.remove();
                background.remove();
            });

            // Initialize the map
            initMap(point_a, point_b);
        });
    }
});
