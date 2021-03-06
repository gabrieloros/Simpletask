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

function initialize() {

	// map options
	var myOptions = {
		zoom : 16,
		center : new google.maps.LatLng(user[0].lat, user[0].long),
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};

	document.getElementById('map_canvas').style.width = window.innerWidth
			+ "px";
	document.getElementById('map_canvas').style.height = window.innerHeight
			+ "px";

	// the map
	map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

}

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

	// get user data
	getUserPosition();

	// get claims data
	getAssignedClaimsPositions();

	generateOriginPos();
	generateUserPos();
	generateWaitPointsPos();
	generateDestination();

	var request = {
		origin : originPosition.position,
		destination : destinationPosition.position,
		waypoints : wayPointArray,
		travelMode : google.maps.DirectionsTravelMode.DRIVING,
		unitSystem : google.maps.DirectionsUnitSystem.METRIC,
		optimizeWaypoints : false
	};
	if (firstExecution){
	   generateRoute(request);
           console.info('genera ruta') 
          firstExecution = false;
        }

}
var firstExecution = true;
function generateDestination() {

	if (arrayWaypoint != null && arrayWaypoint.length > 0){
		destinationPosition = arrayWaypoint[arrayWaypoint.length-1].wp;
	} else {

		var newLatLng = new google.maps.LatLng(company[0].lat, company[0].long);
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
					planId : company[0].id
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

var arrayWaypoint = new Array();
function generateWaitPointsPos() {

	/** *********Puntos Intermedios************* */
	var countPoint = claims.length;
	directionsService = new google.maps.DirectionsService();

	if (countPoint > 0) {

		wayPointArray = new Array();

		//if (countPoint > 8){
		//	countPoint = 8;
		//}
		
		for ( var i = 0; i < countPoint; i++) {
			var actionForm = '';
			if (claims[i].substate == substateYouCanClose) {
				actionForm = '<hr /> <form class="form-claim_closure" action="/'
						+ languageIsoUrl
						+ '/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'
						+ '<input type="hidden" value="'
						+ claims[i].id
						+ '" name="claim_id" id="claim_id">'
						+ '<input type="hidden" value="'
						+ closedState
						+ '" name="claim_action" id="claim_action">'
						+ '<input type="submit" value="Cerrar Reclamo"  class="form_bt">'
						+ '</form> <hr />';
			} else if (claims[i].substate == substateYouCanCancel) {
				actionForm = '<hr /> <form class="form-claim_closure" action="/'
						+ languageIsoUrl
						+ '/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'
						+ '<input type="hidden" value="'
						+ claims[i].id
						+ '" name="claim_id" id="claim_id">'
						+ '<input type="hidden" value="'
						+ cancelledState
						+ '" name="claim_action" id="claim_action">'
						+ '<input type="submit" value="Dar de BAJA Reclamo"  class="form_bt">'
						+ '</form> <hr />';
			};

			var infowindowIntermedioClaim = new google.maps.InfoWindow({
				content : '<div id="infowHead">' + '	<ul id="double">'
						+ '		<li>ID: '
						+ claims[i].code
						+ '</li>'
						+ '		<li style="float: right; ">'
						+ s_message['entry_date']
						+ ': '
						+ claims[i].entryDate
						+ '</li>'
						+ '	</ul>'
						+ '</div>'
						+ '<div>'
						+ '	<ul id="items">'
						+ '		<li>'
						+ s_message['subject_name']
						+ ': '
						+ claims[i].subject
						+ '</li>'
						+ '		<li>'
						+ s_message['input_type_name']
						+ ': '
						+ claims[i].inputType
						+ '</li>'
						+ '		<li>'
						+ s_message['cause_name']
						+ ': '
						+ claims[i].cause
						+ '</li>'
						+ '		<li>'
						+ s_message['dependency']
						+ ': '
						+ claims[i].dependency
						+ '</li>'
						+ '		<li class="line"></li>'
						+ '		<li>'
						+ s_message['requester_name']
						+ ': '
						+ claims[i].requester
						+ '</li>'
						+ '		<li>'
						+ s_message['claim_address']
						+ ': '
						+ claims[i].claimAddress
						+ '</li>'
						+ '		<li>'
						+ s_message['requester_phone']
						+ ': '
						+ claims[i].requesterPhone
						+ '</li>'
						+ '		<li class="line"></li>'
						+ '	</ul>'
						+ ''
						+ actionForm + '' + '</div>'
			});

			var claimState = '';
			if (claims[i].substate == null || claims[i].substate == 0
					|| claims[i].substate == substateCameToThePlace) {
				claimState = 'assigned';
			} else {
				claimState = claims[i].substate;
			}
			var waypointIcon = '/modules/claims/css/img/state_pending_'
					+ claimState + '.png';

			var waypoint_claimId = new google.maps.Marker({
				id : i,
				position : new google.maps.LatLng(claims[i].latitude,
						claims[i].longitude),
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

		};// FIN DEL FOREACH?>

		for ( var j = 0; j < arrayWaypoint.length; j++) {
			google.maps.event.addListener(arrayWaypoint[j].wp, 'click',
					function() {
						refresh = false;
						arrayWaypoint[this.id].inf.open(map, this);
					});
			google.maps.event.addListener(arrayWaypoint[j].inf, 'closeclick',
					function() {
						refresh = true;
					});
		}

		/** *********FIN Puntos Intermedios************* */
	}
	;

}

function generateOriginPos() {

	// Define our origin position, the start of our trip.
	var infowindowBO = new google.maps.InfoWindow({
		content : '<div id="content"> ' + user[0].name + '<br> ' + user[0].reporttime + ' </div>'
	});

	// Si no hay posicion de user, usar la company
	var lat, lon, icon;

	if (user[0].id != 'no_data_found') {
		lat = user[0].lat;
		lon = user[0].long;
		icon = '/modules/adr/css/img/user_1.png';
	} else {
		lat = company[0].lat;
		lon = company[0].long;
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

function generateUserPos() {

	var infoWindowUserLastPosition = new google.maps.InfoWindow({
		content : '<div id="content"> Base de Operaciones </div>'
	});
	positionUser = new google.maps.Marker({
		position : new google.maps.LatLng(company.latitude, company.longitude),
		icon : '/modules/adr/css/img/company.png',
		map : map
	});
	google.maps.event.addListener(positionUser, 'click', function() {
		infoWindowUserLastPosition.open(map, positionUser);
		refresh = false;
	});

	google.maps.event.addListener(infoWindowUserLastPosition, 'closeclick',
			function() {
				refresh = true;
			});

}

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
				directionsRenderer.setMap(null);
				directionsRenderer = null;
			}

			directionsRenderer = new google.maps.DirectionsRenderer(
					directionsDisplayOptions);
			// map.setZoom(zoom);
			// map.setCenter(center);
			directionsRenderer.setMap(map);
			directionsRenderer.setDirections(response);

		} else {
			console.info('could not get route');
			console.info(response);
		}
		;
	});

}

function getCompanyPosition() {

	// Get user company coords
	$
			.ajax({
				type : "POST",
				url : window.location.pathname + '?action=getCompanyPosition',
				dataType : "json",
				async : false,
				success : function(data) {
					if (data[0] == 1) {
						company = $.parseJSON(data[1]);
					}
				},
				error : function() {
					genericNoDataFound("Company: "
							+ s_message['error_retrieving_data']);
				}
			});

}

function getUserPosition() {

	// Get adr user coords
	$.ajax({
		type : "POST",
		url : window.location.pathname + '?action=getUserLastPosition',
		dataType : "json",
		async : false,
		success : function(data) {
			if (data[0] == 1) {
				user = $.parseJSON(data[1]);
			}
		},
		error : function() {
			// genericNoDataFound("User position: " +
			// s_message['error_retrieving_data']);
		}
	});

}

function getAssignedClaimsPositions() {

	if (claims.length = !0) {
		claims = [];
	}

	// Get claims
	$.ajax({
		scriptCharset : "utf-8",
		contentType : "application/x-www-form-urlencoded; charset=UTF-8",
		cache : false,
		dataType : "json",
		type : "POST",
		url : window.location.pathname + '?action=getAssignedClaimsPositions',
		async : false,
		beforeSend : function() {
			showLoadingWheel();
		},
		complete : function(data) {
			showLoadingWheel();
		},
		success : function(data) {

			result = eval(data[1]);

			if (result.length > 0) {

				var isData = true;
				if (result.length == 1) {
					if (result[0].code == 'no_data_found') {
						isData = false;
					}
				}

				if (isData) {
					for ( var i = 0; i < result.length; i++) {

						var claim = new Object();
						claim = result[i];

						claims.push(claim);
					}
				}
			}

		},
		error : function() {
			// genericNoDataFound("Claims position: " +
			// s_message['error_retrieving_data']);
		}
	});

}

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

function cleanWaitPoints(){
	
	if(typeof(wayPointArray) !== 'undefined' && wayPointArray.length > 0){
		wayPointArray = [];
	}
	
}
