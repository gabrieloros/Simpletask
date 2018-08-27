/**
 * Auto complete adr users search
 */

    
/**
 * Apply filters on the map
 */
var applyBtn = false;
function sendPublicClaims(form) {

	//Clean before send
	cleanMarkersForClaim();
	cleanMarkersForCompany();
	cleanInfowindows();
	
     	var actionName = "getPublicClaim";
	var infomode = "mouseover";
	if($('#adr-claim-code').val() == 'undefined' || $('#adr-claim-code').val() == ''){
		$('#adr-claim-id').val('');
  		actionName = "getPublicClaimsCoords";
		infomode = "click";
	}
	
	var formdata = $('#frm_claims_track_filters').serialize();
	
	// Get claims coords
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=' + actionName,
		async: true,
		data: formdata,
		success: function(data){
			var result = eval(data[1]);
			if(result.length > 0) {
				var isData = true;
				if(result.length == 1) {
					if(result[0].code == 'no_data_found') {
						$('#notify').html(s_message['no_results_found']);
						isData = false;
					}
				}
				
				if(isData){
					for (var i = 0; i < result.length; i++) {  
						var stateId = result[i].state;
						urlIcon = "/modules/claims/css/img/markertype_"+stateId+".png";
						
						if(result.length == 1){
							var center = true;
						}
						addMarkersForPublicClaim(i, result[i].id, result[i].code, result[i].lat, result[i].long, urlIcon, center, infomode);
					}
					if(applyBtn){
						$('#notify').html(i+' '+s_message['results_found']);
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
 * Draw claim markers on map
 */
var markers = [];
function addMarkersForPublicClaim(index, claimId, claimCode, latitude, longitude, stateUrlIcon, center, infomode) {

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
			animation: google.maps.Animation.DROP,
			draggable: false,
			zIndex: google.maps.Marker.MAX_ZINDEX + 1
	});
	
	var infowindow = new google.maps.InfoWindow();
	google.maps.event.addListener(marker, infomode, function(event) {

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
					 	claim['closedDate'] = result[0].closedate;	
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

/**
 * Clean the filters fields and all map markers
 */
var defaultLeftDate;
var defaultRightDate;
var defaultDateFormat;
function cleanClaimsTrackFilters() {
	
	$('#adr-claim-code').val('');
	$('#adr-claim-id').val('');
	//FIXME: incompatibilidad con las version 1.4.4 de jquery
	$('#notify').html('');
	
	cleanMarkersForClaim();
	cleanMarkersForCompany();
	cleanInfowindows();
}
// url del móo setting
var baseUrl = window.location.protocol+'//'+window.location.host;
var urlCenter = baseUrl+"/es/settings?action=getLatLongCenter";
var centerParameter = null;
var centerLatitude = null;
var centerLongitude = null;

function getPositionCenter(){
	
	if(map != undefined){	
	
	
	$.get(urlCenter,function(data){		
		
		result = eval('('+data[1]+')');		
						
	}, 'json').done(function(){
		if(map != undefined || map!= null){
			centerParameter = new google.maps.LatLng(result.latitude, result.longitude);
			map.setCenter(centerParameter);			
		}
		centerLatitude = result.latitude;
		centerLongitude = result.longitude;	
	
	});	
	} 
}

