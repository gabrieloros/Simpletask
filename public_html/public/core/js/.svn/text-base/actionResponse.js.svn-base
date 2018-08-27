/**
 * actions JavaScript Functions
 * @package
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 25-08-2010
 *  UPDATE LIST
 *  * UPDATE:
 *  PURPOSE: This file contains the definition of all JavaScript needed for calling actions in docmanager
 *  CALLED BY: all pages with actions
 */

/**
  * creates a form to submit
  *
  * Usage: submitActionForm(urlToLaunch,actionToLaunch,backUrlIfCancel,backActionIfCancel,parametersExtrain{a:val,b:val)format)
  *
  * Parameters:
  * @url:
  *     String. submit action url
  *     Ex: /section/folderpath
  *
  * @action:
  *     String. action to execute
  *     Ex: addFile
  *
  * @backUrl:
  *     String: url to go bac in cancel case
  *     Ex: /section/folderpath
  *
  * @parameters:
  *     String: a list of extra parametesr to send always in js format : {parmkey1:value2, paramkey2:value2}
  */
function submitActionForm (url,action,returnUrl,returnAction,parameters) {
  
  if (returnUrl!='' && returnUrl!=undefined){
  	alist = returnUrl.split('/');
  	returnUrl = '/';
  	for(i=0;i < alist.length;i++){
		returnUrl = returnUrl == '/' ? encodeURIComponent(alist[i]) : returnUrl + '/' + encodeURIComponent(alist[i]); 
  	}	
  }
  var myForm = document.createElement("form");
  myForm.method="post" ;
  myForm.action = url ; 
  myForm  = setInput(myForm,'action',action); 
  myForm  = setInput(myForm,'returnUrl',returnUrl);
  myForm =  setInput(myForm,'returnAction',returnAction); 
  for (var key in parameters) {
	myForm  = setInput(myForm,key,parameters[key]);
  }  
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}

/**
  * creates a input in dom and inserts it to a form
  *
  * Usage: setInput(form,'action','addFile');
  *
  * Parameters:
  * @form:
  *     domFormObject. form to insert the input in
  *     Ex: document.createElement("form")
  *
  * @key:
  *     String. input name
  *     Ex: action
  *
  * @value:
  *     String: input value
  *     Ex: 'addFile'
  */
function setInput(form,key,value){
	var myInput = document.createElement("input") ;	 
	myInput.setAttribute("name", key);
	myInput.setAttribute("value", value);
	form.appendChild(myInput);
	return form;
}

/**
  * calls an action from ajax sending the form information expecting a standard ajaxResponse
  * Parameters:
  * @url:
  *     String. submit action url
  *     Ex: /section/folderpath
  *
  * @action:
  *     String. action to execute
  *     Ex: addFile
  *
  * @backUrl:
  *     String: url to go bac in cancel case
  *     Ex: /section/folderpath
  *
  * @backAction:
  *     String: Action to go back in cancel case
  *     Ex: editFile
  *
  * @form:
  *     String: the form name where to get all the inputs to send  
  *
  * @ajaxReturnID:
  *     String: the element id to return html if case  
  *
  * @parameters:
  *     String: a list of extra parametesr to send always in js format : {parmkey1:value2, paramkey2:value2}
  */
function submitActionAjaxForm (url,action,returnUrl,returnAction,form,ajaxReturnID,parameters,waitingImageDivId) {
	ajaxSubmitActionForm (url,action,returnUrl,returnAction,form,ajaxReturnID,parameters,waitingImageDivId)
}

/**
  * calls an action from ajax sending some expecting a standard ajaxResponse
  * Parameters:
  * @url:
  *     String. submit action url
  *     Ex: /section/folderpath
  *
  * @action:
  *     String. action to execute
  *     Ex: addFile
  *
  * @backUrl:
  *     String: url to go bac in cancel case
  *     Ex: /section/folderpath
  *
  * @backAction:
  *     String: Action to go back in cancel case
  *     Ex: editFile
  * @ajaxReturnID:
  *     String: the element id to return html if case  
  *
  * @parameters:
  *     String: a list of extra parametesr to send always in js format : {parmkey1:value2, paramkey2:value2}
  */
function submitActionAjax (url,action,returnUrl,returnAction,ajaxReturnID,parameters,waitingImageDivId) {
	ajaxSubmitActionForm (url,action,returnUrl,returnAction,null,ajaxReturnID,parameters,waitingImageDivId)
}

