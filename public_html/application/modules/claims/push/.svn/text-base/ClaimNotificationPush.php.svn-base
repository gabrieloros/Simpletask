<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimRequestPush.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/util/HttpUtilConstants.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/util/requests/Requests.php');

/**
 * Clase que se encarga del envio de notificaciones push de un reclamo
 *
 * @author dalberto.saez
 *        
 */
class ClaimNotificationPush {
	private $urlServer;
	private $user;
	private $password;
	public function __construct() {
		$conf = parse_ini_file ( $_SERVER ['DOCUMENT_ROOT'] . '/../application/configs/config.ini' );
		$this->urlServer = $conf ['urlpushmessage'];
		$this->user = $conf ['userpushmessage'];
		$this->password = $conf ['passwordpushmessage'];
	}
	
	/**
	 *
	 * @param ClaimRequestPush $requestPush        	
	 */
	public function sendClaimNotificationPush($requestPush) {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$_SESSION ['logger']->debug ( 'Enviando petición push de reclamo con id: ' . $requestPush->getClaim ()->getId () );
		$requestBody = $requestPush->getJson ();
		$_SESSION ['logger']->debug ( 'Enviando body: ' . $requestBody );
		$passwordEncode = md5 ( $this->password );
		$url = $this->urlServer . '/' . $this->user . '/' . $passwordEncode;
		$_SESSION ['logger']->debug ( 'Url Server: ' . $url );
		$headers = array (
				HttpUtilConstants::ACCEPT_HEADER => HttpUtilConstants::ACCEPT_HEADER_VALUE_JSON,
				HttpUtilConstants::CONTENT_TYPE_HEADER => HttpUtilConstants::CONTENT_TYPE_VALUE_JSON 
		);
		$options = array ();
		Requests::register_autoloader ();
		$response = Requests::post ( $url, $headers, $requestBody, $options );
		
		$responseDecode = json_decode ( $response->body );
		
		if (isset ( $responseDecode )) {
			
			$_SESSION ['logger']->debug ( 'Resultado de notificación push ' . $responseDecode->data->responseMsg );
			
			if (! $responseDecode->data->responseCode == 'OK' && ! $responseDecode->result) {
				
				$_SESSION ['logger']->error ( 'Error al enviar notificación push a reclamo con id: ' . $requestPush->getClaim ()->getId () );
			}
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
	}
}