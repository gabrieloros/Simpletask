<?php

class MapNewMultipleClaims extends Render{
	
	public function render($lat, $lon, $markers){
		
		ob_start();
		// // Load map
		// draw = true;
		// loadGoogleMaps();
		?>
		
		<div id="map_canvas"></div>
		<div id="map-debug" style="height: 20px; display: none;"></div>
	
		<br />
		
		<script type="text/javascript">

			window.gMapsCallback = function(){
				$(window).trigger('gMapsLoaded');
			};

			function initialize(){
				
				
				var marker = null;
				var index = 0;
				//Map options
				var mapOptions = {
		            zoom: 13,
		            center : new google.maps.LatLng(<?=$lat?>, <?=$lon?>),
					mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		        //Map instance
				map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
				var datos = [];		
				newLatitude = <?=$lat?>;
				newLongitude = <?=$lon?>;
				markers = <?=$markers?>
					<?php
					//Create marker
					$markerIcon = '/modules/claims/css/icon/mm_20_verde.png';
					$markerTitle = $title;

					?>
					
					google.maps.event.addListener(map, 'click', function(event) {
					addMarker(event.latLng, map);
					index++;
					});

					function addMarker(location, map) {
						
							var marker = new google.maps.Marker({
							position: location,
							draggable: true,
							animation: google.maps.Animation.DROP,
							icon: '<?=$markerIcon?>',
							map: map,
							index: index
							});
							datos.push(marker.getPosition());
						
							markers = datos;
							//markers[index] = marker;
					}

				google.maps.event.addDomListener(window, 'load', initialize);
				//Marker last position
				google.maps.event.addListener(marker, 'dragend', function(){
					newLatitude = marker.getPosition().lat();
					newLongitude = marker.getPosition().lng();
					points = marker.getPosition();
				});
				
				return markers;
		    }

			//Load Google Maps scripts
			function loadGoogleMaps(){

				//Check if google maps were previously loaded
				if($('#googleMapsScript').length <= 0){
			        var script_tag = document.createElement('script');
			        script_tag.setAttribute("type","text/javascript");
			        script_tag.setAttribute("src","http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback&libraries=geometry");
			        script_tag.setAttribute("id","googleMapsScript");
			        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
				}
				else{
					$(window).trigger('gMapsLoaded');
				}
				
		    }
			
		    $(window).bind('gMapsLoaded', initialize);
			
		    loadGoogleMaps();
		
		</script>
		<script type="text/javascript" src="/modules/settings/js/layers.js"></script>
		<?php
			
		

		return ob_get_clean();
		
	}

}