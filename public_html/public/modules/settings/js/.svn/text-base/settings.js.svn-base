/**
 * file js for settingss
 */
var baseUrl = window.location.protocol+'//'+window.location.host;

var port = "";
var position = null;
	if(location.port != ""){
		
		port = ":"+location.port;
	}	


function sendUploadLayerForm(formId) {

	if (validateForm(formId)) {

		showLoadingWheel();
		uploadLayer();

	} else {
		return;
	}

	
	function uploadLayer() {
		$('#upload-messages').html('');
		$('#upload-messages').show();		
		$('#upload-messages').append('<br /> Subiendo ...');
		console.log(baseUrl);
		$.ajaxFileUpload({
			
			url : baseUrl+"/es/settings?action=uploadLayer",
			secureuri : false,
			timeout: 600000,
			fileElementId : 'layerFile',
			dataType : 'json',
			success : function(data) {
				$('#upload-messages').html('');		
				showLoadingWheel();
					response = data[1].split('#');
					
					if(response[0] !='1'){
						
						$('#upload-messages').append('<div style="color:green">'+response[1]+'</div>');
						$('#list_layers').append('<li id="item_'+response[1]+'">'+response[1]+'</li>');
						$('#layerFile').val('');
						clickLinkDelete();
					}else{						
						$('#upload-messages').append('<div style="color:red">'+s_message[response[1]]+'</div>');
						$('#layerFile').val('');
					} 			
					
			},		
		
			error : function(data, status, e) {
				showLoadingWheel();
				alert(e);
				$('#layerFile').val('');
			}
			
		});
		
	}

}



// url del módulo settings
var urlCenter = baseUrl+"/es/settings?action=getLatLongCenter";
var centerParameter = null;
var centerLatitude = null;
var centerLongitude = null;
/*
 * Obtenemos las coordenadas que se encuentran como parámetros del sistema en la 
 * base de datos 
 * 
 */
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


/*
 * Función para borrar los layers.
 * No está implementada
 * 
 * */
function clickLinkDelete(){
	$('.delete_layer').click(function(event){
		event.preventDefault(); 
		var layer = $(this).attr("id");
		 var urlDeleteLayer = urlBase+"/es/settings?action=deleteLayer";
		 $.post(urlDeleteLayer, {layer:layer}, function(data){
			 if(data[1]=='0'){
				 $('#item_'+layer).remove();
				
			 }else{				 
				 alert('error al borrar el layer');				 
			 } 			 
		 }, 'json');		
		
	});
	
}


