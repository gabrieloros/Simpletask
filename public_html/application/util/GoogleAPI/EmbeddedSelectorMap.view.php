<?php
class EmbeddedSelectorMap extends Render{
	
	public function render($regions){
		
		$defaultAddress = $_SESSION['loggedUser']->getLocationname() . ' ' . $_SESSION['loggedUser']->getProvincename();
		
		ob_start();		
		?>
		
		<div id="map_canvas_container">
		
			<div id="map_canvas" style="height: 360px;"></div>
			<div id="map-debug" style="height: 20px; display: none;"></div>
			
			<br />
			
			<input type="text" id="address_input" class="map_address_input" value="" />
			<hr>Detalle:
			<input type="text"  id="detail_input" class="map_address_input" value="" />
			<input type="hidden" id="locationAddress" value="<?=$defaultAddress?>" />
			
			<input type="hidden" id="elementId" value="" />
			<input type="hidden" id="location" value="<?=$_SESSION['loggedUser']->getLocationname()?>" />
			<input type="hidden" id="province" value="<?=$_SESSION['loggedUser']->getProvincename()?>" />
			
			<?php 
			/* @var $region Region */
			foreach ($regions as $region) {
				$regioncolor = '#ffffff';
			?>
				<input class="region" id="region_<?= $region->getId() ?>" type="hidden" value="region_<?= $region->getId() ?>" />
				<input class="regionid" id="regionid" type="hidden" value="<?= $region->getId() ?>" />
				<input id="coorditates_region_<?= $region->getId() ?>" class="coordinates" type="hidden" value="<?= $region->getCoordinates() ?>" />
			<?php 
			}
			?>
		
		</div>
		
		<script type="text/javascript">
		window.gMapsCallback = function(){
		    $(window).trigger('gMapsLoaded');
		}

		//Global variable
		var map;
		
		$(document).ready(function(){
		    
			function initialize(){
			
				//Map options
				var mapOptions = {
		            zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
		        };

		        //Map instance
				map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
				//Retrieve address Geo Code
				var address = $('#locationAddress').val();

				//Add Marker
				addMarker(address);

				$('.region').each(function() {
					
					var strokeColor = '#000';
					var coords;
					var coord;
					var polygon;
					var regionid = $(this).attr('id');
					paths = new Array();
					
					$('#coorditates_' + regionid ).each(function() {
						coords = $(this).val().split(';');
						for (var i=0; i<coords.length; i++) {
							coord = coords[i].split(',');
							paths.push(new google.maps.LatLng(coord[0], coord[1]));
						}
					});

					// Create polygon
					polygon = new google.maps.Polygon({
						paths: paths,
						strokeColor: strokeColor,
						strokeOpacity: 1.0,
						strokeWeight: 2,
						fillOpacity: 0.0,
						clickable: false						
					});
					// Put polygon in the map
					polygon.setMap(map);
		
				});
				
		    }

		    //Creates new marker by inline input
		    function addMarker(address){

			    geocoder = new google.maps.Geocoder();	
				geocoder.geocode({'address': address}, function(results, status) {

					if (status == google.maps.GeocoderStatus.OK) {						

						//Create marker
						var marker = new google.maps.Marker({
							position: results[0].geometry.location,
							title: address,
							map: map
						});

						//Center map on marker location
						map.setCenter(results[0].geometry.location);

						//Markener listener to open info window
						addMarkerEventListener(marker, ''+results[0].geometry.location.lat()+'',''+results[0].geometry.location.lng()+'', address);
						
					}
					else {
						$('#map-debug:last').html('No se pudo cargar la Geolocalización: ' + status);
						$('#map-debug:last').show();
					}
				});

				//Map listener: when click on the map, adds marker
				google.maps.event.addListener(map, 'click', function(e) {
					placeMarker(e.latLng);
				});
			    
		    }

			//Adds marker listener to map
		    function addMarkerEventListener(marker, lat, long, address){

			    //Info window
				var infowindow = new google.maps.InfoWindow({
					maxWidth: 100,
					disableAutoPan: false
				});

				//If address is not set, perform reverse geo coding
				if(typeof address == 'undefined' || address == ''){

					//Reverse geocoding
			    	var latlng = new google.maps.LatLng(lat, long);
			    	geocoder.geocode({'latLng': latlng}, function(results, status) {
	
						if (status == google.maps.GeocoderStatus.OK) {
	
							if (results[1]) {
								//Market title
								marker.setTitle(results[1].formatted_address);
								//Marker info window content
								infowindow.setContent(results[1].formatted_address);
							} 
							else {
								$('#map-debug:last').html('No se encontraron resultados');
								$('#map-debug:last').show();
							}
						}
						else {
							$('#map-debug:last').html('No se pudo cargar la Geolocalización: ' + status);
							$('#map-debug:last').show();
						}
					});

				}
				else{
					//Set info window with address information
					infowindow.setContent(address);
				}
		    	
				//Marker click event listener
		    	google.maps.event.addListener(marker, 'click', function() {
					updateClaimGeoCodes(lat, long, '' + $('#elementId').val() + '', '' + $('#address_input').val() + '');
				});

				//Marker mouseover event listener: show info window
				google.maps.event.addListener(marker, 'mouseover', function() {
		    		infowindow.open(map,marker);
				});

				//Marker mouseout event listener: hide info window
		    	google.maps.event.addListener(marker, 'mouseout', function() {
		    		infowindow.close();
				});	
		    	
		    }

			//Creates new marker in map
			function placeMarker(position) {

				var marker = new google.maps.Marker({
					position: position,
					map: map
				});

				//Move map center
				map.panTo(position);
				
				//Add event listener to new marker
				addMarkerEventListener(marker, position.lat(), position.lng(), '');
				
			}

			//Address edition input event handler
		    $('#address_input').keydown(function(event){

		    	keynum = noNumbers(event);
            	
            	if(keynum == "13"){
            		var address = $('#address_input').val() + ' ' + $('#location').val() + ' ' + $('#province').val();
            		addMarker(address);
            	}
			    
		    });

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

		    $('div[id^="geolocate_button_"]').click(function(){

				//Selected element id
				var elementId = trimString($(this).attr('value'));

				//Hidden map element
				$('#elementId').val(elementId);
					
				//Selected element address
				var address = $('#address_' + elementId).html();

				//Address to perform geolocation query
				var fullAddress = '';

				if(typeof address == 'undefined' || address == null || address == ''){
					fullAddress = $('#location').val() + ' ' + $('#province').val();
				}
				else{
					fullAddress = address + ' ' + $('#location').val() + ' ' + $('#province').val();
				} 

				//Update visible input
				$('#address_input').val(address);

				//Perform geolocation query
				addMarker(fullAddress);
			    
			});

			$('div[id^="detail_button_"]').click(function(){

				//Selected element id
				var elementId = trimString($(this).attr('value'));

				//Hidden map element
				$('#elementId').val(elementId);


				//Selected element DETAIL
				var detail = $('#detail_' + elementId).html();

				$('#detail_input').val(detail);


				addMarker(detail);


			});

			function updateGeoLocationMap(elementId){
				
				
				
			}

		    $(window).bind('gMapsLoaded', initialize);

		    loadGoogleMaps();

		});
		</script>

		<?php		
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";		
		return ob_get_clean();
		
	}
	
}