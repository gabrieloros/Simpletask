<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';


/**
 *
 * @author mmogrovejo
 *
 */
class AdrGroupPostgreSQL extends UtilPostgreSQL {


    public static function  getAdrListGroups () {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

        $query = 'SELECT
		id,
		name,
		icon
		FROM claimgroup
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	


}