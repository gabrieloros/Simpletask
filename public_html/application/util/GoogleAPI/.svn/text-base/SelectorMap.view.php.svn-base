<?php
class SelectorMap extends Render{
	
	public function render($adresss, $fullAddress, $elementId){
		
		ob_start();		
		?>
		
		<div id="map_canvas" style="width: 540px; height: 430px;"></div>
		<div id="map-debug" style="height: 20px; display: none;"></div>
		
		<br />
		
		<input type="text" id="address_input" class="map_address_input" value="<?=$adresss?>" />
		
		<input type="hidden" id="locationAddress" value="<?=$fullAddress?>" />
		<input type="hidden" id="elementId" value="<?=$elementId?>" />
		<input type="hidden" id="location" value="<?=$_SESSION['loggedUser']->getLocationname()?>" />
		<input type="hidden" id="province" value="<?=$_SESSION['loggedUser']->getProvincename()?>" />
		
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
						addMarkerEventListener(marker, ''+results[0].geometry.location.Xa+'',''+results[0].geometry.location.Ya+'', address);
						
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
					disableAutoPan: true
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
					PopupManager.getActive().close();
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
				addMarkerEventListener(marker, position.Xa, position.Ya, '');
				
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
			
		    $(window).bind('gMapsLoaded', initialize);
			
		    loadGoogleMaps();			
			
		});
		</script>
		
		<?php		
		return ob_get_clean();
		
	}
	
}