<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';


/**
 * Implementaciones de las querys en Postgress
 * 
 * @author pdavid.romero
 *
 */
class ClosureClaimPostgreSQL extends UtilPostgreSQL {
	
	/**
	 * Obtiene los motivos de solución
	 * 
	 * @return string
	 */
	public static function getWithoutFixing() {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query ='SELECT id,
					    name,
						description
				  	FROM withoutfixingldr
					ORDER BY name
				';
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	
	}
	
	/**
	 * Obtiene la query para el listado de nmateriales
	 * 
	 * @return string
	 */
	public static function getMaterial() {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query ='SELECT id,
					    name,
						description
				  	FROM materialldr
					ORDER BY name
				';
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	
	}
	
	/* @var $claimClosure ClaimClosure */
	public static function saveClosureClaim($claimClosure,$stateCliamId) {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'INSERT INTO claimclosureldr
					(
						claimId, 
						systemuserId,
						materialldrId,
						withoutfixingldrId,
						description,
						actiondate
					)
					VALUES
					(
						\'' . $claimClosure->getClaimId() . '\',
						\'' . $claimClosure->getSystemuserId() . '\',
						\'' . $claimClosure->getMaterialldrId() . '\',
						\'' . $claimClosure->getWithoutfixingldrId() . '\',
						\'' . $claimClosure->getDescription() . '\',
						\'' . date ( "Y-m-d" ) . '\'
					)
					';
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	
	}
	
	
	
}