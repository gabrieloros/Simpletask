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
 * Show unassigned claims points on map
 */
var points = [];
var claims = [];
var claim = new Object();
claim.id;
claim.code;
claim.lat;
claim.long;

function showUnassignedClaims(adrGroupIdSelected) {

	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		data: {
			groupId: adrGroupIdSelected
		},
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
						isData = false;
					}
				}
				
				if(isData){
					
					for (var i = 0; i < result.length; i++) {  

						addMarkersForClaim(i,result[i].id,result[i].priority,result[i].causeId, result[i].code, result[i].lat, result[i].long, result[i].isCritical);

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
 * Show unassigned claims points on map
 */
var points = [];
var claims = [];
var claim = new Object();
claim.id;
claim.code;
claim.lat;
claim.long;

function ShowUnassignedClaimsByGroups() {
	cleanAssignedClaimsMarkers();
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getShowUnassignedClaimsByGroups',
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
						isData = false;
					}
				}
				
				if(isData){
					
					for (var i = 0; i < result.length; i++) {  

						addMarkersForClaim(i,result[i].id,result[i].priority,result[i].causeId, result[i].code, result[i].lat, result[i].long, result[i].isCritical, result[i].groupid, result[i].icon,result[i].namegroup);

						claims[i] = [
									
						             claim.id = result[i].id,
						             claim.code = result[i].code,
									
						             claim.lat = result[i].lat,
									 claim.long = result[i].long,
									 claim.groupid = result[i].groupid,
									 claim.icon = result[i].icon,
									 claim.namegroup = result[i].namegroup
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
var filas = 0;
var selectedGroupOld;
var selectedGroupIdOld;
function ShowClaimsByGroup() {
	var cleanList = false;
	if(onEdition == 1){
		var keyPressed = confirm("La asignación de reclamos no ha sido guardada, desea continuar?");
		if (keyPressed == false) {
			$('#adr-group-fullname').val(selectedGroupOld);
			$('#adr-group-id').val(selectedGroupIdOld);
			return;
		}
		else{
			//Clear list
			cleanList = true;
		}
	}
	else{
		//Clear list
		cleanList = true;
	}

	if(cleanList){
		if(filas >= 0) {
			for(var i = 0; i <= filas; i++) {
				cleanDynamicClaimsList($('.column-contenidos'));
			}
		}
	}

	if($('#adr-group-fullname').val() != 'undefined' && $('#adr-group-fullname').val() != '') {
		var adrGroupIdSelected = $('#adr-group-id').val();
		selectedGroupOld = $('#adr-group-fullname').val();
		selectedGroupIdOld = $('#adr-group-id').val();
		
		// Get adr user coords
		$.ajax({
			type: "POST",
			url: window.location.pathname + '?action=getDataGroup',
			dataType: "json",
			data: {
				groupId: adrGroupIdSelected
			},
			complete: function(){
				$('#buttons').show();
			},
			success: function( data ) {
				if(data[0] == 1){
					var parsedData = $.parseJSON(data[1]);
					var icon = parsedData[0].icon;
					var groupId = parsedData[0].id;
					
					coloursClaimsbyGroup(groupId,icon);	
				}
			},
			error: function (){
				genericNoDataFound(s_message['error_retrieving_data']);
			}
		});

	}
}

/**
 * Get all user's claims and user's company
 */
var filas = 0;
var selectedUserOld;
var selectedUserIdOld;
var selectedGroupOld;
var selectedGroupIdOld;
function getClaimsForUser() {

	var cleanList = false;
	if(onEdition == 1){
		var keyPressed = confirm("La asignación de reclamos no ha sido guardada, desea continuar?");
		if (keyPressed == false) {
			$('#adr-user-fullname').val(selectedUserOld);
			$('#adr-user-id').val(selectedUserIdOld);
			$('#adr-group-fullname').val(selectedGroupOld);
			$('#adr-group-id').val(selectedGroupIdOld);
			return;
		}
		else{
			//Clear list
			cleanList = true;
		}
	}
	else{
		//Clear list
		cleanList = true;
	}

	if(cleanList){
		if(filas >= 0) {
			for(var i = 0; i <= filas; i++) {
				cleanDynamicClaimsList($('.column-contenidos'));
			}
		}
	}

	if($('#adr-user-fullname').val() != 'undefined' && $('#adr-user-fullname').val() != '') {
		var adrUserIdSelected = $('#adr-user-id').val();
		selectedUserOld = $('#adr-user-fullname').val();
		selectedUserIdOld = $('#adr-user-id').val();
		var adrGroupIdSelected = $('#adr-group-id').val();
		selectedGroupOld = $('#adr-group-fullname').val();
		selectedGroupIdOld = $('#adr-group-id').val();

		//Enable draw map
		draw = true;
		loadGoogleMaps();
		
		cleanMarkersForUser();
		cleanMarkersForCompany();
		cleanAssignedClaimsMarkers();
		cleanInfowindows();
		showUnassignedClaims(adrGroupIdSelected);

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
			userId: adrUserIdSelected,
			groupId: adrGroupIdSelected
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

/**
 * Append claims on the assigned claims list
 * @param claim
 */
function dynamicClaimsList(claim) {
	
	var row = null; 

	if (claim != '') {
		if($('.no-results-found')){
			cleanDynamicClaimsList($('.fila_0'));
		}
		
		if($('#chk-'+claim.id).val() != claim.id) {
		
			row =  
				'<div id="contenidos" class="column-contenidos fila_'+claim.id+' fila_'+claim.id+'">'+
			    '	<div id="column1">'+claim.code+'</div>'+
			    '	<div id="column2" class="column-contenidos">'+
			    '		<input type="checkbox" name="claimIds[]" value="'+claim.id+'" class="claimAssignCheck" id="chk-'+claim.id+'" checked onclick="selectClaim('+claim.id+');"/>'+
			    '	</div>'+
			    '</div>';
		}

	} else{
		row = 
			'<div id="contenidos" class="column-contenidos fila_0">'+
		    '	<div id="column1" class="no-results-found">'+s_message['no_results_found']+'</div>'+
		    '</div>';

	}

	if (row != null){
		$('#sortable').append(row);
	}
	
}

/**
 * Check an uncheck all claims
 */
function checkAllClaims() {
	
	var marcar = $('#assignAllCheck').is(':checked');
		
	$('.claimAssignCheck').each(function(index){
		if ($(this).is(':checked') != marcar){
			$(this).attr('checked', marcar);
			selectClaim($(this).val());
		}
	});

}

/**
 * Reset a list element
 * @param row
 */
function cleanDynamicClaimsList(row) {
	row.remove();
}

/**
 * Update the claim marker on map
 * @param claimId
 */
function selectClaim(claimId) {
	
	if($('#chk-'+claimId).is(':checked')){
		setClaimMarkerToAssignedState(claimId);
	}
	else{
		setTempClaimMarkerToUnAssignedState(claimId);
		$('#assignAllCheck').attr('checked', false);
	}

}

/**
 * Persist the claims assignment
 * @param form
 */
function saveAssignedClaims(){
	
	var formData = $('#frm_assigned_claims').serialize();
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=assignClaims',
		async: true,
		data: formData, 
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
			
			$('body').append(data[1]);
			
			var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
			var message = trimString($('#basicAjaxResultContainer #ajaxMessageResponse').html());

			if(result == 1){
				onEdition = 0;
			}

			$('#basicAjaxResultContainer').remove();
			
		},
		error: function(){
			genericNoDataFound(s_message['assign_claims_error']);
		}
	});

}

/**
 * Persist the claims by group assignment
 * @param form
 */
function saveAssignedClaimsbyGroup(){
	
	var formData = $('#frm_assigned_claimsbygroup').serialize();
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=assignClaimsGroup',
		async: true,
		data: formData, 
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
			
			$('body').append(data[1]);
			
			var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
			var message = trimString($('#basicAjaxResultContainer #ajaxMessageResponse').html());

			if(result == 1){
				onEdition = 0;
			}

			$('#basicAjaxResultContainer').remove();
			
		},
		error: function(){
			genericNoDataFound(s_message['assign_claims_error']);
		}
	});

}