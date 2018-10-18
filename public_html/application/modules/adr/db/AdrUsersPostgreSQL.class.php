<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumUserType.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumAdrUserStates.class.php';

/**
 *
 * @author mmogrovejo
 *
 */
class AdrUsersPostgreSQL extends UtilPostgreSQL {

	public static function getAdrUsersCount($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		COUNT(*) numrows
		FROM systemuser su
		INNER JOIN systemuseradr sua ON sua.systemuserid = su.id
		INNER JOIN plan p ON p.id = sua.planid
		INNER JOIN systemuseradrstate suas ON suas.id = sua.stateid
		WHERE su.usertypeid = '.EnumUserType::CLAIM_ADR
		;

		if (is_array ( $filters ) && count ( $filters ) > 0) {

			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}


	public static function getAdrUsers($begin, $count, $filters, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		su.id AS userid,
		su.userlogin AS userlogin,
		su.userpassword AS password,
		su.name AS name,
		su.surname AS surname,
		sua.phone AS phone,
		sua.phoneCompany AS phonecompany,
		p.name AS planname,
		suas.description AS statename,
		p.id planid
		FROM systemuser su
		INNER JOIN systemuseradr sua ON sua.systemuserid = su.id
		INNER JOIN plan p ON p.id = sua.planid
		INNER JOIN systemuseradrstate suas ON suas.id = sua.stateid
		WHERE su.usertypeid = '.EnumUserType::CLAIM_ADR.'
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {

			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();

			}

		}

		$query .= '
		ORDER BY su.id ' . $order . '
		LIMIT ' . $count . ' OFFSET ' . $begin . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function deleteAdrUser($userId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "DELETE FROM systemuseradr
		WHERE systemuserid = ".$userId
		;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getUserById($userId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		su.id AS userid,
		su.userlogin AS userlogin,
		su.userpassword AS password,
		su.name AS name,
		su.surname AS surname,
		sua.phone AS phone,
		sua.phoneCompany AS phonecompany,
		p.id AS planid,
		p.name AS planname,
		suas.id AS stateid,
		sua.registrationid AS registrationid,				
		suas.description AS statename		
		FROM systemuser su
		INNER JOIN systemuseradr sua ON sua.systemuserid = su.id
		INNER JOIN plan p ON p.id = sua.planid
		INNER JOIN systemuseradrstate suas ON suas.id = sua.stateid
		WHERE su.usertypeid = '.EnumUserType::CLAIM_ADR.'
		AND su.id = '.$userId
		;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getListUsers() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		su.id AS userid,
		su.userlogin AS userlogin,
		su.name AS name,
		su.surname AS surname	
		FROM systemuser su'
		;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}


	public static function updateAdrUser($userData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "UPDATE systemuseradr SET
		phone = '".$userData['phoneNumber']."',
		planid = ".$userData['planId'].",
		phoneCompany = '".$userData['phoneCompany']."'
		WHERE systemuserid = ".$userData['id']
		;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function addAdrUser($id, $userData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "INSERT INTO systemuseradr(
		systemuserid,
		phone,
		planid,
		stateid,
		phoneCompany
		) VALUES(
		".$id.",
		'".$userData['phoneNumber']."',
		".$userData['planId'].",
		".EnumAdrUserStates::DISCONNECTED.",
		'".$userData['phoneCompany']."'
		)";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUserByLoggin($loggin) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		DISTINCT su.userlogin
		FROM systemuser su
		WHERE su.usertypeid = '.EnumUserType::CLAIM_ADR.'
		AND su.userlogin = \''.$loggin.'\'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUserStates($order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		id,
		description
		FROM systemuseradrstate
		';

		$query .= '
		ORDER BY id ' . $order . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAllAdrUsers($filters, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		systemuser.id AS userid,
		systemuser.name AS firstname,
		systemuser.surname AS lastname
		FROM systemuseradr
		INNER JOIN systemuser ON systemuser.id = systemuseradr.systemuserid
		WHERE usertypeid = '.EnumUserType::CLAIM_ADR.'
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		$query .= '
		ORDER BY systemuser.id ' . $order . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUserCoords($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );
/*
		$query = "SELECT
		t.iduser AS iduser,
		t.latitude AS latitude,
		t.longitude AS longitude,
		t.reportedtime AS reportedtime,
		s.stateid AS stateid
		FROM userlocation t
		INNER JOIN (
		SELECT iduser, MAX(reportedtime) AS maxof
		FROM userlocation
		GROUP BY iduser
		) m ON t.iduser = m.iduser
		AND t.reportedtime = m.maxof
		INNER JOIN systemuseradr s
		ON s.systemuserid = t.iduser
		";

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		$query .= "
		GROUP BY t.iduser, t.latitude, t.longitude, t.reportedtime, s.stateid
		";
*/
		
		$query = " SELECT
		t.iduser AS iduser,
		t.latitude AS latitude,
		t.longitude AS longitude,
		t.reportedtime AS reportedtime,
		s.stateid AS stateid
		FROM userlocation t INNER JOIN systemuseradr s
		ON s.systemuserid = t.iduser";
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		
		$query.= " ORDER BY reportedtime desc LIMIT 1";
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUserCoordsLast($userId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		userlocation.iduser,
		userlocation.latitude,
		userlocation.longitude,
		userlocation.reportedtime,
		systemuser.name
		FROM userlocation
		INNER JOIN systemuser ON (systemuser.id = userlocation.iduser)
		WHERE userlocation.iduserlocation = (
		select max(iduserlocation)
		from userlocation u
		where u.reportedtime IS NOT NULL
		and u.iduser = '.$userId.'
		)
		';



		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getCompanyCoordsByUser($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		p.id AS planid,
		p.latitude AS latitude,
		p.longitude AS longitude
		FROM plan p
		INNER JOIN systemuseradr u ON u.planid = p.id
		WHERE 1=1
		";

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getHistoricalRouteByUser($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		iduser,
		latitude,
		longitude
		FROM userlocation
		WHERE 1=1
		";

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUserPositionDetail($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		iduser,
		iduserlocation,
		reportedtime
		FROM userlocation
		WHERE 1=1
		";

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrZones($order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		id,
		name,
		locationid,
		coordinates,
		position
		FROM zone
		';

		$query .= '
		ORDER BY id '.$order.'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getUserHistoryReport($filters, $timeFrom, $timeTo, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		uz.id AS id,
		uz.event AS event,
		uz.eventtimestamp AS eventtimestamp,
		z.name AS zonename
		FROM userzoneactivity uz
		INNER JOIN systemuser s ON s.id = uz.systemuserid
		INNER JOIN zone z ON z.id = uz.zoneid
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND uz.eventtimestamp BETWEEN '.$timeFrom.' AND '.$timeTo.'
			';
		}

		$query .= '
		ORDER BY uz.eventtimestamp '.$order.'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	//----------------------------------------------------------------

	public static function getUserActivityReport($filters, $timeFrom, $timeTo, $order){
		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = '	SELECT
		useractivity.code,
		useractivity.iduseractivity,
		userlocation.reportedtime,
		eventtype.ideventtype AS eventtype,
		concept.idconcept,
		concept.description,
		claim.code as claimcode,
		plan.name as name,
		claim.claimaddress,
		claim.stateid,
		claim.substateid,
		state.name AS statename,
		claim.id AS claimid,
		plan.planaddress			
		FROM useractivity
		left join claim on claim.id = useractivity.code
		left join eventtype on eventtype.ideventtype = useractivity.ideventtype
		left join concept on concept.idconcept = useractivity.idconcept
		left join plan on plan.id = useractivity.code
		left join userlocation on userlocation.iduserlocation = useractivity.idlocation
		left join state on state.id = claim.stateid
		WHERE 1=1'		
		;

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND  userlocation.reportedtime BETWEEN '.$timeFrom.' AND '.$timeTo.'
			';
		}

		$query .= '
		ORDER BY  userlocation.reportedtime '.$order.'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getCoordsUserActivity($filters,$timeFrom,$timeTo,$order){
		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT distinct on (useractivity.code)
		useractivity.code,
		concept.idconcept,
		concept.description,
		userlocation.reportedtime,
		claim.code AS claimcode,
		plan.name as name,
		claim.claimaddress,
		claim.latitude AS claimlatitude,
		claim.longitude AS claimlongitude,
		claim.stateid,
		claim.substateid,
		plan.latitude AS planlatitude,
		plan.longitude AS  planlongitude,
		plan.planaddress,
		state.name AS statename
		FROM useractivity
		left join claim on claim.id = useractivity.code
		left join concept on concept.idconcept = useractivity.idconcept
		left join plan on plan.id = useractivity.code
		left join userlocation on userlocation.iduserlocation = useractivity.idlocation
		left join state on state.id = claim.stateid
		where 1=1
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND  userlocation.reportedtime BETWEEN '.$timeFrom.' AND '.$timeTo.'
			';
		}

		//$query .= 'ORDER BY  userlocation.reportedtime '.$order.'';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getHistoricalUserActivity($filters,$timeFrom,$timeTo,$order){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT * FROM historicalreportuseractivity WHERE 1=1';
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND  historicalreportuseractivity.timeIn >= '.$timeFrom.' AND historicalreportuseractivity.timeIn <= '.$timeTo.'
			';
		}

		$query .= 'ORDER BY historicalreportuseractivity.id '.$order;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;
	}

	public function getHistoricalClaimsAssignedUser($filters, $timeFrom, $timeTo, $order){
		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT 	
		claim.id AS claimid,
		claim.latitude,
		claim.longitude,
		claim.claimaddress,
		claim.code,
		historicalclaimsystemuseradr.substateid,
		historicalclaimsystemuseradr.datereporting,		
		state.name,
		historicalclaimsystemuseradr.stateid 
		FROM  historicalclaimsystemuseradr
		LEFT JOIN claim ON claim.id = historicalclaimsystemuseradr.claimid
		LEFT JOIN state ON state.id = historicalclaimsystemuseradr.stateid
		WHERE 1=1';
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND  historicalclaimsystemuseradr.datereporting BETWEEN '.$timeFrom.' AND '.$timeTo.'
			';
		}

		$query .= 'ORDER BY  historicalclaimsystemuseradr.id '.$order;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	
	public static function getHistoricalClaimsUnnatendedByDate($timeFromInit, $timeToEnd, $timeFrom, $timeTo, $iduser){
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "SELECT	
					claim.id AS claimid, 
					claim.latitude, 
					claim.longitude, 
					claim.claimaddress, 
					claim.code, 
					claim.originid,
					historicalclaimsystemuseradr.substateid, 
					historicalclaimsystemuseradr.datereporting, 
					state.name, 
					historicalclaimsystemuseradr.stateid 
				FROM historicalclaimsystemuseradr 
				LEFT JOIN claim ON claim.id = historicalclaimsystemuseradr.claimid 
				LEFT JOIN state ON state.id = historicalclaimsystemuseradr.stateid 
				WHERE
					(
					(claim.originid = ".claimsConcepts::CLAIMTYPETELEPROMID." AND EXISTS(
					SELECT 1
					FROM telepromclaim
					WHERE telepromclaim.claimid = claim.id
					AND telepromclaim.datum = '5'
					)
					)
					OR
					(claim.originid <> ".claimsConcepts::CLAIMTYPETELEPROMID.")
					) AND 
				NOT EXISTS (SELECT 1 FROM historicalreportuseractivity 
				WHERE historicalreportuseractivity.idclaim = historicalclaimsystemuseradr.claimid
				AND historicalreportuseractivity.idclaim = claim.id 
				AND historicalclaimsystemuseradr.claimid = claim.id
				AND iduser = ".$iduser." AND timein BETWEEN ".$timeFrom." AND ".$timeTo.")  
				AND historicalclaimsystemuseradr.systemuseradrid = ".$iduser."		  
				AND historicalclaimsystemuseradr.datereporting BETWEEN ".$timeFromInit." AND ".$timeToEnd."
				AND claim.causeid = ".claimsConcepts::ALUMBRADO_PUBLICO_CAUSE_ID."
				AND claim.stateid = ".claimsConcepts::PENDINGSTATE."						
				AND claim.regionid IS NOT NULL";
		
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getHistoricalCoordUserActivity($filters, $timeFrom, $timeTo, $order){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT DISTINCT ON (historicalreportuseractivity.idclaim)
		historicalreportuseractivity.reference,
		historicalreportuseractivity.state,
		historicalreportuseractivity.idclaim,
		historicalreportuseractivity.address,
		historicalreportuseractivity.idconcept,
		claim.id claimid,
		historicalreportuseractivity.stateid,
		historicalreportuseractivity.substateid,
		claim.code,
		claim.entrydate,
		claim.claimaddress,
		claim.latitude AS claimlatitude,
		claim.longitude AS claimlongitude,
		plan.id AS planid,
		plan.latitude AS planlatitude,
		plan.longitude AS planlongitude
		FROM historicalreportuseractivity
		LEFT JOIN claim ON claim.id = historicalreportuseractivity.idclaim
		LEFT JOIN plan on plan.id = historicalreportuseractivity.idclaim
		WHERE 1=1';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		if($timeFrom != '' && $timeTo != '') {
			$query .= '
			AND  historicalreportuseractivity.timeIn >= '.$timeFrom.' AND historicalreportuseractivity.timeIn <= '.$timeTo.'
			';
		}

		//$query .= 'ORDER BY historicalreportuseractivity.id '.$order;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	
	
	public static function getClaimsUnnatended($idUser, $timeFrom, $timeTo){
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = "SELECT		
					claim.id,
					claim.code,
					claim.claimaddress,
					claim.stateid,
					claim.entrydate,
					claim.latitude,
					claim.longitude,
					claim.substateid,
					origin.name originname,
					subject.name AS subjectname,
					inputtype.name AS inputtypename,
					cause.name AS causename,
					dependency.name AS dependencyname,
					claim.requestername,
					claim.closedate,
					claim.assigned,
					state.name AS statename,
					claim.requesterphone
				FROM claim
				INNER JOIN state on state.id = claim.stateid
				LEFT JOIN subject on subject.id = claim.subjectid
				INNER JOIN inputtype on inputtype.id = claim.inputtypeid
				INNER JOIN origin on origin.id = claim.originid
				LEFT JOIN cause on cause.id = claim.causeid
				LEFT JOIN dependency on dependency.id = claim.dependencyid
				LEFT JOIN claimsystemuseradr ON claimsystemuseradr.claimid = claim.id
				WHERE (
				(claim.originid = ".claimsConcepts::CLAIMTYPETELEPROMID." AND EXISTS(
				SELECT 1
				FROM telepromclaim
				WHERE telepromclaim.claimid = claim.id
				AND telepromclaim.datum = '5'
				)
				)
				OR
				(claim.originid <> 2)
				)
				AND NOT EXISTS (
					select * from useractivity 
					inner join userlocation on useractivity.idlocation = userlocation.iduserlocation
					where useractivity.iduser  = ".$idUser."
					and useractivity.ideventtype = 1
					and useractivity.code = claim.id
					and userlocation.reportedtime between ".$timeFrom." and ".$timeTo.")
				AND claim.causeid = ".claimsConcepts::ALUMBRADO_PUBLICO_CAUSE_ID."
				AND claim.stateid = ".claimsConcepts::PENDINGSTATE."
				AND claim.systemuserid =" .$idUser."		
				AND claim.regionid IS NOT NULL";
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
}