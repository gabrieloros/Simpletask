var map;
var latitude;
var longitude;

$(document).ready(function(){
	
	$( "#claim-address" ).keypress(function() {
		$('#latitude').val('');
		$('#longitude').val('');
		});	

		getPositionCenter();
});

function sendUploadForm(formId) {

	if (validateForm(formId)) {

		showLoadingWheel();
		ajaxFileUpload();

	} else {
		return;
	}

}

function ajaxFileUpload() {
	
	$('#upload-messages').html('');
	$('#upload-messages').show();
	
	$('#upload-messages').append('<br />Los reclamos se están importando en el sistema, el proceso puede durar algunos minutos...');

	$.ajaxFileUpload({
		url : window.location.pathname + '?action=uploadFile',
		secureuri : false,
		timeout: 600000,
		fileElementId : 'claimsFile',
		dataType : 'json',
		success : function(data) {
			
			result = data[1].split('-');
			
			if(result[0]=='1'){			
				$('#upload-messages').append(result[1]);
			}
			else{
				
				var explodedFileName = result[1].split('.');
				var explodedLength = explodedFileName.length;				
				var extension = explodedFileName[explodedLength-1];
				var originName = $('#originName').val();
				var fileName = result[1];
				
				var baseUrl = window.location.protocol+'//'+window.location.host;
				
				var url = baseUrl + '/services/PublicImporter.class.php?extension=' + extension + '&fileName='+fileName+'&originName='+originName;
				
				$.ajax({
				  type: "GET",
				  url: url,
				  async: true,
				  beforeSend: function(){
					  
				  },
				  complete: function(data){
					  showLoadingWheel();
				  },
				  success: function(data){
					  $('#upload-messages').append('<br />' + data);
				  },
				  error: function(){
					  alert('Error en la importación de reclamos. Verifique los datos en la base de datos.');
				  }
				});
				
			}
		},
		error : function(data, status, e) {
			showLoadingWheel();
			alert(e);
		}
	});

	return;

}

function closeClaim(claimId, stateId){
	
	if(typeof(claimId) != 'undefined' && claimId != null && typeof(stateId) != 'undefined' && stateId != null){
		
		window.location = window.location.pathname + '?action=changeClaimState&claimId='+claimId+'&stateId='+stateId;
		
	}
	else{
		return;
	}
	
}

function closeClaimNoGeo(claimId, stateId){
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=changeClaimStateNoGeo',
		async: true,
		data: {
				claimId: claimId,
				stateId: stateId
		}, 
		beforeSend: function(){
			showLoadingWheel();
		},
		complete: function(data){
			showLoadingWheel();
		},
		success: function(data){
			
			$('body').append(data[1]);
			
			var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
			
			  
			if(result == 1){
				$('#table_row_' + claimId).hide("slow", function(){
					
					//remove claim row
					$(this).remove();
					
					$('#table_row_separator_' + claimId).hide("slow", function(){
						
						//remove row separator
						$(this).remove();
						
						//If there's no pending claims, hide map
						if($('#geoLocationList tr').length <= 0){
							$('#map_canvas_container').hide("slow");
							$('#geoLocationList').append('<tr><td colspan="5">' + s_message['no_results_found'] + '</td></tr>');
						}
						
					});
					
				});
				
			}
			  
			$('#basicAjaxResultContainer').remove();
			  
		},
		error: function(){
			alert('Error al actualizar el reclamo');
		}
	});

}
	
function cancelClaims(stateId){
	
	if(confirm('¿Desea dar de baja los reclamos?')){
		changeClaimsState(stateId);
	}
	else{
		return;
	}
	
}

function changeClaimsState(stateId){
	
	var counter = 0;
	
	$('input[name="massiveActions[]"]').each(function(){
		
		if($(this).attr('checked') == 'checked'){
			counter ++;
		}
		
	});
	
	if(counter > 0){
		$('#stateId').val(stateId);
		$('#massiveActionsForm').submit();
	}
	else{
		alert('Seleccione al menos un reclamo');
		return;
	}
	
}

