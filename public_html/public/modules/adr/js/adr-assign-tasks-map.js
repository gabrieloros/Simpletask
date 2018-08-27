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
		
	console.log('creando mapa');
	//Map options
	var myOptions = {
		zoom : 8,		
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
	// var malvern = new google.maps.LatLng(52.106834, -2.3305105);
	// var pin2 = new google.maps.Marker({
	// 	position: malvern,
	// 	map: map,
	// 	zIndex: 2,
	// 	optimized: false
	//   });
	// var limites = new google.maps.LatLngBounds();
	// limites.extend(pin2.position);
	// map.fitBounds(limites);
	if(draw) {
		creator = new PolygonCreator(map);
	}
	
	//Posicionamos el mapa en el centro que se obtiene como parametro de la base de datos
	getPositionCenter();
	
}

/**
 * Load google maps if it is not loaded before
 */
var draw = false;
function loadGoogleMaps() {

	//Check if google maps were previously loaded
	if ($('#googleMapsScript').length <= 0) {
        var script_tag = document.createElement('script');
        script_tag.setAttribute("type", "text/javascript");
        script_tag.setAttribute("src", "http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback&libraries=geometry");
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
function addMarkersForClaim(index, claimId,priority,cause, claimCode, latitude, longitude, critical,groupid,icon,namegroup) {
	if(groupid == undefined){
		groupid= null;
	}

	if(cause != null || priority != null || critical != null ){

		stateUrlIcon = "/modules/claims/css/img/"+cause+"_"+priority+"_"+critical+".png";
	} 
	else
	{
		critical = 0;
		if(groupid == null){
		stateUrlIcon = "/modules/claims/css/icon/mm_20_gris.png"
		}
		else
		{
			stateUrlIcon = "/modules/claims/css/icon/mm_20_verde.png"
			//stateUrlIcon = "/modules/claims/css/icon/"+icon;
		}
	}

	var newLatLng = new google.maps.LatLng(latitude, longitude);
	var markerId = claimId;
	var marker = new google.maps.Marker({
			id: markerId,
			position: newLatLng,
			map: map,
			icon: stateUrlIcon,
			draggable: false,
			critical: critical,
			groupId: groupid,
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
						claim['namegroup'] = result[0].namegroup;
						
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
				alert(s_message['error_retrieving_data']);
			}
		});

    });
	
	// cache created marker to markers object with id as its key
	markers[index] = marker;
	return marker;

}

function coloursClaimsbyGroup(groupId,icon) {

	for (var i = 0; i < markers.length; i++) {
		var marker = markers[i];
		
		if(marker.groupId == groupId){
			iconNew = "/modules/claims/css/icon/"+icon;
			marker.setIcon(iconNew);
		var claim = marker;
		claim['index'] = i;
		dynamicClaimsList(claim);
		} else{
		 	if(marker.groupId == null){
				stateUrlIcon = "/modules/claims/css/icon/mm_20_gris.png"
				marker.setIcon(stateUrlIcon);
		 		}
		 		else
				{
					 stateUrlIcon = "/modules/claims/css/icon/mm_20_verde.png"
					 marker.setIcon(stateUrlIcon);
		 		}
			

		 }
	}


						
					
					
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
function updateMapForUser(index, idUser, latitude, longitude, stateUrlIcon) {

	var newLatLng = new google.maps.LatLng(latitude, longitude);
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
 * Draw assigned claim markers
 */
var assignedClaimsMarkers = [];
function addMarkersForAssignedClaim(claim) {

	var newLatLng = new google.maps.LatLng(claim.lat, claim.long);
	var markerId = claim.id;
	var marker = new google.maps.Marker({
			id: markerId,
			position: newLatLng,
			map: map,
			icon: claim.icon,
			draggable: false,
			critical: claim.isCritical,
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
				claimId: claim.id
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
						claim['closedDate'] = result[0].closeddate;
						
						infowindowContent = getClaimInfowindowContent(claim);
					}
				}
	
			},complete: function(){
				infowindow.setContent(infowindowContent);
				infowindow.setPosition(event.latLng);
				infowindow.open(map);
				infowindowses[claim.index] = infowindow;
			},
			error: function(){
				alert(s_message['error_retrieving_data']);
			}
		});

    });
	
	// cache created marker to markers object with id as its key
	assignedClaimsMarkers[claim.index] = marker;
	return marker;

}

/**
 * Remove all assigned claim markers on map
 */
