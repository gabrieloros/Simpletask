function addPlan() {
	editPlan(null);
}

function editPlan(elementId) {
	window.location = window.location.pathname + '?action=newEditPlan&planId='+elementId;
}

function cancelSavePlan() {
	window.location = window.location.pathname + '?action=getListPlan';
}

/**
 * Saves an adr plan data through ajax
 * 
 */
function savePlan() {
	
	if (validateForm('adrPlanNewEditForm')) {

		var formData = $('#adrPlanNewEditForm').serialize();
	
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=savePlan',
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
					window.location = window.location.pathname + '?action=getListPlan';
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				genericNoDataFound(s_message['error_saving_company']);
			}
		});

	}

}

/**
 * Deletes an adr plan through ajax
 * @param elementId
 */
function deletePlan(elementId) {

	var keyPressed = confirm(s_message['confirm_delete_company']);
	
	if (keyPressed == true) {
	  
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=deletePlan',
			async: true,
			data: {
				planId: elementId
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
				var message = trimString($('#basicAjaxResultContainer #ajaxMessageResponse').html());
				var redirectUrl = window.location.pathname + '?action=getListPlan';
				
				if(result == 1){
					$('.fila_' + elementId).hide("slow", function(){
						// remove user row
						$(this).remove();
					});
					window.location = redirectUrl; 
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				genericNoDataFound(s_message['error_delete_company']);
			}
		});
		
	}
	else{
		return;
	}
	
}