function savePendingTelepromClaim(elemId){
	
	var causeVal = $('#cause_' + elemId).val();
	var detailVal = trimString($('#detail_' + elemId).val());
	var piqueteVal = trimString($('#piquete_' + elemId).val());
	
	var streetVal = '';
	if(typeof $('#street_' + elemId).val() != 'undefined' && $('#street_' + elemId).val() != ''){
		streetVal = trimString($('#street_' + elemId).val());
	}
	
	var streetNumberVal = '';
	if($('#chk_new_street_number_' + elemId).prop('checked')) {
		if(typeof $('#new_street_number_' + elemId).val() != 'undefined' && $('#new_street_number_' + elemId).val() != '' ){
			streetNumberVal = $('#new_street_number_' + elemId).val();
		}
		$('#streetNumberChk').val('true');
	} else {
		if(typeof $('#street_number_' + elemId).val() != 'undefined' && $('#street_number_' + elemId).val() != '' ){
			streetNumberVal = $('#street_number_' + elemId).val();
		}
	}
	
	var requesterAddressVal = '';
	if($('#chk_edit_address_'+elemId).prop('checked')) {

		if(typeof $('#requester_address_'+elemId).val() != 'undefined' && $('#requester_address_'+elemId).val() != '') {
			requesterAddressVal = $('#requester_address_'+elemId).val();
		}
		$('#requesterAddressChk').val('true');

	}
	
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=causeId]').val(causeVal);
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=detail]').val(detailVal);
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=street]').val(streetVal);
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=streetNumber]').val(streetNumberVal);
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=piquete]').val(piqueteVal);
	$('#savePendingTelepromDataForm_' + elemId + ' input[name=requesterAddress]').val(requesterAddressVal);

	if (validateForm('savePendingTelepromDataForm_' + elemId)) {
		


		$('#cause_' + elemId).css('border','1px solid #a9bdc6');
		$('#lights_' + elemId).css('border','1px solid #a9bdc6');
		$('#piquete_' + elemId).css('border','1px solid #a9bdc6');
		
		var formAction = $('#savePendingTelepromDataForm_' + elemId).attr('action');
		var formdata = $('#savePendingTelepromDataForm_' + elemId).serialize();
		
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=' + formAction,
			async: true,
			data: formdata, 
			beforeSend: function(){
				showLoadingWheel();
			},
			complete: function(data){
				showLoadingWheel();
			},
			success: function(data){
				
				$('body').append(data[1]);
				
				var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
				  
				if(result == 1){
					$('#table_row_' + elemId).hide("slow");
					$('#table_row_label_' + elemId).hide("slow");
					$('#table_row_extended_' + elemId).hide("slow");
					$('#table_row_separator_' + elemId).hide("slow");
				}
				  
				$('#basicAjaxResultContainer').remove();
				  
			},
			error: function(){
				alert('Error al actualizar el reclamo');
			}
		});
		
	}
	else{
		
		if(typeof(causeVal) == 'undefined' || causeVal == ''){
			$('#cause_' + elemId).css('border','1px solid red');
		}
		else{
			$('#cause_' + elemId).css('border','1px solid #a9bdc6');
		}
		
		if(typeof(detailVal) == 'undefined' || detailVal == ''){
			if($('#savePendingTelepromDataForm_' + elemId + ' input[name=detail]').hasClass('mandatory-input')){
				$('#detail_' + elemId).css('border','1px solid red');
			}
			else{
				$('#detail_' + elemId).css('border','1px solid #a9bdc6');
			}
		}
		
		if(typeof(piqueteVal) == 'undefined' || piqueteVal == ''){
			if($('#savePendingTelepromDataForm_' + elemId + ' input[name=piquete]').hasClass('mandatory-input')){
				$('#piquete_' + elemId).css('border','1px solid red');
			}
			else{
				$('#piquete_' + elemId).css('border','1px solid #a9bdc6');
			}
		}
		
		if(typeof(streetVal) == 'undefined' || streetVal == ''){
			if($('#savePendingTelepromDataForm_' + elemId + ' input[name=street]').hasClass('mandatory-input')){
				$('#street_' + elemId).css('border','1px solid red');
			}
			else{
				$('#street_' + elemId).css('border','1px solid #a9bdc6');
			}
		}
		else{
			$('#street_' + elemId).css('border','1px solid #a9bdc6');
		}
		
		if(typeof(streetNumberVal) == 'undefined' || streetNumberVal == '' || streetNumberVal == null){
			if($('#savePendingTelepromDataForm_' + elemId + ' input[name=streetNumber]').hasClass('mandatory-input')){
				$('#street_number_' + elemId).css('border','1px solid red');
				$('#new_street_number_' + elemId).css('border','1px solid red');
			}
			else{
				$('#street_number_' + elemId).css('border','1px solid #a9bdc6');
				$('#new_street_number_' + elemId).css('border','1px solid #a9bdc6');
			}
		}
		else{
			$('#street_number_' + elemId).css('border','1px solid #a9bdc6');
		}

		if($('#chk_edit_address_'+elemId).prop('checked')) {
			if(typeof(requesterAddressVal) == 'undefined' || requesterAddressVal == '' || requesterAddressVal == null){
				if($('#savePendingTelepromDataForm_' + elemId + ' input[name=requesterAddress]').hasClass('mandatory-input')){
					$('#requester_address_' + elemId).css('border','1px solid red');
				}
				else{
					$('#requester_address_' + elemId).css('border','1px solid #a9bdc6');
				}
			}
			else{
				$('#requester_address_' + elemId).css('border','1px solid #a9bdc6');
			}
		}

		return;
	}

}

function exportClaims(){
	
	window.location = window.location.pathname + '?action=export';
	
}

function verifyTelepromCause(elementId){
	
	var selectedValue = $('#cause_' + elementId).val();
	
	if(selectedValue.split("_")[1]==1){
		$('#savePendingTelepromDataForm_' + elementId + ' #street').addClass('mandatory-input');
		$('#savePendingTelepromDataForm_' + elementId + ' #streetNumber').addClass('mandatory-input');
	}else{
		$('#savePendingTelepromDataForm_' + elementId + ' #street').removeClass('mandatory-input');
		$('#savePendingTelepromDataForm_' + elementId + ' #streetNumber').removeClass('mandatory-input');
	}
	
}

