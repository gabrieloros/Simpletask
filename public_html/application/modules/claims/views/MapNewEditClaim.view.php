<?php

class MapNewEditClaim extends Render{
	
	public function render($lat, $lon, $title){
		
		ob_start();
		
		?>
		
		<div id="map_canvas"></div>
		<div id="map-debug" style="height: 20px; display: none;"></div>
	
		<br />
		
		<script type="text/javascript">

			window.gMapsCallback = function(){
			    $(window).trigger('gMapsLoaded');
			};

			function initialize(){

				//Map options
				var mapOptions = {
		            zoom: 13,
		            center : new google.maps.LatLng(<?=$lat?>, <?=$lon?>),
					mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		        //Map instance
				map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

				newLatitude = <?=$lat?>;
				newLongitude = <?=$lon?>;
				
				<?php
				//Create marker
				$markerIcon = '/modules/claims/css/img/state_0.png';
				$markerTitle = $title;
				
				?>
				var position = new google.maps.LatLng(<?=$lat?>,<?=$lon?>);

				var marker = new google.maps.Marker({
					position: position,
					draggable: true,
					animation: google.maps.Animation.DROP,
					title: '<?=$markerTitle?>',
					map: map,
					icon: '<?=$markerIcon?>'
				});

				//Marker last position
				google.maps.event.addListener(marker, 'dragend', function(){
					newLatitude = marker.getPosition().lat();
					newLongitude = marker.getPosition().lng();
				});

		    }

			//Load Google Maps scripts
			function loadGoogleMaps(){

				//Check if google maps were previously loaded
				if($('#googleMapsScript').length <= 0){
			        var script_tag = document.createElement('script');
			        script_tag.setAttribute("type","text/javascript");
			        script_tag.setAttribute("src","http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
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