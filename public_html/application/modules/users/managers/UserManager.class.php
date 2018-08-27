<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/db/UsersDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/User.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/classes/UserType.class.php');

class UserManager implements ModuleManager {

	private static $instance;

	private static $logger;

	public static function getInstance() {

		if (! isset ( UserManager::$instance )) {
			self::$instance = new UserManager ();
		}

		return UserManager::$instance;
	}

	private function __construct() {

		self::$logger = $_SESSION ['logger'];

	}

	/**
	 *
	 * Get a list of requesters
	 * @author Gabriel Guzman
	 * @param int $begin
	 * @param int $count
	 * @param int $businessUnitId
	 * @param array $filters
	 * @param string $orderField
	 * @param string $orderType
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function getUserByLogin($login) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $login ) || $login == null) {
			self::$logger->error ( 'login parameter expected' );
			throw new InvalidArgumentException ( 'login parameter expected' );
		}

		$query = UsersDB::getUserByLogin ( $login );

		$connectionManager = ConnectionManager::getInstance ();

		$userRS = $connectionManager->select ( $query );

		$user = array ();

		foreach ( $userRS as $userElement ) {
			$user [] = new User ( $userElement );

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $user;
	}
	public function getUserTypeId($login) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $login ) || $login == null) {
			self::$logger->error ( 'login parameter expected' );
			throw new InvalidArgumentException ( 'login parameter expected' );
		}

		$query = UsersDB::getUserTypeId($login);

		$connectionManager = ConnectionManager::getInstance ();

		$userRS = $connectionManager->select ( $query );



		foreach ( $userRS as $element ) {

			$obj = new User();

			$obj -> setUsertypeid($element ['usertypeid']);

		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $userRS;
	}

	public function getUserById($userId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}

		$query = UsersDB::getUserById ( $userId );

		$connectionManager = ConnectionManager::getInstance ();

		$userRS = $connectionManager->select ( $query );

		$user = array ();

		foreach ( $userRS as $userElement ) {
			$user [] = new User ( $userElement );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $user;
	}

	public function getUsersList($begin, $count, $filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}

		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}

		$userList = array ();

		$query = UsersDB::getUsers ( $begin, $count, $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$usersRS = $connectionManager->select ( $query );

		foreach ( $usersRS as $userElement ) {
			$userObj = new User ( $userElement );
			$userList [] = $userObj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $userList;

	}
	
	
	
	//Diego Saez

	public function getUsersName(){

		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$list = array ();
		$query = UsersDB::getNameUsers();

		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select ( $query );
		$name = 'Sin nombre';
		foreach ( $rs as $element ) {
			//---------------------------------------------------------
			if(isset($element ["name"])&& isset($element ["surname"])){
				
				$name = $element ["name"] .' - '.$element["surname"];
				
			}else if(isset($element ["name"])&& !isset($element ["surname"])){
				
				$name = $element ["name"];
				
			}else if(!isset($element ["name"])&& isset($element ["surname"])){
				
				$name = $element ["surname"];
			}
			
			$list [$element ["id"]] = Util::cleanString ($name);
			
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}


	public function getUsersConcepts(){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		if(!isset($_SESSION ['usersConcepts'])){

			unset($_SESSION ['usersConcepts']);
			$_SESSION ['usersConcepts'] = array();
			$_SESSION ['usersConcepts']['names'] = $this->getUsersName();		
				
		}

	}
	

	public function getUsersCount($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$usersCount = 0;

		$query = UsersDB::getUsersCount ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$usersCountRS = $connectionManager->select ( $query );

		if (isset ( $usersCountRS [0] ['numrows'] ))
			$usersCount = ( int ) $usersCountRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $usersCount;

	}

	public function getUserTypes() {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$userTypesList = array ();

		$query = UsersDB::getUserTypes ();

		$connectionManager = ConnectionManager::getInstance ();

		$userTypesRS = $connectionManager->select ( $query );

		foreach ( $userTypesRS as $userType ) {

			$userTypeObj = new UserType ( $userType );

			$userTypesList [] = $userTypeObj;

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $userTypesList;

	}

	public function insertUser($fields) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $fields ['control_userName'] ) || $fields ['control_userName'] == null) {
			self::$logger->error ( 'userName parameter expected' );
			throw new InvalidArgumentException ( 'userName parameter expected' );
		}

		if (! isset ( $fields ['control_userSurname'] ) || $fields ['control_userSurname'] == null) {
			self::$logger->error ( 'userSurname parameter expected' );
			throw new InvalidArgumentException ( 'userSurname parameter expected' );
		}

		if (! isset ( $fields ['control_userEmail'] ) || $fields ['control_userEmail'] == null) {
			self::$logger->error ( 'userEmail parameter expected' );
			throw new InvalidArgumentException ( 'userEmail parameter expected' );
		}

		if (! isset ( $fields ['control_userLogin'] ) || $fields ['control_userLogin'] == null) {
			self::$logger->error ( 'userLogin parameter expected' );
			throw new InvalidArgumentException ( 'userLogin parameter expected' );
		}

		if (! isset ( $fields ['control_userPassword'] ) || $fields ['control_userPassword'] == null) {
			self::$logger->error ( 'userPassword parameter expected' );
			throw new InvalidArgumentException ( 'userPassword parameter expected' );
		}

		if (! isset ( $fields ['control_userTypeId'] ) || $fields ['control_userTypeId'] == null) {
			self::$logger->error ( 'userTypeId parameter expected' );
			throw new InvalidArgumentException ( 'userTypeId parameter expected' );
		}

		//Check if user exists
		$user = $this->getUserByLogin ( $fields ['control_userLogin'] );

		if (isset ( $user [0] ) && is_object ( $user [0] ) && $user [0]->getUserlogin () == $fields ['control_userLogin']) {
			self::$logger->error ( Util::getLiteral ( 'username_already_exists' ) );
			throw new InvalidArgumentException ( Util::getLiteral ( 'username_already_exists' ) );
		}

		$query = UsersDB::insertUser ( $fields );

		$connectionManager = ConnectionManager::getInstance ();

		$result = $connectionManager->executeTransaction ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $result;

	}

	public function updateUser($userId, $fields) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $fields ['control_userName'] ) || $fields ['control_userName'] == null) {
			self::$logger->error ( 'userName parameter expected' );
			throw new InvalidArgumentException ( 'userName parameter expected' );
		}

		if (! isset ( $fields ['control_userSurname'] ) || $fields ['control_userSurname'] == null) {
			self::$logger->error ( 'userSurname parameter expected' );
			throw new InvalidArgumentException ( 'userSurname parameter expected' );
		}

		if (! isset ( $fields ['control_userEmail'] ) || $fields ['control_userEmail'] == null) {
			self::$logger->error ( 'userEmail parameter expected' );
			throw new InvalidArgumentException ( 'userEmail parameter expected' );
		}

		if (! isset ( $fields ['control_userLogin'] ) || $fields ['control_userLogin'] == null) {
			self::$logger->error ( 'userLogin parameter expected' );
			throw new InvalidArgumentException ( 'userLogin parameter expected' );
		}

		if (! isset ( $fields ['control_userTypeId'] ) || $fields ['control_userTypeId'] == null) {
			self::$logger->error ( 'userTypeId parameter expected' );
			throw new InvalidArgumentException ( 'userTypeId parameter expected' );
		}

		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}

		$query = UsersDB::updateUser ( $userId, $fields );

		$connectionManager = ConnectionManager::getInstance ();

		$result = $connectionManager->executeTransaction ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $result;

	}

	public function deleteUser($userId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $userId ) || $userId == null) {
			self::$logger->error ( 'userId parameter expected' );
			throw new InvalidArgumentException ( 'userId parameter expected' );
		}

		$query = UsersDB::deleteUser ( $userId );

		$connectionManager = ConnectionManager::getInstance ();

		$result = $connectionManager->executeTransaction ( $query );

		if ($result) {

			$user = $this->getUserByid ( $userId );

			if (is_object ( $user ) && $user->getId () == $userId) {
				$return = false;
			} else {
				$return = $result;
			}

		} else {
			$return = $result;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $return;

	}

}