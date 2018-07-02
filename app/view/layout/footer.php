        <!-- jQuery -->
        <script src="<?= $url; ?>/js/jquery.min.js"></script>

        <!-- jQuery -->
        <script src="<?= $url; ?>/js/bootstrap.min.js"></script>

        <!-- Custom JS -->
		<script src="<?= $url; ?>/js/main.js"></script>

        <script>
            $(document).ready(function() {
            
                var locations = <?=$location_data;?>;

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: new google.maps.LatLng(-33.711242, 19.585154),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow();

                var marker, i;

                for (i = 0; i < locations.length; i++) {  
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
                
            });
        </script>
    </body>
</html>