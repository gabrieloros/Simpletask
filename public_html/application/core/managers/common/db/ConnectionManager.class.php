<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/MySQLConnectionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/PostgreSQLConnectionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/db/enums/DBMSList.enum.php';

class ConnectionManager {
	
	private static $instance;
	private static $dbmsinstance;
	private static $dbms;
	
	function __construct() {
		
		$conf = parse_ini_file ( $_SERVER ['DOCUMENT_ROOT'] . '/../application/configs/config.ini' );
		
		self::$dbms = $conf ['dbms'];
	
	}
	
	public static function getInstance() {
		
		if (! isset ( self::$instance )) {
			
			self::$instance = new ConnectionManager();
			
		}
		
		if (! isset ( self::$dbmsinstance )) {
		
			switch(self::$dbms){
				
				case DBMSList::MYSQL:{
					self::$dbmsinstance = MySQLConnectionManager::getInstance();
					break;				
				}
				case DBMSList::ORACLE:{
					
					break;
				}
				case DBMSList::POSTGRESQL:{
					self::$dbmsinstance = PostgreSQLConnectionManager::getInstance();
					break;
				}
				
			}
		
		}
		
		return self::$dbmsinstance;
		
	}

}
?>