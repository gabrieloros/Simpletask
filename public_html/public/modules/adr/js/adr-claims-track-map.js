window.gMapsCallback = function() {
    $(window).trigger('gMapsLoaded');
};

/**
 * Create the map object
 */
var map;
function initialize() {
	
	$('#map-canvas').height("600px");

	//Create an array of styles.
	var styles = [{
		featureType: "road",
		elementType: "geometry",
		stylers: [
		          { lightness: 100 },
		          { visibility: "simplified" }
	    ]
	},{
		featureType: "poi",
		elementType: "labels",
		stylers: [
		          { visibility: "off" }
		]
	}];

	//Create a new StyledMapType object, passing it the array of styles,
	//as well as the name to be displayed on the map type control.
	var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

	//Map options
	var myOptions = {
		zoom : 14,
		//center : new google.maps.LatLng(-32.928473945540155, -68.85609626944643),
		mapTypeControlOptions: {
		      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
		},
		streetViewControl: false,
	    mapTypeControl: false,
	    scaleControl: false,
	    navigationControl: false,
	    streetViewControl: false
	};
	
	//The map
	map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
	
	//Associate the styled map with the MapTypeId and set it to display.
	map.mapTypes.set('map_style', styledMap);
	map.setMapTypeId('map_style');
	
	getPositionCenter();
	
	$('#map-canvas').click(function(){   
		  var valMap = map.getCenter();
		  
		});
	
}

/**
 * Load google maps if it is not loaded before
 */
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

/**
 * Draw claim markers on map
 */


var markers = [];
function addMarkersForClaim(index, claimId, claimCode, latitude, longitude, stateUrlIcon, center) {

	var newLatLng = new google.maps.LatLng(latitude, longitude);
	if(center){
		map.setCenter(newLatLng);
	}

	var markerId = claimId;
	var marker = new google.maps.Marker({
			id: markerId,
			position: newLatLng,
			map: map,
			icon: stateUrlIcon,
			draggable: false,
			zIndex: google.maps.Marker.MAX_ZINDEX + 1
	});
	
	var infowindow = new google.maps.InfoWindow();
	google.maps.event.addListener(marker, 'click', function(event) {

		var infowindowContent = '';
		//Get claim detail
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=getAdrClaim',
			async: true,
			data: {
				claimId: claimId
			},
			success: function(data){
				var result = eval(data[1]);
				if(result.length > 0) {
					var isData = true;
					if(result.length == 1) {
						if(result[0].code == 'no_data_found') {
							isData = false;
						}
					}
					
					if(isData){
						
						var claim = new Array();
						claim['code'] = result[0].code;      
						claim['state'] = result[0].state;
						claim['claimAddress'] = result[0].claimaddress;
						claim['requesterName'] = result[0].requestername;
						claim['requesterPhone'] = result[0].requesterphone;
						claim['requesterAddress'] = '';
						claim['subjectName'] = result[0].subjectname;
						claim['date'] = result[0].date;
						
						infowindowContent = getClaimInfowindowContent(claim);
					}
				}
	
			},complete: function(){
				infowindow.setContent(infowindowContent);
				infowindow.setPosition(event.latLng);
				infowindow.open(map);
				infowindowses[index] = infowindow;
			},
			error: function(){
				alert('Error en funcion addMarkersForClaim');
				alert(s_message['error_retrieving_data']);
			}
		});

    });
	
	// cache created marker to markers object with id as its key
	markers[index] = marker;
	return marker;

}

/**
 * Remove all claim markers on map
 */
function cleanMarkersForClaim() {
	for (var i = 0; i < markers.length; i++) {
		// find the marker by given id
		var marker = markers[i]; 
		marker.setMap(null);
	}
	markers = [];
}

/**
 * Draw user markers on map
 */
var userMarkers = [];
var infowindowses = [];
function updateMapForUser(index, idUser, latitude, longitude, stateUrlIcon, center) {

	var newLatLng = new google.maps.LatLng(latitude, longitude);
	if(center){
		map.setCenter(newLatLng);		
	}
	
	var markerId = idUser;
    var marker = new google.maps.Marker({
    	id: markerId,
    	position: newLatLng,
    	map: map,
    	icon: stateUrlIcon,
    	draggable: false
    });
    
    
    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', function(event) {
    	
    	var infowindowContent = '';
    	//Get claim detail
    	$.ajax({
    		scriptCharset: "utf-8" ,
    		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    		cache: false,
    		dataType: "json",
    		type: "POST",
    		url: window.location.pathname + '?action=getAdrUserById',
    		async: true,
    		data: {
    			userId: idUser
    		},
    		success: function(data){
    			var result = eval(data[1]);
    			if(result.length > 0) {
    				var isData = true;
    				if(result.length == 1) {
    					if(result[0].code == 'no_data_found') {
    						isData = false;
    					};
    				}
    				
    				if(isData){
    					infowindowContent = 
    						'<div id="infow-container">'+
    						'	<div class="infow-head" style="float: left; width: 60%;">'+s_message["user_firstname"]+': <b>'+result[0].firstname+' '+result[0].lastname+'</b></div>'+
    						'	<div class="infow-head" style="float: right; width: 40%;">'+s_message["state"]+': <b>'+result[0].state+'</b></div>'+
    						'	<div class="infow-body">'+
    						'		<ul id="infow-body-detail">'+
    						'			<li></li>'+
    						'		</ul>'+
    						'	</div>'+
    						'</div>';
    				};
    			};
    			
    		},complete: function(){
    			infowindow.setContent(infowindowContent);
    			infowindow.setPosition(event.latLng);
    			infowindow.open(map);
    			infowindowses[index] = infowindow;
    		},
    		error: function(){
				alert(s_message['error_retrieving_data']);
    		}
    	});
    });
    
	// cache created marker to markers object with id as its key
    userMarkers[index] = marker;
	return marker;
   
}

