<?php
/**
 * Php file with common functions to any section.
 * @package /util/
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 14/03/2012
 * DATE OF LAST UPDATE:
 * PURPOSE: define common functions that are useful for any section.
 * CALLED BY: any section or class that need to use these functions.
 */

/**
 * Convert a Hexadecimal value to string.
 */
function hexToStr($hex) {
	$string = '';
	for($i = 0; $i < strlen ( $hex ) - 1; $i += 2) {
		$string .= chr ( hexdec ( $hex [$i] . $hex [$i + 1] ) );
	}
	return $string;
}

/**
 * Remove all the NON-BREAK-SPACE from the gived string.
 */
function removeNonBreakSpace($string) {
	
	$pattern = '/\b(c2a0)*|(c2a0)*\b/';
	$pattern_uppercase = '/\b(C2A0)*|(C2A0)*\b/';
	$string = bin2hex ( $string );
	$string = preg_replace ( $pattern, "", "$string" );
	$string = preg_replace ( $pattern_uppercase, "", "$string" );
	$string = hexToStr ( $string );
	return trim ( $string );
	return ($string);
}
/**
 * Get Extension from given file.
 * @return: extension of the given file
 */
function getExtension($fileName) {
	$ext = "";
	$extpos = strrpos ( $fileName, "." );
	if ($extpos !== false) {
		$ext = substr ( $fileName, $extpos + 1 );
	}
	return $ext;
}

/*	formatea la fecha según el formato establecido para el idioma actual del sitio */
function formatDate($dateOld, $format = 'm-d-Y') {
	$events_day_pe = explode ( "-", $dateOld );
	
	$new_date = date ( "Y-m-d", strtotime ( $events_day_pe [0] . "-" . $events_day_pe [1] . "-" . $events_day_pe [2] ) );
	
	$newDateFormated = date ( trim ( $format ), strtotime ( $new_date ) );
	
	return $newDateFormated;

}

function getCurrenProtocol() {
	$pageURL = 'http';
	if (isset ( $_SERVER ["HTTPS"] ) && $_SERVER ["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"]; //.$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"]; //.$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/* Formatea el texto para xml */
function formatText($input) {
	return (htmlspecialchars ( strip_tags ( html_entity_decode ( $input, ENT_NOQUOTES, 'UTF-8' ) ), ENT_NOQUOTES, 'UTF-8' ));
}

function mailCheck($email) {
	$band = 1;
	// Primero, checamos que solo haya un simbolo @, y que los largos sean correctos
	if (! ereg ( "^[^@]{1,64}@[^@]{1,255}$", $email )) {
		// correo invalido por numero incorrecto de caracteres en una parte, o numero incorrecto de simbolos @
		$band = 0;
	}
	
	// se divide en partes para hacerlo mas sencillo
	$email_array = explode ( "@", $email );
	$local_array = explode ( ".", $email_array [0] );
	
	for($i = 0; $i < sizeof ( $local_array ); $i ++) {
		if (! ereg ( "^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array [$i] )) {
			$band = 0;
		}
	}
	
	// se revisa si el dominio es una IP. Si no, debe ser un nombre de dominio valido
	if (! ereg ( "^\[?[0-9\.]+\]?$", $email_array [1] )) {
		$domain_array = explode ( ".", $email_array [1] );
		if (sizeof ( $domain_array ) < 2) {
			$band = 0; // No son suficientes partes o secciones para se un dominio
		}
		for($i = 0; $i < sizeof ( $domain_array ); $i ++) {
			if (! ereg ( "^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array [$i] )) {
				$band = 0;
			}
		}
	}
	return $band;
}
	
/**
 * this function is responsible for getting provided literal, if not found, return the same literal
 * betwen doublecolons, if default given return default.
 * @param literalS string defines the name of the literal
 * @param default  string defines the default literal if no literal found
 * @return String
*/
function getLiteral($literal,$default=''){

	if (isset($_SESSION['s_message'][$literal])) {
		$literal_to_return = $_SESSION['s_message'][$literal];
	} else {
   		$literal_to_return = $default != '' ? $default : '['.$literal.']' ;
	}
	
	return $literal_to_return;
}