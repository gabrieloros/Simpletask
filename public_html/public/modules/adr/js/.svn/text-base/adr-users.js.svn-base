$("#userLoggin").focusout(function() {

	if($("#userLoggin").val() != '') {

		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=checkUserLoggin',
			async: true,
			data: {
				logginName: $("#userLoggin").val()
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
				
				if(result == 1){
					genericNoDataFound(s_message['error_loggin_username_exists']);
					$("#userLoggin").css('border', '1px solid red');
				}
				else {
					window.location.pathname + '?action=getUserList';
					$("#userLoggin").css('border','1px solid #a9bdc6');
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				genericNoDataFound(s_message['error_loggin_username_check']);
			}
		});

	}

});

/**
 * Checks the password fields characters length
 */
function validatePasswordLength(formId, length) {
	
	if(typeof(length) === 'undefined' || length == '') length = 6;
	
	//Input password length validation
	if($('#' + formId + ' .input-password-length-validate').length > 0){
	
		var errorsCount = 0;
		var password = trimString($('#' + formId + ' .input-password-length-validate').val());
		
		if( password.length < length ) {
			$('#' + formId + ' .input-password-length-validate').css('border', '1px solid red');
			errorsCount ++;
		}
		else {
			$('#' + formId + ' .input-password-length-validate').css('border','1px solid #a9bdc6');
		}

		if(errorsCount > 0){
			
			errors = s_message['password_length_error'];
		
			submitActionAjax (window.location.pathname.substring(0,3),commonActionManagerActions.ERRORMESSAGE,'','','',{errorMessage:errors},'');
			
			return false;
		
		}
		
		return true;
		
	}

}

function addUser() {
	editUser(null);
}

function cancelSaveUser() {
	window.location = window.location.pathname + '?action=getListUser';
}

function editUser(elementId) {
	window.location = window.location.pathname + '?action=newEditUser&userId='+elementId;
}

/**
 * Deletes an adr user through ajax
 * @param elementId
 */
function deleteUser(elementId) {
	
	var keyPressed = confirm(s_message['confirm_delete_systemuser']);
	
	if (keyPressed == true) {
	  
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=deleteUser',
			async: true,
			data: {
				userId: elementId
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
				var redirectUrl = window.location.pathname + '?action=getListUser'; 
				
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
				genericNoDataFound(s_message['error_delete_systemuser']);
			}
		});
		
	}
	else{
		return;
	}
	
}

/**
 * Saves an adr user data through ajax
 * 
 */
function saveUser() {
	
	var planVal = $('#planId').val();
	
	if(($('#userPassword').val() != '' || $('#userConfirmPassword').val() != '') || ($('#userPassword').val() != '' && $('#userConfirmPassword').val() != '')) {
		$('#userPassword').attr('class', 'adr-user-input mandatory-input input-password-validate input-password-length-validate');
		$('#userConfirmPassword').attr('class', 'adr-user-input mandatory-input input-password-validate input-password-length-validate');
	}
	
	if (validateForm('adrUserNewEditForm')) {

		validatePasswordLength('adrUserNewEditForm', length);

		var formData = $('#adrUserNewEditForm').serialize();
	
		$.ajax({
			scriptCharset: "utf-8" ,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			dataType: "json",
			type: "POST",
			url: window.location.pathname + '?action=saveUser',
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
					window.location = window.location.pathname + '?action=getListUser';
				}
				
				$('#basicAjaxResultContainer').remove();
				
			},
			error: function(){
				genericNoDataFound(s_message['error_saving_systemuser']);
			}
		});
		
	}		
	else {
		
		if(typeof(planVal) == 'undefined' || planVal == '') {
			$('#planId').css('border','1px solid red');
		}
		else {
			$('#planId').css('border','1px solid #a9bdc6');
		}
		
		return;
	
	}

}