//Auto complete streets and numbers for Teleprom Claims
$(function() {
    
	$( ".autocomplete_control" ).each(function(){
		
		var autoCompleteObject = $(this);
		
		var action = autoCompleteObject.attr('loadaction');
		var fieldToSearch = autoCompleteObject.attr('name');
		
		autoCompleteObject.autocomplete({
		
			source: function( request, response ) {
				
				$.ajax({
					url: window.location.pathname + '?action=' + action,
					dataType: "json",
					data: {
						featureClass: "P",
						style: "full",
						maxRows: 10,
						fieldValue: htmlentities(request.term, "ENT_NOQUOTES", "UTF-8"),
						fieldToSearch: fieldToSearch,
						action: action
					},
					success: function( data ) {
	
						result = eval(data[1]);
						
						if(result.length > 0){
							response( $.map( result, function( item ) {
								return {
									label: html_entity_decode(item.value, 'ENT_NOQUOTES'),
									value: html_entity_decode(item.value, 'ENT_NOQUOTES'),
									id: item.id
								};
							}));
						}
						//Empty results
						else{
						
							var fakeArray = {"label": "", "value": s_message["no_results_found"], "id": ""};
							
							var arr = $.makeArray( fakeArray );
							
							response( $.map( arr, function( item ) {
								return {
									label: item.value,
									value: item.value,
									id: item.id
								};
							}));
							
						}
					},
					error: function (){
						autoCompleteObject.removeClass('ui-autocomplete-loading');
					}
				});
			},
			minLength: 1,
			delay: 700,
			select: function( event, ui ) {
				
				if(ui.item.id != ""){
					
					autoCompleteObject.parent().siblings('td').find('select').html('');
					
					var selectedValue = htmlentities (ui.item.value, "ENT_NOQUOTES", "UTF-8");
						
					//update street numbers
					$.ajax({
						url: window.location.pathname + '?action=getStreetNumbers',
						dataType: "json",
						data: {
							fieldValue: selectedValue
						},
						success: function( data ) {
							
							if(data[0] == 1){
								
								var parsedData = $.parseJSON(data[1]);
								
								autoCompleteObject.parent().siblings('td').find('select').append('<option value="">Seleccione...</option>');
								for(var i = 0; i < parsedData.length; i ++){
									autoCompleteObject.parent().siblings('td').find('select').append('<option value="' + parsedData[i].value + '">' + parsedData[i].value + '</option>');
								}
							}
						},
						error: function (){
							
						}
					});
					
					
				}
			},
			search: function() {
			
				//Clear street numbers
				autoCompleteObject.parent().siblings('td').find('select').html('');
				
				fieldToSearch = fieldToSearch;
				
				if(fieldToSearch == ''){
					return false;
				}
				
			},
			close: function(){
				
				autoCompleteObject.removeClass('ui-autocomplete-loading');
				
				if(autoCompleteObject.val() == "" || autoCompleteObject.val().length < 3){
					autoCompleteObject.parent().siblings('td').find('select').html('');
				}
				
			}
		});
	});
});

$( ".autocomplete_control" ).keyup(function(){
	if($(this).val().length == 0){
		$(this).parent().siblings('td').find('select').html('');
	}
});

function loadMap(elementId){
	
	var address = $('#address_' + elementId).html();
	
	if(typeof address == 'undefined' || address == null || address == ''){
		address = '';
	}
	
	submitActionAjax(
		window.location.pathname,
		'loadMapAjax',
		'',
		'',
		'',
		{
			address: address,
			elementId: elementId
		},
		''
	);
	
}

function updateClaimGeoCodes(lat, long, elementId, address){
	
	//Geolocation data
	$('#latitude_' + elementId).html(lat);
	$('#longitude_' + elementId).html(long);
	$('#geo_location_container_' + elementId).show();
	
	//Save button
	$('#confirm_button_' + elementId).show();
	
	//Update address
	$('#address_' + elementId).html(address);
	$('#address_' + elementId).attr('title',address);
	
}

function editAddressField(elementId){
	
	$('#address_' + elementId).hide();
	$('#edit_address_button_' + elementId).hide();
	$('#address_edit_' + elementId).show();
	$('#confirm_edit_address_button_' + elementId).show();
	
}

function saveAddressField(elementId){
	
	var newVal = strip_tags(trimString($('#address_edit_' + elementId).val()));
	
	$('#address_' + elementId).html(newVal);
	$('#address_edit_' + elementId).val(newVal);
	
	$('#address_' + elementId).show();
	$('#address_edit_' + elementId).hide();
	
	$('#edit_address_button_' + elementId).show();
	$('#confirm_edit_address_button_' + elementId).hide();
	
}

