window.gMapsCallback = function() {
	$(window).trigger('gMapsLoaded');
};

var originPosition, destinationPosition, wayPointArray = [];

var company = new Object();
var user = new Object();
var claims = new Array();

var languageIsoUrl = '';
var closedState = null;
var cancelledState = null;
var substateYouCanCancel = null;
var substateYouCanClose = null;
var substateCameToThePlace = null;

var map;
google.maps.visualRefresh = true;

/**
 * Set the base map
 */
function initialize() {

	// map options
	var myOptions = {
		zoom : 16,
		//FIXME: se define arbitrariamente el punto central hasta acordar un centro.
		center : new google.maps.LatLng(-32.920412 , -68.84913),
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};

	document.getElementById('map_canvas').style.width = window.innerWidth
			+ "px";
	document.getElementById('map_canvas').style.height = window.innerHeight
			+ "px";

	// the map
	map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

}

/**
 * Get the map content
 */
function genMapContent() {

	if (originPosition) {
		originPosition.setMap(null);
	}

	if (arrayWaypoint != null && arrayWaypoint.length > 0) {
		for ( var j = 0; j < arrayWaypoint.length; j++) {
			arrayWaypoint[j].wp.setMap(null);
		}
		arrayWaypoint = [];
	}

	// Obtener los usuarios, empresas y reclamos
	getUserData();

	for(var i = 0; i < userData.length; i++){
		var user = userData[i];

		generateOriginPos(user);
		generateUserPos(user);
		generateWaitPointsPos(user);
		generateDestination(user);

		var request = {
				origin : originPosition.position,
				destination : destinationPosition.position,
				waypoints : wayPointArray,
				travelMode : google.maps.DirectionsTravelMode.DRIVING,
				unitSystem : google.maps.DirectionsUnitSystem.METRIC,
				optimizeWaypoints : false
		};
		
		directionsService = new google.maps.DirectionsService();

		generateRoute(request);

	}

}

/**
 * Get the path destination point
 * @param user
 */
function generateDestination(user) {

	if (arrayWaypoint != null && arrayWaypoint.length > 0){
		destinationPosition = arrayWaypoint[arrayWaypoint.length-1].wp;
	} else {

		var newLatLng = new google.maps.LatLng(user.company.lat, user.company.long);
		destinationPosition = new google.maps.Marker({
			position : newLatLng,
			map : map,
			icon : '/modules/adr/css/img/company.png',
			draggable : false
		});

		var infowindow = new google.maps.InfoWindow();
		google.maps.event.addListener(destinationPosition, 'click', function(event) {

			var infowindowContent = '';
			// Get company detail
			$.ajax({
				scriptCharset : "utf-8",
				contentType : "application/x-www-form-urlencoded; charset=UTF-8",
				cache : false,
				dataType : "json",
				type : "POST",
				url : window.location.pathname	+ '?action=getAdrPlanById',
				async : true,
				data : {
					planId : user.company[0].id
				},
				success : function(data) {
					var result = eval(data[1]);
					if (result.length > 0) {
						var isData = true;
						if (result.length == 1) {
							if (result[0].id == 'no_data_found') {
								isData = false;
							}
						}

						if (isData) {
							infowindowContent = '<div id="infow-container">'
								+ '	<div class="infow-head" style="float: left; width: 60%;">'
								+ s_message['adr_plan_name']
								+ ': <b>'
								+ result[0].name
								+ '</b></div>'
								+ '	<div class="infow-head" style="float: right; width: 40%;"></div>'
								+ '	<div class="infow-body">'
								+ '		<ul id="infow-body-detail">'
								+ '			<li></li>'
								+ '		</ul>'
								+ '	</div>'
								+ '</div>';
						}
					}

				},
				complete : function() {
					infowindow.setContent(infowindowContent);
					infowindow.setPosition(event.latLng);
					infowindow.open(map);
				},
				error : function() {
//					alert(s_message['error_retrieving_data']);
				}
			});

		});
	}

}

/**
 * Get the path waypoints
 * @param user
 */
