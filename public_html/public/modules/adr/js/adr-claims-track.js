/**
 * Auto complete adr users search
 */
$(function() {
    
	$('.autocomplete-control').each(function(){
		
		var autoCompleteObject = $(this);
		var action = autoCompleteObject.attr('loadaction');
		var minChars = autoCompleteObject.attr('minChars');
		
		autoCompleteObject.autocomplete({

			source: function( request, response ) {

				$.ajax({
					type: "POST",
					url: window.location.pathname + '?action=' + action,
					dataType: "json",
					data: {
						fieldValue: request.term
					},
					success: function( data ) {

						result = eval(data[1]);

						if(result.length > 0) {
							
							response( $.map( result, function( item ) {
								return {
									id: item.id,
									value: item.value
								};
							}));
						}
						//Empty results
						else{
						
							var fakeArray = {"value": s_message["no_results_found"], "id": ""};
							
							var arr = $.makeArray( fakeArray );
							
							response( $.map( arr, function( item ) {
								return {
									id: item.id,
									value: item.value
								};
							}));
							
						}
					},
					error: function (){
						autoCompleteObject.removeClass('ui-autocomplete-loading');
					}
				});
			},
			minLength: minChars,
			delay: 700,
			select: function( event, ui ) {
				
				var currentId = $(this).attr('id');
				if(ui.item.id != ""){
					if(currentId == 'adr-user-fullname') {
						$('#adr-user-id').val(ui.item.id);
					}
					if(currentId == 'adr-claim-code') {
						$('#adr-claim-id').val(ui.item.id);
					}
				}
			}
			
		});
	});
});

$( ".autocomplete-control" ).keyup(function(){
	if($(this).val().length == 0){
		$(this).parent().siblings('td').find('select').html('');
	}
});


/**
 * Apply filters on map for a time interval 
 */
function myTimer(){
	sendClaimsTrackFilters('frm_claims_track_filters');
}

/**
 * Apply filters on the map
 */
var applyBtn = false;
function sendClaimsTrackFilters(form) {

	//Clean before send
	cleanMarkersForClaim();
	cleanMarkersForUser();
	cleanMarkersForCompany();
	cleanInfowindows();
	
	var adrUserIdSelected = '';
	if($('#adr-user-fullname').val() != 'undefined' && $('#adr-user-fullname').val() != '') {
		adrUserIdSelected = $('#adr-user-id').val();
	}
	else{
		$('#adr-user-fullname').val('');
		$('#adr-user-id').val('');
	}
	
	if($('#adr-claim-code').val() == 'undefined' || $('#adr-claim-code').val() == ''){
		$('#adr-claim-id').val('');
	}
	
	// Get adr user coords
	$.ajax({
		type: "POST",
		url: window.location.pathname + '?action=getAdrUserCoords',
		dataType: "json",
		data: {
			userId: adrUserIdSelected
		},
		success: function(data) {
			var result = eval(data[1]);
			if(result.length > 0) {
				
				var isData = true;
				if(result.length == 1) {
					if(result[0].code == 'no_data_found') {
						isData = false;
					}
				}
				
				if(isData){
					for (var i = 0; i < result.length; i++) {
						var userStateId = result[i].state;
						stateUrlIcon = "/modules/adr/css/img/user_"+userStateId+".png"; 

						if(result.length == 1){
							var center = true;
						}
						updateMapForUser(i, result[i].id, result[i].lat, result[i].long, stateUrlIcon, center);
					}
				}
			}
		},
		error: function (){
			alert(s_message['error_retrieving_data']);
		}
	});

	// Get user company coords
	$.ajax({
		type: "POST",
		url: window.location.pathname + '?action=getAdrUserCompanyCoords',
		dataType: "json",
		data: {
			userId: adrUserIdSelected
		},
		success: function( data ) {
			var result = eval(data[1]);
			if(result.length > 0) {
				var isData = true;
				if(result.length == 1) {
					if(result[0].id == 'no_data_found') {
						isData = false;
					}
				}
				
				if(isData){
					for (var i = 0; i < result.length; i++) {
 
						var urlIcon = "/modules/adr/css/img/company.png"; 

						updateMapForCompany(i, result[i].id, result[i].lat, result[i].long, urlIcon);
					}
				}
			}
		},
		error: function (){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});
	
	var formdata = $('#frm_claims_track_filters').serialize();
	
	// Get claims coords
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getClaimsTrackFilterData',
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
						var stateId = result[i].stateId;
						urlIcon = "/modules/claims/css/img/state_"+result[i].isCritical+".png";
						
						if(result.length == 1){
							var center = true;
						}
						addMarkersForClaim(i, result[i].id, result[i].code, result[i].lat, result[i].long, urlIcon, center);
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
 * Turn on/off the continuous tracking timer
 */
var continousTracking = null;
function continousTrackingManager(intervalTime) {
	
	if($("#continousTracking").is(':checked')) {
		continousTracking = window.setInterval(function(){myTimer();},intervalTime);
	}
	else {
		if(continousTracking){
			window.clearInterval(continousTracking);
			continousTracking = null;
		}
	}

} 

/**
 * Clean the filters fields and all map markers
 */
var defaultLeftDate;
var defaultRightDate;
var defaultDateFormat;
function cleanClaimsTrackFilters() {
	
	$('#adr-user-fullname').val('');
	$('#adr-user-id').val('');
	$('#adr-claim-code').val('');
	$('#adr-claim-id').val('');
	//FIXME: incompatibilidad con las version 1.4.4 de jquery
	$('#adr-claim-state option[value="1"]').attr("selected",true);
	$('#adr-hour-left').val('');
	$('#adr-hour-right').val('');
	$('#notify').html('');
	
	resetDateFields();
	cleanMarkersForClaim();
	cleanMarkersForUser();
	cleanMarkersForCompany();
	cleanInfowindows();

}

/**
 * Show unassigned claims points on map
 */
var points = [];
var claims = [];
var claim = new Object();
claim.id;
claim.code;
claim.lat;
claim.long;

function showUnassignedClaims() {

	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getUnassignedClaimsCoords',
		async: true,
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
	
			result = eval(data[1]);
	
			if(result.length > 0) {
				
				var isData = true;
				if(result.length == 1) {
					if(result[0].code == 'no_data_found') {
						genericNoDataFound(s_message['no_results_found']);
						isData = false;
					}
				}
				
				if(isData){
					
					for (var i = 0; i < result.length; i++) {  

						addMarkersForClaim(i,result[i].id, result[i].code, result[i].lat, result[i].long, result[i].isCritical);

						claims[i] = [
						             claim.id = result[i].id,
						             claim.code = result[i].code,
						             claim.lat = result[i].lat,
						             claim.long = result[i].long
						            ];
					}
				}
			}
	
		},
		error: function(){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});
}