/**
  * calls an action from ajax sending the form information if exists and extra if needed expecting a standard ajaxResponse
  * Parameters:
  * @url:
  *     String. submit action url
  *     Ex: /section/folderpath
  *
  * @action:
  *     String. action to execute
  *     Ex: addFile
  *
  * @backUrl:
  *     String: url to go bac in cancel case
  *     Ex: /section/folderpath
  *
  * @backAction:
  *     String: Action to go back in cancel case
  *     Ex: editFile
  * @form:
  *     String: the form name where to get all the inputs to send  
  *
  * @ajaxReturnID:
  *     String: the element id to return html if case  
  *  
  * @parameters:
  *     String: a list of extra parametesr to send always in js format : {parmkey1:value2, paramkey2:value2}
  */
function ajaxSubmitActionForm (url,action,returnUrl,returnAction,form,ajaxReturnID,parameters,waitingImageDivId) {

	if(waitingImageDivId==''){
		waitingImageDivId='contact-button-cell';
	}	
	
	if(returnUrl != null) {
		alist = returnUrl.split('/');
		returnUrl = '/';
		for(i=0;i < alist.length;i++){
			returnUrl = returnUrl == '/' ? encodeURIComponent(alist[i]) : returnUrl + '/' + encodeURIComponent(alist[i]); 
		}
	}
	var formdata = 'action='+action+'&returnUrl='+returnUrl+'&returnAction='+returnAction;
	if(form){
		tmpSerialize = $('#'+ form).serialize();
		formdata = tmpSerialize == '' ? formdata : formdata + '&' + tmpSerialize;
	}
	
	if(parameters!='' && parameters!=null){
		formdata = formdata + '&'+ jQuery.param(parameters);
	}	
	
	alist = url.split('/');
	url = '/';
	for(i=0;i < alist.length;i++){
		url = url == '/' ? encodeURIComponent(alist[i]) : url + '/' + encodeURIComponent(alist[i]); 
	}	
	
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		url: url,
		cache:false,
	    type:"POST",
	    data: formdata,
	    dataType: "json",
	    beforeSend:function(){
	    	displayLoadingImageById(waitingImageDivId);
	    },
	    complete:function(){
	    	displayLoadingImageById(waitingImageDivId);
	    },
	    success:function(data){	    	
	    	if (data==null){launchGenericError();return;} 
	    	if(data.length!=2){
	    		launchGenericError();
	    		return false;
	    	}else{	
	    		ajaxResponse(data,ajaxReturnID);
	    		return true;
	    	}	
	    },
	    error:function(){
	    	launchGenericError();
	    	return false;
	    }	
	});
}
/**
  * calls an error popup for a generic conection error or an incosnsistent return to the ajax
  * Parameters:
  */
function launchGenericError(){
	popup(s_message['connection_error'],messageBoxType.ERROR,'','',1);
} 
/**
  * redirects/launches popup/iserts htm depending in the response way  
  * Parameters:
  *
  * @data:
  *     String. the response data with type and depending of the type information
  *     Ex: array(redirect,'/section/folder')
  *
  * @ajaxReturnID:
  *     String. the element id where to insert the html if the response type is html
  *     Ex: addFile
  * 
  */
function ajaxResponse(data,ajaxReturnID){
	switch(data[0]){
		case ajaxResponseType.REDIRECT:  			
  			window.location = data[1]; 
  			break;
		case ajaxResponseType.RENDER:
   			 $('#'+ajaxReturnID).html(data[1]);
   			 break;   			    			 
		case ajaxResponseType.MESSAGEBOX:
			response = data[1]; 
			if(response[1]){
				document.getElementById(response[1]).reset();	
			}
			messagebox(response[0]);			
//			$('.popup-body').append('<div class="login-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');
			break;
		case ajaxResponseType.CONFIRMBOX:
			response = data[1]; 
			if(response[1]){
				document.getElementById(response[1]).reset();	
			}
			messagebox(response[0]);			
			break;
	}
}


function displayLoadingImage(){
	displayLoadingImageById('contact-button-cell');
}

function displayLoadingImageById(id){
	if(!$('#loading-msg').length){
		$('#'+id).prepend('<img id="loading-msg" alt="Loading..." src="/core/img/popup/ajax-loader.png" />');
	}
	else{
		$('#loading-msg').remove();
	}	
}
function launchGenericError(){
	message = '<div id="errorMessage" class="error-popup news-text" >' + s_message['connection_error'] + '</div>';
	messagebox(message);
	$('.popup-body').append('<div class="login-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');	
}


function genericNoDataFound(msg){
	message = '<div id="errorMessage" class="error-popup news-text" >' + msg + '</div>';
	messagebox(message);
	$('.popup-body').append('<div class="login-popup-close" onclick="PopupManager.getActive().close();" onkeypress="PopupManager.getActive().close();"><img src="/core/img/popup/close-popup.gif"/></div>');	
}