var arrayWaypoint = new Array();
function generateWaitPointsPos(user) {

	/** *********Puntos Intermedios************* */
	var countPoint = user.claims.length;

	if (countPoint > 0) {

		wayPointArray = new Array();

		//if (countPoint > 8){
		//	countPoint = 8;
		//}
		
		for ( var i = 0; i < countPoint; i++) {
			var actionForm = '';
			if (user.claims[i].substate == substateYouCanClose) {
				actionForm = '<hr /> <form class="form-claim_closure" action="/'
						+ languageIsoUrl
						+ '/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'
						+ '<input type="hidden" value="'
						+ user.claims[i].id
						+ '" name="claim_id" id="claim_id">'
						+ '<input type="hidden" value="'
						+ closedState
						+ '" name="claim_action" id="claim_action">'
						+ '<input type="submit" value="Cerrar Reclamo"  class="form_bt">'
						+ '</form> <hr />';
			} else if (user.claims[i].substate == substateYouCanCancel) {
				actionForm = '<hr /> <form class="form-claim_closure" action="/'
						+ languageIsoUrl
						+ '/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'
						+ '<input type="hidden" value="'
						+ user.claims[i].id
						+ '" name="claim_id" id="claim_id">'
						+ '<input type="hidden" value="'
						+ cancelledState
						+ '" name="claim_action" id="claim_action">'
						+ '<input type="submit" value="Dar de BAJA Reclamo"  class="form_bt">'
						+ '</form> <hr />';
			};

			var infowindowIntermedioClaim = new google.maps.InfoWindow({
				content : '<div id="infowHead">' 
						+ '		<ul id="double">'
						+ '			<li>ID: '+ user.claims[i].code+'</li>'
						+ '			<li style="float: right; ">'+ s_message['entry_date']+ ': '+ user.claims[i].entryDate+'</li>'
						+ '		</ul>'
						+ '</div>'
						+ '<div>'
						+ '		<ul id="items">'
						+ '			<li>'+ s_message['subject_name']+ ': '+ user.claims[i].subject+'</li>'
						+ '			<li>'+ s_message['input_type_name']+ ': '+ user.claims[i].inputType+ '</li>'
						+ '			<li>'+ s_message['cause_name']+ ': '+ user.claims[i].cause+ '</li>'
						+ '			<li>'+ s_message['dependency']+ ': '+ user.claims[i].dependency+ '</li>'
						+ '			<li class="line"></li>'
						+ '			<li>'+ s_message['requester_name']+ ': '+ user.claims[i].requester+ '</li>'
						+ '			<li>'+ s_message['claim_address']+ ': '+ user.claims[i].claimAddress+ '</li>'
						+ '			<li>'+ s_message['requester_phone']+ ': '+ user.claims[i].requesterPhone+ '</li>'
						+ '			<li class="line"></li>'
						+ '		</ul>'
						+ '' + actionForm + '' + '</div>'
			});

			var claimState = '';
			if (user.claims[i].substate == null || user.claims[i].substate == 0
					|| user.claims[i].substate == substateCameToThePlace) {
				claimState = 'assigned';
			} else {
				claimState = user.claims[i].substate;
			}
			var waypointIcon = '/modules/claims/css/img/state_pending_' + claimState + '.png';

			var waypoint_claimId = new google.maps.Marker({
				id : i,
				position : new google.maps.LatLng(user.claims[i].latitude,
						user.claims[i].longitude),
				icon : waypointIcon,
				map : map,
				zIndex : google.maps.Marker.MAX_ZINDEX + 1
			});

			arrayWaypoint.push({
				wp : waypoint_claimId,
				inf : infowindowIntermedioClaim
			});

			wayPointArray.push({
				location : waypoint_claimId.position,
				stopover : true
			});

		};// FIN DEL FOREACH

		for ( var j = 0; j < arrayWaypoint.length; j++) {
			google.maps.event.addListener(arrayWaypoint[j].wp, 'click', function() {
				refresh = false;
				arrayWaypoint[this.id].inf.open(map, this);
			});
			google.maps.event.addListener(arrayWaypoint[j].inf, 'closeclick', function() {
				refresh = true;
			});
		};

		/** *********FIN Puntos Intermedios************* */
	};

}

/**
 * Get the path start point
 * @param user
 */