/**
 * Remove all user markers on map
 */
function cleanMarkersForUser() {
	for (var i = 0; i < userMarkers.length; i++) {
		// find the marker by given id
		var marker = userMarkers[i]; 
		marker.setMap(null);
	}
	userMarkers = [];

}

/**
 * Draw company markers on map
 */
var companyMarkers = [];
function updateMapForCompany(index, companyId, latitude, longitude, urlIcon) {

	var newLatLng = new google.maps.LatLng(latitude, longitude);
	var markerId = companyId;
    var marker = new google.maps.Marker({
    	id: markerId,
    	position: newLatLng,
    	map: map,
    	icon: urlIcon,
    	draggable: false
    });
    
    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', function(event) {

    	var infowindowContent = '';
		//Get company detail
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=getAdrPlanById',
			async: true,
			data: {
				planId: companyId
			},
			success: function(data){
				var result = eval(data[1]);
				if(result.length > 0) {
					var isData = true;
					if(result.length == 1) {
						if(result[0].id == 'no_data_found') {
							isData = false;
						}
					}
					
					if(isData){
						infowindowContent = 
							'<div id="infow-container">'+
					        '	<div class="infow-head" style="float: left; width: 60%;">'+s_message['adr_plan_name']+': <b>'+result[0].name+'</b></div>'+
					        '	<div class="infow-head" style="float: right; width: 40%;"></div>'+
					        '	<div class="infow-body">'+
					        '		<ul id="infow-body-detail">'+
					        '			<li></li>'+
					        '		</ul>'+
					        '	</div>'+
					        '</div>';
					}
				}
	
			},complete: function(){
				infowindow.setContent(infowindowContent);
				infowindow.setPosition(event.latLng);
				infowindow.open(map);
				infowindowses[index] = infowindow;
	    	},
			error: function(){
				alert(s_message['error_retrieving_data']);
			}
		});
    
    });
    
	// cache created marker to markers object with id as its key
    companyMarkers[index] = marker;
	return marker;
   
}

/**
 * Remove all company markers on map
 */
function cleanMarkersForCompany() {
	for (var i = 0; i < companyMarkers.length; i++) {
		// find the marker by given id
		var marker = companyMarkers[i]; 
		marker.setMap(null);
	}
	companyMarkers = [];

}

/**
 * Get the infowindow content for a claim
 * @param claim
 * @returns {String}
 */
function getClaimInfowindowContent(claim) {
	closedDate = '';
	if(claim['closedDate'] != null)
	{
    		closedDate = '                   <li>'+s_message['adr_claims_track_closed_date']+': <b>'+claim['closedDate']+'</b></li>';
	}
	var content = 
	'<div id="infow-container">'+
    '	<div class="infow-head" style="float: left; width: 60%;">'+s_message['claim_code']+': <b>'+claim['code']+'</b></div>'+
    '	<div class="infow-head" style="float: right; width: 40%;">'+s_message['state']+': <b>'+claim['state']+'</b></div>'+
    '	<div class="infow-body">'+
    '		<ul id="infow-body-detail">'+
    '			<li>'+s_message['adr_claims_address_title']+': <b>'+claim['claimAddress']+'</b></li>'+
    '			<li>'+s_message['adr_claims_track_requester_name']+': <b>'+claim['requesterName']+'</b></li>'+
    '			<li>'+s_message['requester_phone']+': <b>'+claim['requesterPhone']+'</b></li>'+
    '			<li>'+s_message['adr_claims_track_requester_address']+': <b>'+claim['requesterAddress']+'</b></li>'+
    '			<li><b>'+claim['subjectName']+'</b></li>'+
    '			<li>'+s_message['adr_claims_track_entry_date']+': <b>'+claim['date']+'</b></li>'+
	closedDate+
    '		</ul>'+
    '	</div>'+
    '</div>';
	
	return content;
}

/**
 * Remove all infowindowses
 */
function cleanInfowindows() {
	for ( var i = 0; i < infowindowses.length; i++) {
		
		//FIXME: corregir los undefined que aparecen en el array
		
		if (infowindowses[i] != undefined || infowindowses[i] != null) {
			infowindowses[i].close();
		}
	}
	infowindowses = [];
}
