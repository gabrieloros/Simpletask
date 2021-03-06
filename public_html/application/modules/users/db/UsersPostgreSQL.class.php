<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumUserType.class.php';

class UsersPostgreSQL extends UtilPostgreSQL {
	
	public static function getUserByLogin($login) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select systemuser.*,
					dependency.id dependencyid,
					dependency.name dependencyname,
					location.id locationid, 
					location.name locationname,
					location.mapfile locationmap,
					location.mapstyle locationmapstyle,
					province.name provincename,
					country.name countryname
						from systemuser
						inner join dependency
						on systemuser.dependencyid = dependency.id
						inner join location
						on dependency.locationid = location.id
						inner join province
						on location.provinceid = province.id
						inner join country
						on province.countryid = country.id
						where userlogin = \'' . $login . '\'';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}

	public static function getUserTypeId($login) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'select usertypeid
						from systemuser
						where userlogin = \'' . $login . '\'';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;
	}
	
	public static function getUserById($userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from systemuser
					where id = ' . $userId;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}

	public static function getUsers($begin, $count, $filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select user.*, usertype.typename usertypename
					from systemuser user
					inner join usertype
					on usertype.id = user.usertypeid
					where userlogin <> \'admin\'
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		$query .= '			
					order by user.userlogin ASC
					LIMIT ' . $begin . ',' . $count . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	//Diego Saez
	/**
	 * Return a database Postgre query to get list of user names
	 *
	 *
	 * @return $query
	 *
	 * */
	//----------------------------------------------------------
	//----------------------------------------------------------
	public static function getNameUsers(){
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = 'SELECT id, name, surname FROM systemuser WHERE usertypeid = 4';
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	}
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	
	
	public static function getUsersCount($filters) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select count(*) numrows
					from systemuser user
					inner join usertype
					on usertype.id = user.usertypeid
					where userlogin <> \'admin\'
					';
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			
			}
		
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function getUserTypes() {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
					from usertype
					order by typename
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function insertUser($fields) {
		
		// FIXME: Valor temporal correspondiente a la dependecia de electricidad.
		$dependencyId = 1;
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "INSERT INTO systemuser
					(
						userlogin, 
						userpassword, 
						usertypeid, 
						dependencyid, 
						name, 
						surname
					) VALUES (
						'".$fields['loggin']."',
	    				'".md5 ( $fields['password'] )."',
	    				".EnumUserType::CLAIM_ADR.",
	    				".$dependencyId.",
	    				'".$fields['firstname']."',
	    				'".$fields['lastname']."'
	    			)
	    			RETURNING id
	    		";
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function updateUser($fields) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$updatePassword = '';
		
		if($fields['password'] != '') {
			$password = md5($fields['password']);
			$updatePassword = ", userpassword = '".$password."'";
		}
		
		$query = "UPDATE systemuser SET
						  name = '".$fields['firstname'] . "'
						, surname = '".$fields['lastname']."'
						".$updatePassword."
	    			WHERE id = ".$fields['id']
				;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	public static function deleteUser($userId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "DELETE FROM systemuser
	    			WHERE id = ".$userId
				;
		
		self::$logger->debug ( __METHOD__ . ' QUERY-> ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}

}