function generateOriginPos(user) {

	// Define our origin position, the start of our trip.
	var infowindowBO = new google.maps.InfoWindow({
		content : '<div id="content"> ' + user.name + '<br> ' + user.reporttime + ' </div>'
	});

	var lat, lon, icon;
	// If not user position, use the company position
	if (user.id != 'no_data_found') {
		lat = user.lat;
		lon = user.long;
		icon = '/modules/adr/css/img/user_1.png';
	} else {
		lat = user.company.lat;
		lon = user.company.long;
		icon = '/modules/adr/css/img/company.png';
	}

	originPosition = new google.maps.Marker({
		position : new google.maps.LatLng(lat, lon),
		icon : icon,
		map : map
	});

	google.maps.event.addListener(originPosition, 'click', function() {
		infowindowBO.open(map, originPosition);
		refresh = false;
	});
	google.maps.event.addListener(infowindowBO, 'closeclick', function() {
		refresh = true;
	});

}

/**
 * Get the user point
 * @param user
 */
function generateUserPos(user) {

	var infoWindowUserLastPosition = new google.maps.InfoWindow({
		content : '<div id="content"> Base de Operaciones </div>'
	});
	var positionUser = new google.maps.Marker({
		position : new google.maps.LatLng(user.company.lat, user.company.long),
		icon : '/modules/adr/css/img/company.png',
		map : map
	});
	google.maps.event.addListener(positionUser, 'click', function() {
		infoWindowUserLastPosition.open(map, positionUser);
		refresh = false;
	});
	google.maps.event.addListener(infoWindowUserLastPosition, 'closeclick',	function() {
		refresh = true;
	});

}

/**
 * Draw the routes
 * @param request
 */
var directionsRenderer;
function generateRoute(request) {

	//clean map if exists a route
	cleanRoute();
	cleanWaitPoints();
	
	directionsService.route(request, function(response, status) {

		if (status == google.maps.DirectionsStatus.OK) {

			var polyOpts = {
				strokeOpacity : 1.0,
				strokeColor : '#0000FF',
				strokeWeight : 2
			};

			var directionsDisplayOptions = {
				suppressMarkers : true,
				suppressInfoWindows : true,
				preserveViewport : true,
				polylineOptions : polyOpts
			};
			var zoom, center;
			if (typeof (directionsRenderer) != "undefined") {
				zoom = map.getZoom();
				center = map.getCenter();
			}

			directionsRenderer = new google.maps.DirectionsRenderer(
					directionsDisplayOptions);
			directionsRenderer.setMap(map);
			directionsRenderer.setDirections(response);

		} else {
			console.info('could not get route');
			console.info(response);
		}
		;
	});

}

/**
 * Get the user position, user's company and user's claims
 */
var userData;
function getUserData() {

	// Get adr user coords
	$.ajax({
		type : "POST",
		url : window.location.pathname + '?action=getADRMapData',
		dataType : "json",
		async : false,
		success : function(data) {
			if (data[0] == 1) {
				userData = $.parseJSON(data[1]);
			}
		},
		error : function() {
			// genericNoDataFound("User position: " +
			// s_message['error_retrieving_data']);
		}
	});

}

/**
 * Load google map api
 */
function loadGoogleMaps() {

	// Check if google maps were previously loaded
	if ($('#googleMapsScript').length <= 0) {
		var script_tag = document.createElement('script');
		script_tag.setAttribute("type", "text/javascript");
		script_tag
				.setAttribute(
						"src",
						"http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback&libraries=geometry");
		script_tag.setAttribute("id", "googleMapsScript");
		(document.getElementsByTagName("head")[0] || document.documentElement)
				.appendChild(script_tag);
	} else {
		$(window).trigger('gMapsLoaded');
	}

}

$(window).bind('gMapsLoaded', initialize);

/**
 * Turn on the refresh
 */
var refresh = true;
function getTimer() {

	var refreshInterval = window.setInterval(function() {
		if (refresh) {
			genMapContent();
		}
	}, $('#timer').val());

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
 * Clean waypints
 */
function cleanWaitPoints(){
	
	if(typeof(wayPointArray) !== 'undefined' && wayPointArray.length > 0){
		wayPointArray = [];
	}
	
}


