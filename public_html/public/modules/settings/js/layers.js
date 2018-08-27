/**
 * javascript para cargar los layers sobre el mapa de forma dinámica
 */
var urlBase = window.location.protocol+'//'+window.location.host;
var pathMaps = urlBase+'/maps/';
var pathName = window.location.pathname;

// Extrayendo el idioma de la url

var pathArray = pathName.trim().split('/');
var languaje = pathArray[1];
var urlSettings = urlBase+'/'+languaje+'/settings?action=getLayers';
$(window).bind('gMapsLoaded', getLayers);

$(document).ready(function(){
	if(map !== undefined ){
		
		getLayers();
		
	}
	
	
});


function getLayers(){
	
$.get(urlSettings,function(data){				
		
		var evalData = eval(data[1]);
		var layer = null;
		for (var  i = 0; i < evalData.length; i++) {		
			layer = new google.maps.KmlLayer(pathMaps+evalData[i],
					{suppressInfoWindows: true, clickable: false});
			layer.setMap(map);
		}		
		
	}, 'json');	
	
}

