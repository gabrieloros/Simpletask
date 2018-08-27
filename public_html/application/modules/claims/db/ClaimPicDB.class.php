<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimsPostgreSQL.class.php');


/**
 * Created by PhpStorm.
 * User: Equipo 1
 * Date: 18/05/2017
 * Time: 11:24 AM
 */
class ClaimPicDB extends Util
{
    private static $logger;

    private static function initializeSession() {
        if (! isset ( self::$session ) || ! isset ( self::$logger )) {
            self::$logger = $_SESSION ['logger'];
        }
    }

    public static function getClaimViewPic($id) {

        $query = '';

        Util::getConnectionType ();

        switch ($_SESSION ['s_dbConnectionType']) {
            case Util::DB_MYSQL :
                throw new Exception ( "not implemented" );
                break;
            case Util::DB_ORACLE :
                throw new Exception ( "not implemented" );
                break;
            case Util::DB_SQLSERVER :
                throw new Exception ( "not implemented" );
                break;
            case Util::DB_POSTGRESQL :
                $query = ClaimsPostgreSQL::getClaimPic($id) ;
                break;
        }

        return $query;

    }



}