function saveClaimGeoLocation(elementId){
	
	var latitude = $('#latitude_' + elementId).html();
	var longitude = $('#longitude_' + elementId).html();
	var address = $('#address_' + elementId).html();
	
	if(typeof latitude != 'undefined' || latitude != '' || typeof longitude != 'undefined' || longitude != ''){
	
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=updateClaimGeoLocation',
			async: true,
			data: {
					elementId: elementId,
					latitude: latitude,
					longitude: longitude,
					claimAddress: address
			}, 
			beforeSend: function(){
				showLoadingWheel();
			},
			complete: function(data){
				showLoadingWheel();
			},
			success: function(data){
				
				$('body').append(data[1]);
				
				var result = trimString($('#basicAjaxResultContainer #ajaxMessageResult').html());
				  
				if(result == 1){
					$('#table_row_' + elementId).hide("slow", function(){
						
						//remove claim row
						$(this).remove();
						
						$('#table_row_separator_' + elementId).hide("slow", function(){
							
							//remove row separator
							$(this).remove();
							
							//If there's no pending claims, hide map
							if($('#geoLocationList tr').length <= 0){
								$('#map_canvas_container').hide("slow");
								$('#geoLocationList').append('<tr><td colspan="5">' + s_message['no_results_found'] + '</td></tr>');
							}
							
						});
						
					});
					
				}
				  
				$('#basicAjaxResultContainer').remove();
				  
			},
			error: function(){
				alert('Error al actualizar el reclamo');
			}
		});
	
	}
	else{
		alert('Debe indicar los datos de geolocalización antes de guardar');
	}
	
}

function mapClaims(){
	
	submitActionAjaxForm (
			window.location.pathname,
			'mapClaims',
			'',
			'',
			'frm_claimsFilter',
			'',
			'',
			''
		);
	
}

function telepromStats(){
	window.location = window.location.pathname + '?action=getTelepromStats';
}

function enableNewNumberText(elementId, status) {

	if(status) {
		status = false;
		value = '';
	} else {
		status = true;
	}
    $('#new_street_number_'+elementId).prop('disabled', status);
    $('#new_street_number_'+elementId).val(value);
    $('#street_number_'+elementId).prop('disabled', !status);

    if( $('#chk_new_street_number_' + elementId).prop('checked') ) {
    	$('#new_street_number_'+elementId).show();
    	$('#street_number_'+elementId).hide();
    } else {
    	$('#new_street_number_'+elementId).hide();
    	$('#street_number_'+elementId).show();
    }

}

function enableRequesterAddressText(elementId, status) {
	
	if(status) {
		status = false;
	} else {
		status = true;
	}
    $('#requester_address_'+elementId).prop('disabled', status);

    if( $('#chk_edit_address_'+elementId).prop('checked') ) {
    	$('#savePendingTelepromDataForm_' + elementId + ' #requesterAddress').addClass('mandatory-input');
    	$('#savePendingTelepromDataForm_' + elementId + ' #requesterAddressChk').val('true');
    } else {
    	$('#requester_address_'+elementId).val($('#requester_address_origin_'+elementId).val());
    	$('#requester_address_'+elementId).css('border','1px solid #a9bdc6');
    	$('#savePendingTelepromDataForm_' + elementId + ' #requesterAddress').removeClass('mandatory-input');
    	$('#savePendingTelepromDataForm_' + elementId + ' #requesterAddressChk').val('false');
    }

}

function addMultipleClaims() {

	window.location = window.location.pathname + '?action=newClaims';
}

/**
 * Add a new claim
 */
function addClaim(){
	editClaim();
}

/**
 * Update an existing claim
 * @param claimId
 */

function editClaim(claimId){
	window.location = window.location.pathname + '?action=editClaim&claimId='+claimId;
}

function claimPic(claimId){

	//window.location = window.location.pathname + '?action=claimPic&claimId='+claimId;
	//var urlPic= window.location.pathname + '?action=getClaimPic&claimId='+claimId;
	var urlPic= location.protocol+"//"+location.host+"/es/reclamos?action=getClaimPic&claimId="+claimId;


	$.get(urlPic, function(data) {

		if (data != null ){

			var claim = eval('('+data[1]+')');

			//message = '<div id="errorMessage" class="error-popup news-text" >' + '<img height="400" width="400" src="data:image/jpeg;base64,' + claim.pic +'/>' + '</div>';

			var img = claim.pic;

			picPopup();

			var myInput = document.createElement("img") ;
			myInput.setAttribute("height", "450");
			myInput.setAttribute("width", "450");
			myInput.setAttribute("src", "data:image/jpeg;base64," + img );

			$('.popup-body').append('<div class="pic-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');

			$('.popup-body').append(myInput);

		}
		else {
			message = '<div id="errorMessage" class="error-popup news-text" > NO HAY FOTO </div>';
			messagebox(message);
			$('.popup-body').append('<div class="login-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');
		}
		}, 'json');

}
/**
 * Cancel the save claim action
 */
function cancelSaveClaim() {
	window.location = window.location.pathname + '?action=getList';
}