function cleanAssignedClaimsMarkers() {
	for (var i = 0; i < assignedClaimsMarkers.length; i++) {
		// find the marker by given id
		var marker = assignedClaimsMarkers[i]; 
		marker.setMap(null);
	}
	assignedClaimsMarkers = [];
}

/**
 * Draw company markers on map
 */
var companyMarkers = [];
var infow = [];
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
	'           <li>'+'Nombre de Grupo'+': <b>'+claim['namegroup']+'</b></li>'+
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

/**
 * Get the vertex coordinates of the drawn polygon
 */
function getPolygonCoords() {
	if(null == creator.showData()){
		$('#polygon-coords-path').val('Error');
	}
	else{		
		$('#polygon-coords-path').val(creator.showData());
	}
}

/**
 * Get the claims coordinates inside the drawn polygon
 */
function getClaimsInPolygon(){

	var polyCoords = $('#polygon-coords-path').val();	
	var newPolygon = polyCoords.substring(0, polyCoords.indexOf(")") + 1);
	var polyNewCoords = polyCoords.concat(newPolygon);
	polyNewCoords = polyNewCoords.replaceAll(")(", ";");
	polyNewCoords = polyNewCoords.replace("(","");
	polyNewCoords = polyNewCoords.replace(")","");
	polyNewCoords = polyNewCoords.split(";");
	
	getPointsInPolygon(polyNewCoords, claims);
	
}

/**
 * Delete the polygon
 */
function deletePolygon(){

	creator.destroy();
	creator = null;
	creator = new PolygonCreator(map);
	$('#polygon-coords-path').val("");

}

/**
 * Get markers coordinates inside a polygon 
 * @param polygonVertex
 * @param points
 */
function getPointsInPolygon(polygon, claims) {

	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getPointsInsidePolygon',
		async: true,
		data: {
			polygon: polygon,
			claims: claims
		},
		success: function(data){
			
			result = eval(data[1]);
			
			if(result.length > 0) {

				var isData = true;
				if(result.length == 1) {
					if(result[0].isWithin == 'no_data_found') {
						isData = false;
					}
				}
				
				if(isData){
					for (var i = 0; i < result.length; i++) {
					
						//Append to list
						var claim = result[i];
						dynamicClaimsList(claim);
						
						//Update markers state
						setClaimMarkerToAssignedState(claim.id);

					}
				}
			}	
		},
		error: function(){
			alert(s_message['error_retrieving_data']);
		}
	});

}

/**
 * Set the claim marker to assigned
 * @param claimId
 */
var onEdition = 0;
function setClaimMarkerToAssignedState(claimId) {
	
	onEdition = 1;
	for(var i = 0; i < markers.length; i++) {
		
		if(markers[i].id == claimId){
			var newImage = new google.maps.MarkerImage("/modules/claims/css/icon/mm_20_celeste.png");
			markers[i].setIcon(newImage);

			var marker = markers[i];

			markers.splice(i, 1);

			assignedClaimsMarkers.push(marker);

			break;
		}

	}

}

/**
 * Unassign claims
 * @param claimId
 */
function setTempClaimMarkerToUnAssignedState(claimId) {
	
	var criticState = 0;
	onEdition = 1;

	for(var i = 0; i <= markers.length; i++) {
		
		if(assignedClaimsMarkers[i].id == claimId){

			criticState = assignedClaimsMarkers[i].critical; 

			var newImage = new google.maps.MarkerImage("/modules/claims/css/img/state_"+criticState+".png");
			assignedClaimsMarkers[i].setIcon(newImage);
			
			var marker = assignedClaimsMarkers[i];
			
			assignedClaimsMarkers.splice(i, 1);
			
			markers.push(marker);

			break;
		}
		
	}

}

/**
 * Draw the optimized route for the given claims list
 */
function drawOptimizedRoute(){
	
	var company = new Object();
	company.id = companyMarkers[0].id; 
	company.pos = companyMarkers[0].position;
	if(company.pos.ob == undefined){
		company.pos.ob = company.pos.lat();
		company.pos.pb = company.pos.lng();
	}

	var claimsList = getCheckedClaims();

	var claimsListJson = JSON.stringify(claimsList);
	var companyJson = JSON.stringify(company);
	
	// Get claims coords
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getDistanceBetweenPoints',
		async: true,
		data: {
			claimsList: claimsListJson,
			company: companyJson
		},
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
			var code = eval(data[0]);
			var result = eval(data[1]);
			
			if(result.length > 0) {

				var isData = true;
				if(result.length == 1) {
					if(result[0].result == 'no_data_found') {
						isData = false;
					}
				}
				
				if(isData){
					//draw line path
					paintRoute(result[0].result);
					
				}
			}
		},
		error: function(){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});

}

