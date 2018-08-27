window.gMapsCallback = function() {
    $(window).trigger('gMapsLoaded');
};

var map;

$(document).ready(function() {
	// set tamaño del mapa
	$('#map-canvas').width($('#especific-content').width());
	$('#map-canvas').height("600px");
	
	function initialize() {
		//var center = new google.maps.LatLng(-32.92844512698737, -68.8564682006836);
		map = new google.maps.Map(document.getElementById('map-canvas'), {
			//center: center,
			zoom: 13,
			scrollwheel: false,
			streetViewControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		getPositionCenter();
		// Create a div to hold the control.
		var controlCenterMap = document.createElement('div');
		// Set CSS styles for the DIV containing the control
		// Setting padding to 5 px will offset the control
		// from the edge of the map.
		controlCenterMap.style.padding = '5px';
		// Set CSS for the control border.
		var controlUI = document.createElement('div');
		controlUI.title = 'Click aquí para centrar el mapa';
		$(controlUI).addClass('controlCenterMap');
		controlCenterMap.appendChild(controlUI);
		// Set CSS for the control interior.
		var controlText = document.createElement('div');
		$(controlText).addClass('controlCenterMapText');
		$(controlText).html('Centrar');
		controlUI.appendChild(controlText);
		// Position the center map control
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(controlCenterMap);
		// Center map on click
		google.maps.event.addDomListener(controlCenterMap, 'click', function() {
			map.setCenter(centerParameter);
		});
		
		var infowindow = new google.maps.InfoWindow();
		var strokeColor = $('#polygonStrokeColor').css('color');
		var coords;
		var coord;
		var polygon;
		var paths;
		
		$('.region').each(function() {
			var regionid = $(this).attr('id');
			paths = new Array();
			$('#' + regionid + ' > .coordinates').each(function() {
				coords = $(this).val().split(';');
				for (var i=0; i<coords.length; i++) {
					coord = coords[i].split(',');
					paths.push(new google.maps.LatLng(coord[0], coord[1]));
				}
			});

			// Region variables
			var regionname = $('#' + $(this).attr('id') + ' > #name').text();
			var regioncolor = $('#' + $(this).attr('id') + ' > #color').val();

			// Create polygon
			polygon = new google.maps.Polygon({
				paths: paths,
				strokeColor: strokeColor,
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: regioncolor,	
				fillOpacity: 0.35
			});
			// Put polygon in the map
			polygon.setMap(map);
			// Region title clicked
			/*google.maps.event.addDomListener(regionnameContainer, 'click', function() {
				map.setCenter(center);
			});*/
			// Polygon clicked
			google.maps.event.addListener(polygon, 'click', function(event) {

    			var positionId = regionid.indexOf("_") + 1;
				var regId = regionid.substring(positionId);

	            $.ajax({
	            	scriptCharset: "utf-8" ,
	        		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        		cache:false,
	        	    type:"POST",
	        	    /*data: formdata,*/
	        	    dataType: "json",
	                url: 'reclamos?action=getStatsByRegion&regionid='+regId+'&initdate='+$('#filter_date_left_entryDate').val()+'&enddate='+$('#filter_date_right_entryDate').val(),
	                success: function(data) {  
//	                	var init = data.indexOf("<");
//	                	var end = data.lastIndexOf(">") + 1;
//	                	var html = data.substring(init, end);

//	                	html = html.replace(/\\t/g, "")
//	                			   .replace(/\\n/g, "")
//	                			   .replace(/\\/g, "");
	                	
//	                	alert(data[3]);
	                	
                        infowindow.setContent(data[1][0]);
	    				infowindow.setPosition(event.latLng);
	    				infowindow.open(map);
	                }  
	            });
			});
			// Mouse over polygon
			google.maps.event.addListener(polygon, "mouseover", function () {
				this.setOptions({ fillColor: '#00ff00' });
			});
			// Mouse out of polygon
			google.maps.event.addListener(polygon, "mouseout", function () {
				this.setOptions({ fillColor: regioncolor });
			});

		});
	}
	
	function loadGoogleMaps() {
		//Check if google maps were previously loaded
		if ($('#googleMapsScript').length <= 0) {
	        var script_tag = document.createElement('script');
	        script_tag.setAttribute("type", "text/javascript");
	        script_tag.setAttribute("src", "http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
	        script_tag.setAttribute("id", "googleMapsScript");
	        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
		} else{
			$(window).trigger('gMapsLoaded');
		}
    }
	
	$(window).bind('gMapsLoaded', initialize);
	
	loadGoogleMaps();
});