/**function genericNoDataFound(id){

	window.location = window.location.pathname + '?action=claimPic&claimId='+claimId;



	message = '<div id="errorMessage" class="error-popup news-text" >' + id + '</div>';
	messagebox(message);
	$('.popup-body').append('<div class="login-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');
}*/

/**
 * Save a claim through ajax
 */
function saveClaim() {

	$('#stateId').removeAttr('disabled');
	$('#entry-date').removeAttr('disabled');
	$('#input-type').removeAttr('disabled');
	
	if (validateForm('claimNewEditForm')) {

		var formData = $('#claimNewEditForm').serialize();
	
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=saveClaim',
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

				if(result == 1){
					window.location = window.location.pathname + '?action=getList';
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				genericNoDataFound(s_message['error_saving_claim']);
			}
		});
		
	}		

}

/**
 * Set the datepicker values
 */
var defaultDateFormat = s_message["date_format_js"];
$(function() {
	var dates = $("#entry-date").datepicker({
		showOn: 'both', // use to enable both calendar button and textbox
        buttonImage: '/core/img/calendar.gif',
        buttonImageOnly: true,
        buttonText: s_message['show_calendar'],
        numberOfMonths: 1,           
        changeMonth: false, // must be disabled when using maxDate
        changeYear: false,
        maxDate: '+0',
        showButtonPanel: false,
        dateFormat: defaultDateFormat,
        onSelect: function(selectedDate) {
              var option = this.id == "entry-date" ? "minDate" : "maxDate";
              var instance = $(this).data("datepicker");
              var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
              dates.not(this).datepicker("option", option, date);
        }
	});

	if($('#default-date').val() != undefined){
		$('#entry-date').datepicker('setDate', $('#default-date').val());
	}

});

/**
 * Update the causes list 
 */
$('#subject').on('change', function() {
	getCauses($(this).val()); 
});

/**
 * Get the causes by subject id
 * @param subjectId
 */
function getCauses(subjectId){

	var select = document.getElementById('causeId');
	select.options.length = 0; // clear out existing items

	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getCausesBySubject',
		data: {
			subjectId: subjectId
		},
		async: true,
		success: function(data){
	
			result = eval(data[1]);

			if(result.length > 0){
				select.options.add(new Option(s_message['claim_cause_select_one'], ''));
				for (var i = 0; i < result.length; i++) {
				    select.options.add(new Option(result[i].name, result[i].id));
				}
			}

		},
		error: function(){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});
	
}

/**
 * Get the map popup and show the claim on it
 * @param claimId
 */
var claimAddress;
function geoPositionMapMultiplePoints(){
	var latitude = null;
	var longitude = null;
	var title = "";
	claimAddress = null;
	
	if($('#claim-address').val() != ''){
		claimAddress = $('#claim-address').val();
	}
	if($('#latitude').val() != ''){
		latitude = $('#latitude').val();
	}
	if($('#longitude').val() != ''){
		longitude = $('#longitude').val();
	}


	var urlUser = location.protocol+"//"+location.host+"/es/reclamos?action=getGeolocationData";
	title = claimAddress;
	if(geolocationEnabled){	
		$.get(urlUser, function(data){
			
			var geolocation = eval('('+data[1]+')');
			claimAddress += ', '+geolocation.locality+', '+geolocation.province+' ,'+geolocation.country;
			if(claimAddress != null && (latitude == null && longitude  == null)){
				georef(claimAddress, title);
			} else if(latitude == null && longitude  == null){
				latitude = centerLatitude;
				longitude = centerLongitude;
				showPopupMapMultiplePoints(latitude, longitude, title);
			}else{			
				showPopupMapMultiplePoints(latitude, longitude, title);
			}		
		}, 'json');
		
	}else{
		
		if(latitude != null && longitude  != null){		
			showPopupMapMultiplePoints(latitude, longitude, title);
		}else{			
			showPopupMapMultiplePoints(centerLatitude, centerLongitude, "");			
		}		
		
	
}
}
/**
 * Get the map popup and show the claim on it
 * @param claimId
 */