/**
 * Get all user's claims and user's company
 */
var filas = 0;
function getClaimsForUser() {

	//Clear list
	if(filas >= 0) {
		for(var i = 0; i <= filas; i++) {
			cleanDynamicClaimsList($('.column-contenidos'));
		}
	}

	if(onEdition == 1){
		var keyPressed = confirm("La asignación de reclamos no ha sido guardada, desea continuar?");
		if (keyPressed == false) {
			return;
		}
	}
	
	if($('#adr-user-fullname').val() != 'undefined' && $('#adr-user-fullname').val() != '') {
		var adrUserIdSelected = $('#adr-user-id').val();

		//Enable draw map
		draw = true;
		loadGoogleMaps(draw);
		
		cleanMarkersForUser();
		cleanMarkersForCompany();
		cleanAssignedClaimsMarkers();
		cleanInfowindows();
		
		showUnassignedClaims();

		// Get adr user coords
		$.ajax({
			type: "POST",
			url: window.location.pathname + '?action=getAdrUserCoords',
			dataType: "json",
			data: {
				userId: adrUserIdSelected
			},
			complete: function(){
				$('#buttons').show();
			},
			success: function( data ) {
				if(data[0] == 1){
					var parsedData = $.parseJSON(data[1]);
					var userStateId = parsedData[0].state;
					var stateUrlIcon = "/modules/adr/css/img/user_"+userStateId+".png"; 

					updateMapForUser(0, parsedData[0].id, parsedData[0].lat, parsedData[0].long, stateUrlIcon);
				}
			},
			error: function (){
				genericNoDataFound(s_message['error_retrieving_data']);
			}
		});

		// Get user company coords
		$.ajax({
			type: "POST",
			url: window.location.pathname + '?action=getAdrUserCompanyCoords',
			dataType: "json",
			data: {
				userId: adrUserIdSelected
			},
			success: function( data ) {
				if(data[0] == 1){
					var parsedData = $.parseJSON(data[1]);
					var urlIcon = "/modules/adr/css/img/company.png"; 

					updateMapForCompany(0, parsedData[0].id, parsedData[0].lat, parsedData[0].long, urlIcon);
				}
			},
			error: function (){
				genericNoDataFound(s_message['error_retrieving_data']);
			}
		});

	}
	else{
		genericNoDataFound(s_message['error_select_systemuser']);
	}
	
	// Get claims
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getAssignedClaimsForUser',
		async: true,
		data: {
			userId: adrUserIdSelected
		},
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){

			result = eval(data[1]);

			if(result.length > 0) {
				
				var isData = true;
				if(result.length == 1) {
					if(result[0].code == 'no_data_found') {
						
						//Append no data found to list
						var claim = ''; 
						dynamicClaimsList(claim);
						
						isData = false;
					}
				}
				
				if(isData){
					for (var i = 0; i < result.length; i++) {  
						
						var claim = result[i];
						claim['index'] = i;

						assignedClaimUrlIcon = "/modules/claims/css/img/state_pending_assigned.png";
						claim['icon'] = assignedClaimUrlIcon;

						//Append claim to list
						dynamicClaimsList(claim);

						filas = i;
						
						addMarkersForAssignedClaim(claim);
					}
					$('#assignAllCheck').attr('checked', true);
				
				}
			}

		},
		error: function(){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});

}