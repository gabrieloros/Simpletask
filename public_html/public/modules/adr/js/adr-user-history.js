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
					if(currentId == 'adr-history-user-fullname') {
						$('#adr-user-id').val(ui.item.id);
						$('#adr-date-left').attr('disabled', false);
						$('#adr-date-right').attr('disabled', false);
						$('#adr-claim-code').attr('disabled', false);
						$('#adr-claim-id').val();
						$('#adr-claim-state').attr('disabled', false);

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
 * Draw the historical path for an user
 */
function getHistoricalRoute(){

	cleanPathMarkers();
	cleanMarkersForClaim();
	
	if($('#adr-history-user-fullname').val() != 'undefined' && $('#adr-history-user-fullname').val() != '') {

		if (validateForm('frm_historical_filters')) {
	
			var isData = true;
			var formData = $('#frm_historical_filters').serialize();
		
			// Get user history coords
			$.ajax({
				scriptCharset: "utf-8" ,
				contentType: "application/x-www-form-urlencoded; charset=UTF-8",
				cache:false,
				dataType: "json",
				type: "POST",
				url: window.location.pathname + '?action=getHistoricalForUser',
				async: true,
				data: formData, 
				beforeSend: function(){
					showLoadingWheel();
				},
				complete: function(data){
					showLoadingWheel();
				},
				success: function(data){
					result = eval(data[1]);
					if(result.length > 0) {
						
						if(result.length == 1) {
							if(result[0].userid == 'no_data_found') {
								//Append no result to notify area
								isData = false;
							}
						}
						
						if(isData){
							var pathIcon = "/modules/adr/css/img/arrow_stop.png";
							var lastIcon = "/modules/adr/css/img/user_1.png";
							var cant = result.length; 
							
							for (var i = 0; i < cant; i++) {
								if(i != cant - 1){
									drawPathForUser(i, result[i].userid, result[i].latitude, result[i].longitude, pathIcon);
								}
								else{
									drawPathForUser(i, result[i].userid, result[i].latitude, result[i].longitude, lastIcon);
								}
							}
						}
	
					}
				},
				error: function(){
					genericNoDataFound(s_message['error_retrieving_data']);
				}
			});
			
			// Get claims coords
			$.ajax({
				scriptCharset: "utf-8" ,
				contentType: "application/x-www-form-urlencoded; charset=UTF-8",
				cache:false,
				dataType: "json",
				type: "POST",
				url: window.location.pathname + '?action=getClaimsTrackFilterData',
				async: true,
				data: formData,
				success: function(data){
					var result = eval(data[1]);
					var isClaimData = true;
					if(result.length > 0) {
						if(result.length == 1) {
							if(result[0].code == 'no_data_found') {
								isClaimData = false;
							}
						}
						
						if(isClaimData){
							for (var i = 0; i < result.length; i++) {  
								addMarkersForClaim(i, result[i].id, result[i].code, result[i].lat, result[i].long, result[i].isCritical);
							}
						}
					}
					
				},
				error: function(){
					genericNoDataFound(s_message['error_retrieving_data']);
				}
			});
			
			// Get user company coords
			var adrUserIdSelected = $('#adr-user-id').val();
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
			
			//Ger report
			getHistoryReport(adrUserIdSelected);

		}

	}
	else{
		genericNoDataFound(s_message['error_select_systemuser']);
	}
	
	if(isData == false){
		$('#notify').html(s_message['no_results_found']);
	}

}

/**
 * Clean the map and form fields
 */
function cleanFormFields(){
	
	$('#adr-history-user-fullname').val('');
	
	resetDateFields();
	resetFormFields();
	cleanPathMarkers();
	cleanMarkersForClaim();
	cleanMarkersForCompany();
	cleanInfowindows();

	cleanReportList();
}

/**
 * Clear form
 */
function resetFormFields(){
	
	$('#adr-user-id').val('');
	$('#adr-claim-code').val('');
	$('#adr-claim-id').val('');
	//FIXME: incompatibilidad con las version 1.4.4 de jquery
	$('#adr-claim-state option[value=""]').attr("selected",true);
	
	$('#adr-date-left').attr('disabled', true);
	$('#adr-date-right').attr('disabled', true);
	$('#adr-claim-code').attr('disabled', true);
	$('#adr-claim-state').attr('disabled', true);

}

/**
 * Get report data and fill the list
 */
var rows = new Array();
function getHistoryReport(userId){
	
	cleanReportList();
	
	var dateFrom = $('#adr-date-left').val();
	var dateTo = $('#adr-date-right').val();
	
	//Get report data
	$.ajax({
		type: "POST",
		url: window.location.pathname + '?action=getUserHistoryReportByUser',
		dataType: "json",
		data: {
			userId: userId,
			dateFrom: dateFrom,
			dateTo: dateTo			
		},
		success: function( data ) {
			
			result = eval(data[1]);

			if(result.length > 0) {
				
				var isData = true;
				if(result.length == 1) {
					if(result[0].id == 'no_data_found') {
						
						//Append no data found to list
						var data = ''; 
						populateReportList(data);
						
						isData = false;
					}
				}
				
				if(isData){
					
					for (var i = 0; i < result.length; i++) {  
						//Append data to list
						populateReportList(result[i], i);
					}
				}
			}
		},
		error: function (){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});
	
}

/**
 * Draw and populate the report list
 * @param data
 */
function populateReportList(data, index){
	
	var row = null; 

	if (data != '' && data.zone != 'no_data_found') {
		
		row =  
			'<div class="report-content-row" id="column-content_'+index+'">'+
		    '	<div class="fila_1">'+data.zone+'</div>'+
		    '	<div class="fila_1">'+data.timeIn+'</div>'+
		    '	<div class="fila_1">'+data.timeOut+'</div>'+
		    '	<div class="fila_1">'+data.timeInZone+'</div>'+
		    '</div>';
		
	} else{
		row = 
			'<div class="report-content-row" id="column-content_0">'+
		    '	<div id="report-content-row" class="no-results-found_1">'+s_message['no_results_found']+'</div>'+
		    '</div>';

	}

	if (row != null){
		$('#report-container-table').append(row);
		rows.push('.column-content');
	}
	
}

/**
 * Reset a list element
 * @param row
 */
function cleanReportList() {
	for(var i = 0; i < rows.length; i++){
		$('#column-content_'+i).remove();
	}
}