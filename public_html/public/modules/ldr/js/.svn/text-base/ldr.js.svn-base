var company = new Object();

function getCompanyPosition(){

	// Get user company coords
	$.ajax({
		type: "POST",
		url: window.location.pathname + '?action=getCompanyPosition',
		dataType: "json",
		success: function( data ) {
			if(data[0] == 1){
				company = $.parseJSON(data[1]);
			}
		},
		error: function (){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});

}

var user = new Object();
function getUserPosition(){
	
	// Get adr user coords
	$.ajax({
		type: "POST",
		url: window.location.pathname + '?action=getUserLastPosition',
		dataType: "json",
		success: function( data ) {
			if(data[0] == 1){
				user = $.parseJSON(data[1]);
			}
		},
		error: function (){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});

}




function getAssignedClaimsPositions(){

	// Get claims
	$.ajax({
		scriptCharset: "utf-8" ,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		dataType: "json",
		type: "POST",
		url: window.location.pathname + '?action=getAssignedClaimsPositions',
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
						
						var claim = new Object();
						claim.id = result[i].id;
						claim.code = result[i].code;
						claim.substate = result[i].substateId;
						claim.latitude = result[i].lat;
						claim.longitude = result[i].long;
						claims.push(claim);
					}
				}
			}

		},
		error: function(){
			genericNoDataFound(s_message['error_retrieving_data']);
		}
	});
	
}