var claimAddress;
function geoPositionMap(){
	var latitude = null;
	var longitude = null;
	var title = "";
	claimAddress = null;
	
	if($('#claim-address').val() != ''){
		claimAddress = $('#claim-address').val();
	}
	if($('#latitude').val() != ''){
		latitude = $('#latitude').val();
	}
	if($('#longitude').val() != ''){
		longitude = $('#longitude').val();
	}

	var urlUser = location.protocol+"//"+location.host+"/es/reclamos?action=getGeolocationData";
	title = claimAddress;
	if(geolocationEnabled){	
		$.get(urlUser, function(data){
			
			var geolocation = eval('('+data[1]+')');
			claimAddress += ', '+geolocation.locality+', '+geolocation.province+' ,'+geolocation.country;
			if(claimAddress != null && (latitude == null && longitude  == null)){
				georef(claimAddress, title);
			} else if(latitude == null && longitude  == null){
				latitude = centerLatitude;
				longitude = centerLongitude;
				showPopupMap(latitude, longitude, title);
			}else{			
				showPopupMap(latitude, longitude, title);
			}		
		}, 'json');
		
	}else{
		
		if(latitude != null && longitude  != null){		
			showPopupMap(latitude, longitude, title);
		}else{			
			showPopupMap(centerLatitude, centerLongitude, "");			
		}		
		
	
}
}
function georef(address, title){
	//Metodo que busca por BING Maps
	var bingKey = "AtAJlYnfPc5VY-84vuu_UWPHrnS3BGGIXvFk8EClcvND7GbL0es-tQy2GB1ZaFYG";
	
	$.ajax({
       		url: "http://dev.virtualearth.net/REST/v1/Locations",
        	dataType: "jsonp",
        	data: {
            		key: bingKey,
            		q: address
        	},
        	jsonp: "jsonp",
        	success: function (data) {
            		var result = data.resourceSets[0];
            		if (result && result.estimatedTotal > 0) {
                	 	latitude = data.resourceSets[0].resources[0].point.coordinates[0];
                	 	longitude = data.resourceSets[0].resources[0].point.coordinates[1];
				showPopupMap(latitude, longitude, title);
            		}else
			{				
                        	latitude = centerLatitude;
                       		longitude = centerLongitude;
				showPopupMap(latitude, longitude, title);

			}
        	}
    	});
	/* //Metodo que busca por google maps
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'address': address}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			//Ubico la dirección ingresada
			latitude = results[0].geometry.location.lat();
			longitude = results[0].geometry.location.lng(); 
			showPopupMap(latitude, longitude, title);
		}else{
			latitude = centerLatitude;
			longitude = centerLongitude;
			showPopupMap(latitude, longitude, title);
		}
	});
*/	
}


function showPopupMap(lat, long, title){
	// Llamar al mapa pasando lat, lon, titulo del icono
	submitActionAjaxForm(
		window.location.pathname, 
		'mapGeoPositioningClaims', 
		'', 
		'', 
		'', 
		'', 
		{lat: lat,
		lon: long,
		title: title}, 
		''
	);	
}
function showPopupMapMultiplePoints(lat, long, title){
	// Llamar al mapa pasando lat, lon, titulo del icono
	submitActionAjaxForm(
		window.location.pathname, 
		'mapGeoPositioningForMultipleClaims', 
		'', 
		'', 
		'', 
		'', 
		{lat: lat,
		lon: long,
		title: title}, 
		''
	);	
}



/**
 * Get the new claim position
 */
var newLatitude, newLongitude;
function getClaimCurrentCoords(){
	
	if((newLatitude != undefined || newLatitude != '') && (newLongitude != undefined || newLongitude != '')){
		$('#latitude').val(newLatitude);
		$('#longitude').val(newLongitude);
	}
	
	PopupManager.getActive().close();

}


//------------------------------------------------------------
//------------------------------------------------------------