/**
 * Draw the ordered by user route for the given claims list
 */
function drawRoute(){
	
	var result = new Array();
	
	var company = new Object();
	company.id = companyMarkers[0].id; 
	company.pos = companyMarkers[0].position;
	if(company.pos.ob == undefined){
		company.pos.ob = company.pos.lat();
		company.pos.pb = company.pos.lng();
	}

	result[0] = company;
	
	result = result.concat(getCheckedClaims());
	
	//draw line path
	paintRoute(result);
	
}

/**
 * Paint the route line
 * @param pointList
 */
var directionsRenderer = null;
function paintRoute(pointList){
	
	//clean map if exists a route
	cleanRoute();
	
	var directionsService = new google.maps.DirectionsService();

	var puntoOrigen = pointList[0];
	
	//setear punto origen a google
	var originLatLng = new google.maps.LatLng(puntoOrigen["pos"]["nb"], puntoOrigen["pos"]["ob"]);
	originPosition = new google.maps.Marker({
		position : originLatLng,
		icon : '/modules/adr/css/img/pixel.png',
		map : map
	});
		
	
	// set intermidiate points
	var wayPointArray = new Array();

	var cantPoints = pointList.length - 1;

	for(var i = 1; i < cantPoints; i++){

		var waitpointLatLng = new google.maps.LatLng(pointList[i]["pos"]["nb"], pointList[i]["pos"]["ob"]);
		var waypoint_i = new google.maps.Marker({
			position : waitpointLatLng,
			icon : '/modules/adr/css/img/pixel.png',
			map : map
		});

		wayPointArray.push({
			location : waypoint_i.position,
			stopover : true
		});
	}
	
	//set destination Point
	var targetLatLng = new google.maps.LatLng(pointList[cantPoints]["pos"]["nb"], pointList[cantPoints]["pos"]["ob"]);
	destinationPosition = new google.maps.Marker({
		position : targetLatLng,
		icon : '/modules/adr/css/img/pixel.png',
		map : map
	});
	
	
	//
	var request = {
			origin : originPosition.position,
			destination : destinationPosition.position,
			waypoints : wayPointArray,
			travelMode : google.maps.DirectionsTravelMode.DRIVING,
			unitSystem : google.maps.DirectionsUnitSystem.METRIC,
			optimizeWaypoints : false
		};
			
	// Get route from request	
	directionsService.route(request, function(response, status){

		if(status == google.maps.DirectionsStatus.OK){

			var lineSymbol = {
					path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
			};

			var polyOpts = {
					strokeOpacity : .5,
					strokeColor : '#0000FF',
					strokeWeight : 5,
					icons: [{
						icon: lineSymbol,
						offset: '100%',
						repeat: '100px'
					}],
			};

			var directionsDisplayOptions = {
					suppressMarkers : true,
					suppressInfoWindows : true,
					preserveViewport : false,
					polylineOptions : polyOpts,
					draggable: false
			};

			directionsRenderer = new google.maps.DirectionsRenderer(directionsDisplayOptions);
			directionsRenderer.setMap(map);
			directionsRenderer.setDirections(response);

		}
		else {
			console.info('could not get route');
			console.info(response);

		}
	});
		
}

/**
 * Clear route on map
 */
function cleanRoute(){
	
	//clean route
	if(typeof(directionsRenderer) != 'undefined' && directionsRenderer != null){
		directionsRenderer.setMap(null);
	}

}

/**
 * Get checked claims from the claims list
 * @returns array
 */
function getCheckedClaims(){

	var result = new Array();
	
	var l = 0;
	$('.claimAssignCheck').each(function(index){

		if ($(this).is(':checked')){

			for(var i = 0; i < assignedClaimsMarkers.length; i++){
				if(assignedClaimsMarkers[i].id == $(this).val()){

					var claim = new Object();
					claim.id = assignedClaimsMarkers[i].id;

					claim.pos = assignedClaimsMarkers[i].position;
					if(claim.pos.ob == undefined){
						claim.pos.ob = claim.pos.lat();
						claim.pos.pb = claim.pos.lng();
					}

					result[l] = claim;
					l = l + 1;
					break;
				}
			}
		}
	});

	return result;
}

