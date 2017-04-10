
<?php
require_once('essai2.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>

    <div class="parte1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam quis, cumque velit reprehenderit amet, esse fugiat similique, temporibus impedit quos, ea eaque vitae labore suscipit nulla veritatis eum mollitia facilis!</div>
    <div class="parte2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam quis, cumque velit reprehenderit amet, esse fugiat similique, temporibus impedit quos, ea eaque vitae labore suscipit nulla veritatis eum mollitia facilis!</div>
   <div id="map"></div>
   <div class="clear"></div>
    <script>
      var map;
      function initMap() {
          var myLatLng = {lat: 48.850046, lng: 2.280452}
       

          map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 12
        });
        var markers = ["p"];
        //création du marqueur
        var resultat = <?= json_encode($resultat); ?>;
        for(var i=0; i < resultat.length; i++){
          if(i == 150)break;
          var res = resultat[i].geo_coordinates.split(",");
          markers[i] = new google.maps.Marker({
              position: {lat: parseFloat(res[0]), lng: parseFloat(res[1])},
              animation: google.maps.Animation.DROP,
              map: map
          });
        }

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_pQO55smx8954HCzgkMR0HiZoJ-BCXWc&callback=initMap"
    async defer></script>
  </body>
</html>