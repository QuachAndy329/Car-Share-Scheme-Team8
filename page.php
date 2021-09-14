<h1 class="title">MelTravel</h1>
<!DOCTYPE html>
<html>
  <head>
    <title>Add Map</title>

    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 500px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const melbourne = { lat: -37.840935, lng: 144.946457 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 4,
          center: melbourne,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: melbourne,
          map: map,
        });
      }
    </script>   
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_LvD0va-7UvQXIa0F6lu7PXBeFaOLdZU&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>