var fieldsStreetNumber = ['claim-street','claim-number'];
var fieldsDistrictBlockHouse = ['claim-district','claim-block', 'claim-house'];
var fieldsAddress = ['claim-address'];
var fieldsHiddenStreetNumber = ['claim_street_name', 'claim_street_number_name'];
var fieldsHiddenDistrictBlockHouse = ['claim_district_name','claim_block_name', 'claim_house_name'];


	function bindChangeEvent(){

	$('#select_type_address').change(function() {	
		$('#latitude').val('');
		$('#longitude').val('');
		var val = $(this).val();
		switch (val) {
		case 'street_number':
			$('#claim_address').hide();
			$('#claim_district_block_house').hide();
			$('#claim_street_number').show();			
			configureClaimStreetNumber();	
			disableFields(['claim-number']);	
			cleanFieldsValues(fieldsStreetNumber);			
			break;
		case 'district_block_house':
			$('#claim_address').hide();
			$('#claim_district_block_house').show();
			$('#claim_street_number').hide();	
			configureClaimDistrictBlockHouse();
			disableFields(['claim-block','claim-house' ]);
			cleanFieldsValues(fieldsDistrictBlockHouse);			
			break;
		case '':
			$('#claim_address').hide();
			$('#claim_district_block_house').hide();
			$('#claim_street_number').hide();	
			removeCssClass(fieldsDistrictBlockHouse, 'mandatory-input');
			removeCssClass(fieldsAddress, 'mandatory-input');
			removeCssClass(fieldsStreetNumber, 'mandatory-input');
			break;
		default:
			$('#claim_address').show();
			$('#claim_district_block_house').hide();
			$('#claim_street_number').hide();
			configureClaimAddress();
			cleanFieldsValues(fieldsAddress);	
			break;
			}	
		});
	
	}

	function configureClaimStreetNumber(){
		
		bindAutoComplete('claim-street', 'claim_street_name', 'claim-number','selectStreet',null);
		addCssClass(fieldsStreetNumber, 'mandatory-input');
		removeCssClass(fieldsDistrictBlockHouse, 'mandatory-input');
		removeCssClass(fieldsAddress, 'mandatory-input');	
		$('#claim-street').unbind('keyup');
		$('#claim-street').keyup(function(event){
		
			keyUp(event, ['claim-number']);
		
		});		
	}

	function configureClaimDistrictBlockHouse(){
		
		addCssClass(fieldsDistrictBlockHouse, 'mandatory-input');
		removeCssClass(fieldsAddress, 'mandatory-input');
		removeCssClass(fieldsStreetNumber, 'mandatory-input');
		bindAutoComplete('claim-district', 'claim_district_name', 'claim-block', 'selectDistrict', null);
		$('#claim-district').unbind('keyup');
		$('#claim-district').keyup(function(event){			
			keyUp(event, ['claim-block', 'claim-house']);		
		
		});			
	
	}
	
	function configureClaimAddress(){
		removeCssClass(fieldsDistrictBlockHouse, 'mandatory-input');
		addCssClass(fieldsAddress, 'mandatory-input');
		removeCssClass(fieldsStreetNumber, 'mandatory-input');	
		enableFields(['claim-address']);
	}
		
	function cleanFieldsValues(arrayIds){		
		for ( var i = 0; i < arrayIds.length; i++) {			
			if($('#'+arrayIds[i]).val().trim() != ''){				
				$('#'+arrayIds[i]).val('');				
			}					
		}		
	}
	
	function keyUp(event, arrayIdsDependencyFields){
		
			var disableDependecy = false;
										
				for ( var i = 0; i < arrayIdsDependencyFields.length; i++) {
					var dependency = arrayIdsDependencyFields[i];
					$('#'+dependency).val('');
					
				}
				disableDependecy = arrayIdsDependencyFields.length > 0;				
				$('#latitude').val('');
				$('#longitude').val('');
				if(disableDependecy){					
					disableFields(arrayIdsDependencyFields);
				}
					
	}
	
	function addCssClass(arrayIds, cssClassName){
		for ( var i = 0; i < arrayIds.length; i++) {					 
			$('#'+arrayIds[i]).addClass(cssClassName);		
		}			
	}
	
	function removeCssClass(arrayIds, cssClassName){
		for ( var i = 0; i < arrayIds.length; i++) {			
			$('#'+arrayIds[i]).css('border', '1px solid #E0DFDF');
			$('#'+arrayIds[i]).removeClass(cssClassName);		
		}			
	}

	$(document).ready(function(){
	
		bindChangeEvent();
		//disableFields(['claim-address']);
		//setReadOnlyFields(['neighborhood']);
		$('#claim-number').on('selectStreet',function(event, value){			
			configureSelectStreet(value);
		});	
	
		$('#claim-number').on('selectNumber',function(event, value){				
		var street = $('#claim-street').val();
		var number = value;		
		$.get( window.location.pathname + '?action=getLatLongForStreet', {street: street, number: number}, function(response){			
			var data = eval(response[1]);		
			$('#latitude').val(data[0].latitude);
			$('#longitude').val(data[0].longitude);			
			$('#claim-address').val(street+' '+number);			
			$('#id_type_address').val(data[0].id);
		}, "json");				
		});		
	
		$('#claim-block').on('selectDistrict', function(event, value){		
			configureSelectDistrict(value);
		});
	
		$('#claim-house').on('selectBlock', function(event, value){		
			configureSelectBlock(value);
		});
	
		$('#claim-house').on('selectHouse',function(event, value){
		var home = $('#claim_house_name').val();
		var district = $('#claim_district_name').val();
		var block = $('#claim_block_name').val();
		$.get(window.location.pathname+'?action=getLatLongForHome', {home:home, district:district, block:block}, function(response){
			var data = eval(response[1]);				
			$('#latitude').val(data[0].latitude);
			$('#longitude').val(data[0].longitude);		
			$('#id_type_address').val(data[0].id);			
			$('#claim-address').val('B° '+district+' M '+block+' C '+home);			
		}, "json");		
		
		});
		
		getTypeAddress();
		enableFields(['claim-address']);
	});

		function configureSelectDistrict(value){
	
			bindAutoComplete('claim-block', 'claim_block_name', 'claim-house','selectBlock', value);		
			$('#claim-block').unbind('keyup');
			$('#claim-block').keyup(function(event){			
				keyUp(event, ['claim-house']);			
			});		
	
			
		}	
		
		function configureSelectBlock(value){
			var parameters = [$('#claim_district_name').val(), $('#claim_block_name').val()];
			bindAutoComplete('claim-house', 'claim_house_name', null, 'selectHouse', parameters);		
			$('#claim-house').unbind('keyup');
			$('#claim-house').keyup(function(event){				
				keyUp(event, []);				
			});		
			
		}
		
		function configureSelectStreet(value){
			
			bindAutoComplete('claim-number', 'claim_street_number_name', null, 'selectNumber',value);		
			$('#claim-number').unbind('keyup');
			$('#claim-number').keyup(function(event){			
				keyUp(event, []);						
			});
			
		}
		
		function getTypeAddress(){
			var idTypeAddress = $('#id_type_address').val();
			if(typeof(idTypeAddress) != 'undefined' && idTypeAddress != '' && idTypeAddress != ""){		
				$.get(window.location.pathname + '?action=getTypeAddressById',{id:idTypeAddress},function(response){
				var data = eval(response[1]);				
				var typeAddress = data[0].type;
				switch (typeAddress) {
					case 'street_number':					
						$('#claim_street_number').show();
						$('#claim-street').val(data[0].street);
						$('#claim-number').val(data[0].number);
						$('#claim_street_name').val(data[0].street);
						$('#claim_street_number_name').val(data[0].number);
						configureClaimStreetNumber();		
						if($('#claim-street').val().trim() != ''){
							configureSelectStreet($('#claim-street').val());
						}					
						break;
					case 'district_block_house':					
						$('#claim_district_block_house').show();
						$('#claim-district').val(data[0].district);
						$('#claim-block').val(data[0].block);
						$('#claim-house').val(data[0].home);
						$('#claim_district_name').val(data[0].district);
						$('#claim_block_name').val(data[0].block);
						$('#claim_house_name').val(data[0].home);
						configureClaimDistrictBlockHouse();	
						
						if($('#claim-district').val().trim() != ''){
							configureSelectDistrict($('#claim-district').val());		
						}
									
						if($('#claim-district').val().trim() != '' && $('#claim-block').val().trim() != ''){					
							configureSelectBlock(null);					
						}
					
					break;	
				default:				
					$('#claim_address').show();
					typeAddress = 'claim_address';				
					configureClaimAddress();
					break;
				}
			$("#select_type_address").val(typeAddress);
				},"json");			
			}else{
				disableFields(['claim-address']);		
		
			}
		}	

		function disableFields(arrayIdsFields){
			for ( var i = 0; i < arrayIdsFields.length; i++) {
				$('#'+arrayIdsFields[i]).attr('disabled', 'disabled');
			}
	
		}

		function enableFields(arrayIdsFields){
			for ( var i = 0; i < arrayIdsFields.length; i++) {
				$('#'+arrayIdsFields[i]).removeAttr('disabled');
			}
		
		}

		function setReadOnlyFields(arrayIdsFields){
			for ( var i = 0; i < arrayIdsFields.length; i++) {
				$('#'+arrayIdsFields[i]).attr('readonly','readonly');
			}
		}

		function removeReadOnly(arrayIdsFields){
			for ( var i = 0; i < arrayIdsFields.length; i++) {
				$('#'+arrayIdsFields[i]).removeAttr('readonly');
			}
		}


		function bindAutoComplete(idFieldValue, idFieldHidden, idDependencyToEnabled,
				eventToFire, dependencyValue) {
			var autoCompleteObject = $('#' + idFieldValue);
			var action = autoCompleteObject.attr('loadaction');
			var minChars = autoCompleteObject.attr('minChars');
			var selectOption = false;
			autoCompleteObject.autocomplete('destroy');
			autoCompleteObject.autocomplete({

				source : function(request, response) {

					$.ajax({
						type : "POST",
						url : window.location.pathname + '?action=' + action,
						dataType : "json",
						data : {
							fieldValue : request.term,
							dependencyValue : dependencyValue
						},
						success : function(data) {

							result = eval(data[1]);

							if (result.length > 0) {

								response($.map(result, function(item) {
									return {

										value : item.value
									};
								}));
							}
							// Empty results
							else {

								var fakeArray = {
									"value" : s_message["no_results_found"]
								};
								var arr = $.makeArray(fakeArray);

								response($.map(arr, function(item) {
									return {
										value : item.value
									};
								}));

							}
						},
						error : function() {
							autoCompleteObject.removeClass('ui-autocomplete-loading');
						}
					});
				},
				minLength : minChars,
				delay : 500,
				select : function(event, ui) {

					selectOption = true;

					var currentId = $(this).attr('id');

					if (ui.item.value != s_message["no_results_found"]) {

						if (currentId == idFieldValue) {

							$('#' + idFieldHidden).val(ui.item.value);
							if (idDependencyToEnabled != null) {
								$('#' + idDependencyToEnabled).prop('disabled', false);
								if (eventToFire != null) {
									$('#' + idDependencyToEnabled).trigger(eventToFire,
											[ ui.item.value ]);
								}
							} else {

								if (eventToFire != null) {
									$('#' + idFieldValue).trigger(eventToFire,
											[ ui.item.value ]);

								}

							}
						}

					}

				},
				change : function(event, ui) {
					event.preventDefault();
					clearFieldValueNoResults(idFieldValue);

				},
				close : function(event, ui) {
					if (!selectOption) {
						$('#' + idFieldValue).val('');
					}
					event.preventDefault();
					clearFieldValueNoResults(idFieldValue);

				}
			});

			/*
			 * Eliminar el valor del campo en caso de que el usuario seleccione "No se
			 * encontraron resultados"
			 * 
			 */
			function clearFieldValueNoResults(idField) {
				if ($('#' + idField).val() == s_message["no_results_found"]) {

					$('#' + idField).val('');

				}

			}
		}


