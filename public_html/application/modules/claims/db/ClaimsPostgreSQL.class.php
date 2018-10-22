<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';


class ClaimsPostgreSQL extends UtilPostgreSQL {

	public static function getCauses() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query ='SELECT *
		FROM cause
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getCausesBySubject($subjectId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query ='SELECT
		id,
		name
		FROM cause
		WHERE subjectid = '.$subjectId.'
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getGroupInfo($groupId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query ='SELECT
		id,
		name,
		icon
		FROM claimgroup
		WHERE id = '.$groupId.'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getDependencies() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM dependency
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getInputTypes() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM inputtype
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getOrigins() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM origin
		ORDER BY name
		';
		

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;



	}

	public static function getStates() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM state
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getSubjects() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM subject
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getTelepromCauses() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM telepromcause
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function insertClaim($claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		//Phone
		$phone = 'DEFAULT';
		if (isset ( $claimData ["requesterPhone"] ) && $claimData ["requesterPhone"] != null && $claimData ["requesterPhone"] != '' && is_numeric ( $claimData ["requesterPhone"] )) {
			$phone = $claimData ["requesterPhone"];
		}

		$regionId = 'DEFAULT';
		if(isset($claimData ["regionId"]) && $claimData ["regionId"] != null && $claimData ["regionId"] != 0){
			$regionId = $claimData ["regionId"];
		}

		$query = 'INSERT INTO claim
		(
		code,
		subjectid,
		inputtypeid,
		causeid,
		originid,
		dependencyid,
		stateid,
		entrydate,
		detail,
		systemuserid,
		closedate,
		requestername,
		claimaddress,
		requesterphone,
		assigned,
		piquete,
		latitude,
		longitude,
		neighborhood,
		regionid,
		typeaddressid
		)
		VALUES
		(
		\'' . $claimData ["code"] . '\',
		' . $claimData ["subjectId"] . ',
		' . $claimData ["inputTypeId"] . ',
		' . $claimData ["causeId"] . ',
		' . $claimData ["originId"] . ',
		' . $claimData ["dependencyId"] . ',
		' . $claimData ["stateId"] . ',
		\'' . $claimData ["entryDate"] . '\',
		\'' . $claimData ["detail"] . '\',
		' . $claimData ["systemUserId"] . ',

		DEFAULT,
		\'' . $claimData ["requesterName"] . '\',
		\'' . $claimData ["claimAddress"] . '\',
		' . $phone . ',
		' . $claimData ["assigned"] . ',
		\'' . $claimData ["piquete"] . '\',
		\'' . $claimData ["latitude"] . '\',
		\'' . $claimData ["longitude"] . '\',
		\'' . $claimData ["neighborhood"] . '\',
		' . $regionId . ',
		' . $claimData ["id_type_address"] . '
		)
		returning id lastInsertedId
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function insertTelepromClaim($claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$lights = 'DEFAULT';

		if (isset ( $claimData ["lights"] ) && $claimData ["lights"] != null && $claimData ["lights"] != 0) {
			$lights = $claimData ["lights"];
		}

		$query = 'INSERT INTO telepromclaim
		(
		claimid,
		datum,
		lights,
		requesteraddress
		)
		VALUES
		(
		' . $claimData ["claimId"] . ',
		\'' . $claimData ["datum"] . '\',
		' . $lights . ',
		\'' . $claimData ["requesterAddress"] . '\'
		)
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function checkExistenceInDB($claimdata) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT id
		FROM claim
		WHERE code = \'' . $claimdata ['code'] . '\'
		AND entrydate = \'' . $claimdata ['entryDate'] . '\'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getTelepromCount() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) telepromclaimscount
		FROM telepromclaim
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getClaims($begin, $count, $filters, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT DISTINCT 
		claim.id claimid,
		claim.detail,
		claim.code,
		claim.priority,
		subject.name subjectname,
		inputtype.name inputtypename,
		cause.icon icon,
		cause.name causename,
		claim.causeid,
		origin.name originname,
		dependency.name dependencyname,
		claim.stateid,
		state.name statename,
		claim.entrydate,
		claim.closedate,
		claim.requestername,
		claim.claimaddress,
		claim.requesterphone,
		claim.assigned,
		systemuser.id,
		systemuser.name,
		systemuser.surname,
		systemuser.usertypeid,
                claimclosureldr.description,                
                mat.mat_1 as mat_1,
                mat.mat_2 as mat_2,
                mat.mat_3 as mat_3,
                mat.mat_4 as mat_4,
                mat.mat_5 as mat_5
	    FROM claim
		INNER JOIN state on state.id = claim.stateid
		LEFT JOIN subject on subject.id = claim.subjectid
		INNER JOIN inputtype on inputtype.id = claim.inputtypeid
		INNER JOIN origin on origin.id = claim.originid
		LEFT JOIN cause on cause.id = claim.causeid
		LEFT JOIN dependency on dependency.id = claim.dependencyid
		LEFT JOIN systemuser on claim.systemuserid = systemuser.id
		FULL JOIN claimclosureldr on claimclosureldr.claimid = claim.id
		FULL JOIN 
			(select DISTINCT claimclose,mat_1,mat_2,mat_3,mat_4,mat_5 
			from crosstab($$select cm.claimclosureldrid,m.id,m.name from claimclosureldr_materialldr cm LEFT JOIN materialldr as m on m.id=cm.materialldrid$$) as (claimclose bigint,mat_1 character varying(50),mat_2 character varying(50),mat_3 character varying(50),mat_4 character varying(50),mat_5 character varying(50))) as mat on claimclose = claimclosureldr.id
			WHERE (
		(claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		)
		)
		OR
		(claim.originid <> 2)
		)
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {

			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();


			}

		}

        
		$query .= '
		ORDER BY claim.entrydate ' . $order . '
		LIMIT ' . $count . ' OFFSET ' . $begin . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		
		// var_dump($query);
		// die();
		return $query;


	}


	public static function getClaim($id) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = '
	SELECT
		claim.id claimid,
		claim.code,
		claim.detail,
		subject.name subjectname,
		subject.id subjectid,
		inputtype.name inputtypename,
		inputtype.id inputtypeid,
		cause.name causename,
		cause.id causeid,
		origin.name originname,
		origin.id originid,
		dependency.name dependencyname,
		dependency.id dependencyid,
		claim.stateid stateid,
		state.name statename,
		claim.entrydate,
		claim.closedate,
		claim.requestername,
		claim.claimaddress,
		claim.requesterphone,
		claim.assigned,
		claim.latitude,
		claim.longitude,
		claim.neighborhood,
		claim.typeaddressid,
		claim.systemuserid,
		claim.substateid,		
		region.name regionname,
		claim.piquete,
		claim.groupid,
		g.name as namegroup		
FROM 
		claim
LEFT JOIN 
        claimgroup g ON g.id = claim.groupid		
INNER JOIN 
		state on state.id = claim.stateid
LEFT JOIN 
		subject on subject.id = claim.subjectid
INNER JOIN
		inputtype on inputtype.id = claim.inputtypeid
INNER JOIN
		origin on origin.id = claim.originid
LEFT JOIN 
		cause on cause.id = claim.causeid
LEFT JOIN 
		dependency on dependency.id = claim.dependencyid
LEFT JOIN 
		region on claim.regionid = region.id
WHERE claim.id = '.$id ;



		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getClaimsCount($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) numrows
		FROM claim
		INNER JOIN state ON state.id = claim.stateid
		LEFT JOIN subject ON subject.id = claim.subjectid
		INNER JOIN inputtype ON inputtype.id = claim.inputtypeid
		INNER JOIN origin ON origin.id = claim.originid
		LEFT JOIN cause ON cause.id = claim.causeid
		LEFT JOIN dependency ON dependency.id = claim.dependencyid
		WHERE (
		(claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		)
		)
		OR
		(claim.originid <> 2)
		)
		

		';

		//AND claim.causeid = 14

		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAllClaimsCount() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) numrows
		FROM claim
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getPendingTelepromClaims($begin, $count, $filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		claim.id claimid,
		claim.code,
		subject.name subjectname,
		inputtype.name inputtypename,
		cause.name causename,
		origin.name originname,
		dependency.name dependencyname,
		claim.stateid,
		state.name statename,
		claim.entrydate,
		claim.closedate,
		claim.requestername,
		claim.claimaddress,
		claim.requesterphone,
		claim.assigned,
		telepromclaim.requesteraddress
		FROM claim
		INNER JOIN telepromclaim ON telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		AND telepromclaim.lights IS NULL
		INNER JOIN state ON state.id = claim.stateid
		LEFT JOIN subject ON subject.id = claim.subjectid
		INNER JOIN inputtype ON inputtype.id = claim.inputtypeid
		INNER JOIN origin ON origin.id = claim.originid
		LEFT JOIN cause ON cause.id = claim.causeid
		LEFT JOIN dependency ON dependency.id = claim.dependencyid
		WHERE claim.causeid IS NULL
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		$query .= '
		ORDER BY claim.entrydate DESC, claim.id DESC
		LIMIT ' . $count . ' OFFSET ' . $begin . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getPendingTelepromClaimsCount($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) numrows
		FROM claim
		INNER JOIN telepromclaim ON telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		AND telepromclaim.lights IS NULL
		INNER JOIN state ON state.id = claim.stateid
		LEFT JOIN subject ON subject.id = claim.subjectid
		INNER JOIN inputtype ON inputtype.id = claim.inputtypeid
		INNER JOIN origin ON origin.id = claim.originid
		LEFT JOIN cause ON cause.id = claim.causeid
		LEFT JOIN dependency ON dependency.id = claim.dependencyid
		WHERE claim.causeid IS NULL
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

	public static function changeClaimState($stateId, $claims) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimList = '';

		foreach ( $claims as $key => $claim ) {
			if ($key != (count ( $claims ) - 1)) {
				$claimList .= $claim . ',';
			} else {
				$claimList .= $claim;
			}
		}

		$dateQuery = '';
		if ($stateId == claimsConcepts::CLOSEDSTATE || $stateId == claimsConcepts::CLOSEDSTATENOGEO) {
			$dateQuery = ', closedate = \'' . date ( "Y-m-d" ) . '\'';
		}

		if($stateId == claimsConcepts::CLOSEDSTATENOGEO) {
			$regionQuery = ', regionid = -1';
		}
			
		$query = 'UPDATE claim
		SET stateid = ' . $stateId . '
		' . $dateQuery .'
		' . $regionQuery.'
		WHERE id IN (' . $claimList . ')';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function updateClaim($claimId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		foreach ($claimData as $key => $post){
			$claimData[$key] = str_replace('\'', '\'\'', $post);
		}

		$query = 'UPDATE claim
		SET code = code
		';

		if (isset ( $claimData ['subjectId'] ) && $claimData ['subjectId'] != null) {
			$query .= ', subjectid = ' . $claimData ['subjectId'];
		} elseif (isset ( $claimData ['causeId'] ) && $claimData ['causeId'] != null) {
			$query .= ', causeid = ' . $claimData ['causeId'] . ', subjectid = ' . $_SESSION ['claimsConcepts'] ['causes'] [$claimData ['causeId']] ['subjectId'];
		}

		if (isset ( $claimData ['claimAddress'] ) && $claimData ['claimAddress'] != null) {
			$query .= ', claimaddress = \'' . $claimData ['claimAddress'] . '\'';
		}

		if(isset($claimData['piquete']) && $claimData['piquete'] != null){
			$query .= ', piquete = \''.$claimData['piquete'].'\'' ;
		}

		if(isset($claimData['latitude']) && $claimData['latitude'] != null){
			$query .= ', latitude = \''.$claimData['latitude'].'\'' ;
		}

		if(isset($claimData['longitude']) && $claimData['longitude'] != null){
			$query .= ', longitude = \''.$claimData['longitude'].'\'' ;
		}

		if(isset($claimData['regionId']) && $claimData['regionId'] != null && $claimData['regionId'] != 0){
			$query .= ', regionid = '.$claimData['regionId'].'' ;
		}

		if (isset ( $claimData ['detail'] ) && $claimData ['detail'] != null) {
			$query .= ', detail = \'' . $claimData['detail'].'\'';
		}

		if (isset ( $claimData ['neighborhood'] ) && $claimData ['neighborhood'] != null) {
			$query .= ', neighborhood = \'' . $claimData['neighborhood'].'\'';
		}else{
			$query .= ", neighborhood = ''";
			
		}

		if (isset ( $claimData ['entryDate'] ) && $claimData ['entryDate'] != null) {
			$date = date('Y-m-d', strtotime(str_replace('/', '-', $claimData['entryDate'])));
			$query .= ', entrydate = \'' . $date.'\'';
		}
/*
		if (isset ( $claimData ['causeId'] ) && $claimData ['causeId'] != null) {
			$query .= ', causeid = '.$claimData['causeId'].'' ;
		}

		*/
		if (isset ( $claimData ['id_type_address'] ) && $claimData ['id_type_address'] != null) {
			$typeAddress = $claimData ['id_type_address'];
			$query .= ', typeaddressid = ' .$typeAddress;
		}
		
		$query .= ' WHERE id = ' . $claimId;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function updateTelepromClaim($claimId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'UPDATE telepromclaim
		';

		if (isset ( $claimData ['telepromCauseId'] ) && $claimData ['telepromCauseId'] != null) {
			$query .= 'SET causeid = ' . $claimData['telepromCauseId'];
		}

		$query .= ' WHERE claimid = ' . $claimId;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function updateTelepromClaimRequesterAddress($claimId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'UPDATE telepromclaim
		SET  requesterAddress = \'' . $claimData['requesterAddress'].'\'
		WHERE claimid = ' . $claimId
		;


		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}


	public static function getDataFromPhoneDirectory($phone) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM phone_directory
		WHERE phone2 LIKE \'%'.$phone.'%\'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getNullCodeCauCount() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) caucount
		FROM claim
		WHERE code LIKE \'%R-%\'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function insertStreetLightsClaimData($claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'INSERT INTO street_lights_claims_data
		(
		claimid';

		if(isset($claimData['tulipa']) && $claimData['tulipa'] != null){
			$query .= '
			,tulipa';
		}
		if(isset($claimData['portalampara']) && $claimData['portalampara'] != null){
			$query .= '
			,portalampara';
		}
		if(isset($claimData['canasto']) && $claimData['canasto'] != null){
			$query .= '
			,canasto';
		}
		if(isset($claimData['fusible']) && $claimData['fusible'] != null){
			$query .= '
			,fusible';
		}
		if(isset($claimData['lamp_125']) && $claimData['lamp_125'] != null){
			$query .= '
			,lamp_125';
		}
		if(isset($claimData['lamp_150']) && $claimData['lamp_150'] != null){
			$query .= '
			,lamp_150';
		}
		if(isset($claimData['lamp_250']) && $claimData['lamp_250'] != null){
			$query .= '
			,lamp_250';
		}
		if(isset($claimData['lamp_400']) && $claimData['lamp_400'] != null){
			$query .= '
			,lamp_400';
		}
		if(isset($claimData['ext_125']) && $claimData['ext_125'] != null){
			$query .= '
			,ext_125';
		}
		if(isset($claimData['ext_150']) && $claimData['ext_150'] != null){
			$query .= '
			,ext_150';
		}
		if(isset($claimData['ext_250']) && $claimData['ext_250'] != null){
			$query .= '
			,ext_250';
		}
		if(isset($claimData['ext_400']) && $claimData['ext_400'] != null){
			$query .= '
			,ext_400';
		}
		if(isset($claimData['int_125']) && $claimData['int_125'] != null){
			$query .= '
			,int_125';
		}
		if(isset($claimData['int_150']) && $claimData['int_150'] != null){
			$query .= '
			,int_150';
		}
		if(isset($claimData['int_250']) && $claimData['int_250'] != null){
			$query .= '
			,int_250';
		}
		if(isset($claimData['int_400']) && $claimData['int_400'] != null){
			$query .= '
			,int_400';
		}
		if(isset($claimData['morceto']) && $claimData['morceto'] != null){
			$query .= '
			,morceto';
		}
		if(isset($claimData['espejo']) && $claimData['espejo'] != null){
			$query .= '
			,espejo';
		}
		if(isset($claimData['columna']) && $claimData['columna'] != null){
			$query .= '
			,columna';
		}
		if(isset($claimData['atrio']) && $claimData['atrio'] != null){
			$query .= '
			,atrio';
		}
		if(isset($claimData['neutro']) && $claimData['neutro'] != null){
			$query .= '
			,neutro';
		}
		if(isset($claimData['cable']) && $claimData['cable'] != null){
			$query .= '
			,cable';
		}

		$query .= '
		)
		VALUES
		(
		'.$claimData["claimId"];

		if(isset($claimData['tulipa']) && $claimData['tulipa'] != null){
			$query .= '
			,'.$claimData['tulipa'];
		}
		if(isset($claimData['portalampara']) && $claimData['portalampara'] != null){
			$query .= '
			,'.$claimData['portalampara'];
		}
		if(isset($claimData['canasto']) && $claimData['canasto'] != null){
			$query .= '
			,'.$claimData['canasto'];
		}
		if(isset($claimData['fusible']) && $claimData['fusible'] != null){
			$query .= '
			,'.$claimData['fusible'];
		}
		if(isset($claimData['lamp_125']) && $claimData['lamp_125'] != null){
			$query .= '
			,'.$claimData['lamp_125'];
		}
		if(isset($claimData['lamp_150']) && $claimData['lamp_150'] != null){
			$query .= '
			,'.$claimData['lamp_150'];
		}
		if(isset($claimData['lamp_250']) && $claimData['lamp_250'] != null){
			$query .= '
			,'.$claimData['lamp_250'];
		}
		if(isset($claimData['lamp_400']) && $claimData['lamp_400'] != null){
			$query .= '
			,'.$claimData['lamp_400'];
		}
		if(isset($claimData['ext_125']) && $claimData['ext_125'] != null){
			$query .= '
			,'.$claimData['ext_125'];
		}
		if(isset($claimData['ext_150']) && $claimData['ext_150'] != null){
			$query .= '
			,'.$claimData['ext_150'];
		}
		if(isset($claimData['ext_250']) && $claimData['ext_250'] != null){
			$query .= '
			,'.$claimData['ext_250'];
		}
		if(isset($claimData['ext_400']) && $claimData['ext_400'] != null){
			$query .= '
			,'.$claimData['ext_400'];
		}
		if(isset($claimData['int_125']) && $claimData['int_125'] != null){
			$query .= '
			,'.$claimData['int_125'];
		}
		if(isset($claimData['int_150']) && $claimData['int_150'] != null){
			$query .= '
			,'.$claimData['int_150'];
		}
		if(isset($claimData['int_250']) && $claimData['int_250'] != null){
			$query .= '
			,'.$claimData['int_250'];
		}
		if(isset($claimData['int_400']) && $claimData['int_400'] != null){
			$query .= '
			,'.$claimData['int_400'];
		}
		if(isset($claimData['morceto']) && $claimData['morceto'] != null){
			$query .= '
			,'.$claimData['morceto'];
		}
		if(isset($claimData['espejo']) && $claimData['espejo'] != null){
			$query .= '
			,'.$claimData['espejo'];
		}
		if(isset($claimData['columna']) && $claimData['columna'] != null){
			$query .= '
			,'.$claimData['columna'];
		}
		if(isset($claimData['atrio']) && $claimData['atrio'] != null){
			$query .= '
			,'.$claimData['atrio'];
		}
		if(isset($claimData['neutro']) && $claimData['neutro'] != null){
			$query .= '
			,'.$claimData['neutro'];
		}
		if(isset($claimData['cable']) && $claimData['cable'] != null){
			$query .= '
			,'.$claimData['cable'];
		}

		$query .= '
		)
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getClaimsForExport($begin, $count, $filters, $order){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT DISTINCT 
		claim.id claimid,
		claim.detail,
		claim.code,
		claim.priority,
		subject.name subjectname,
		inputtype.name inputtypename,
		cause.icon icon,
		cause.name causename,
		claim.causeid,
		origin.name originname,
		dependency.name dependencyname,
		claim.stateid,
		state.name statename,
		claim.entrydate,
		claim.closedate,
		claim.requestername,
		claim.claimaddress,
		claim.requesterphone,
		claim.assigned,
		systemuser.id,
		systemuser.name,
		systemuser.surname,
		systemuser.usertypeid,
                claimclosureldr.description,                
                mat.mat_1,
                mat.mat_2,
                mat.mat_3,
                mat.mat_4,
                mat.mat_5
	        FROM claim
		INNER JOIN state on state.id = claim.stateid
		LEFT JOIN subject on subject.id = claim.subjectid
		INNER JOIN inputtype on inputtype.id = claim.inputtypeid
		INNER JOIN origin on origin.id = claim.originid
		LEFT JOIN cause on cause.id = claim.causeid
		LEFT JOIN dependency on dependency.id = claim.dependencyid
		LEFT JOIN systemuser on claim.systemuserid = systemuser.id
		FULL JOIN claimclosureldr on claimclosureldr.claimid = claim.id
		FULL JOIN 
			(select DISTINCT claimclose,mat_1,mat_2,mat_3,mat_4,mat_5 
				from crosstab($$select cm.claimclosureldrid,m.id,m.name from claimclosureldr_materialldr cm LEFT JOIN materialldr as m on m.id=cm.materialldrid$$) 
					as (claimclose bigint,mat_1 character varying(50),mat_2 character varying(50),mat_3 character varying(50),mat_4 character varying(50),mat_5 character varying(50))
					) as mat on claimclose = claimclosureldr.id
		WHERE
			 claim.regionid IS not NULL
		';
		//AND claim.causeid = 14
		if(is_array($filters) && count($filters) > 0){
				
			foreach ($filters as $filter){
					
				$query .= $filter->getCriteriaQuery();
					
			}
				
		}

		$query .= '
		ORDER BY claim.entrydate '.$order.', claim.id DESC
		LIMIT ' . $count . ' OFFSET ' . $begin . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getClaimsCountForExport($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(*) numrows
		FROM claim
		INNER JOIN state ON state.id = claim.stateid
		LEFT JOIN subject ON subject.id = claim.subjectid
		INNER JOIN inputtype ON inputtype.id = claim.inputtypeid
		INNER JOIN origin ON origin.id = claim.originid
		LEFT JOIN cause ON cause.id = claim.causeid
		LEFT JOIN dependency ON dependency.id = claim.dependencyid
		LEFT JOIN telepromclaim teleprom ON teleprom.claimid = claim.id
		LEFT JOIN street_lights_claims_data streetlights ON streetlights.claimid = claim.id
		WHERE
		((claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		))
		OR
		(claim.originid <> 2))
		AND claim.regionid IS not NULL
		';
		//AND claim.causeid = 14
		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getCounters($filters){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT COUNT(state.id) claims, state.id stateid
		FROM claim
		INNER JOIN state ON claim.stateid = state.id
		WHERE
		((claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		))
		OR
		(claim.originid <> 2))
		
		';
		//AND claim.causeid = 14
		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		$query .= '
		GROUP BY state.id
		ORDER BY state.id
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function updateStreetLightsClaimData($claimId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'UPDATE street_lights_claims_data SET
		';

		if(isset($claimData['tulipa']) && $claimData['tulipa'] != null){
			$query .= '
			tulipa = ' . $claimData['tulipa'];
		}
		if(isset($claimData['portalampara']) && $claimData['portalampara'] != null){
			$query .= '
			,portalampara = ' . $claimData['portalampara'];
		}
		if(isset($claimData['canasto']) && $claimData['canasto'] != null){
			$query .= '
			,canasto = ' . $claimData['canasto'];
		}
		if(isset($claimData['fusible']) && $claimData['fusible'] != null){
			$query .= '
			,fusible = ' . $claimData['fusible'];
		}
		if(isset($claimData['lamp_125']) && $claimData['lamp_125'] != null){
			$query .= '
			,lamp_125 = ' . $claimData['lamp_125'];
		}
		if(isset($claimData['lamp_150']) && $claimData['lamp_150'] != null){
			$query .= '
			,lamp_150 = ' . $claimData['lamp_150'];
		}
		if(isset($claimData['lamp_250']) && $claimData['lamp_250'] != null){
			$query .= '
			,lamp_250 = ' . $claimData['lamp_250'];
		}
		if(isset($claimData['lamp_400']) && $claimData['lamp_400'] != null){
			$query .= '
			,lamp_400 = ' . $claimData['lamp_400'];
		}
		if(isset($claimData['ext_125']) && $claimData['ext_125'] != null){
			$query .= '
			,ext_125 = ' . $claimData['ext_125'];
		}
		if(isset($claimData['ext_150']) && $claimData['ext_150'] != null){
			$query .= '
			,ext_150 = ' . $claimData['ext_150'];
		}
		if(isset($claimData['ext_250']) && $claimData['ext_250'] != null){
			$query .= '
			,ext_250 = ' . $claimData['ext_250'];
		}
		if(isset($claimData['ext_400']) && $claimData['ext_400'] != null){
			$query .= '
			,ext_400 = ' . $claimData['ext_400'];
		}
		if(isset($claimData['int_125']) && $claimData['int_125'] != null){
			$query .= '
			,int_125 = ' . $claimData['int_125'];
		}
		if(isset($claimData['int_150']) && $claimData['int_150'] != null){
			$query .= '
			,int_150 = ' . $claimData['int_150'];
		}
		if(isset($claimData['int_250']) && $claimData['int_250'] != null){
			$query .= '
			,int_250 = ' . $claimData['int_250'];
		}
		if(isset($claimData['int_400']) && $claimData['int_400'] != null){
			$query .= '
			,int_400 = ' . $claimData['int_400'];
		}
		if(isset($claimData['morceto']) && $claimData['morceto'] != null){
			$query .= '
			,morceto = ' . $claimData['morceto'];
		}
		if(isset($claimData['espejo']) && $claimData['espejo'] != null){
			$query .= '
			,espejo = ' . $claimData['espejo'];
		}
		if(isset($claimData['columna']) && $claimData['columna'] != null){
			$query .= '
			,columna = ' . $claimData['columna'];
		}
		if(isset($claimData['atrio']) && $claimData['atrio'] != null){
			$query .= '
			,atrio = ' . $claimData['atrio'];
		}
		if(isset($claimData['neutro']) && $claimData['neutro'] != null){
			$query .= '
			,neutro = ' . $claimData['neutro'];
		}
		if(isset($claimData['cable']) && $claimData['cable'] != null){
			$query .= '
			,cable = ' . $claimData['cable'];
		}

		$query .= '
		WHERE claimid = ' . $claimId .'
		';

		self::$logger->error ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getRegions($locationId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM region
		WHERE locationid = ' . $locationId . '
		AND (region.id <> -1)
		ORDER BY name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getRegionById($regionId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT *
		FROM region
		WHERE id = ' . $regionId . '
		AND (region.id <> -1)
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getRegionsStats($dependencyId, $filters){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		state.id stateid,
		state.name statename,
		region.id regionid,
		region.name regionname,
		region.position,
		region.coordinates,
		count(stateid) total
		FROM claim
		LEFT JOIN state ON state.id = claim.stateid
		LEFT JOIN region ON region.id = claim.regionid AND (region.id <> -1)
		WHERE
		(
		(claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = \'5\'
		AND telepromclaim.lights <> 0)
		)
		OR
		(claim.originid <> 2)
		)
		
		AND claim.dependencyid = ' . $dependencyId . '

		';
		//AND claim.causeid = 14
		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		$query .= '
		GROUP BY region.id, regionname, state.id, statename, position
		ORDER BY regionid, stateid
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getStatsByRegion($regionId, $filters){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = '	SELECT count(*)
		FROM  claim
		WHERE claim.regionid = '.$regionId.'
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

	public static function getTelepromStats($dependencyId, $filters){

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'SELECT
		telepromclaim.datum,
		telepromcause.id causeid,
		telepromcause.name causename,
		COUNT(*) total
		FROM telepromclaim
		LEFT JOIN telepromcause ON telepromcause.id = telepromclaim.causeid
		INNER JOIN claim ON claim.id = telepromclaim.claimid
		WHERE claim.dependencyid = ' . $dependencyId . '
		';

		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {

				$query .= $filter->getCriteriaQuery ();
					
			}

		}

		$query .= '
		GROUP BY telepromclaim.datum, telepromcause.id, telepromcause.name
		ORDER BY telepromclaim.datum, telepromcause.name
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function insertPhoneDirectory($claimId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = 'INSERT INTO phone_directory_full(
		phone,
		name,
		surname,
		street,
		street_number,
		floor,
		apartment,
		zipcode,
		city,
		province,
		additional_address,
		category,
		phone_full,
		latitude,
		longitude,
		regionid
		) VALUES(
		\'' . $claimData ["requesterPhone"] . '\',
		\'' . $claimData ["requesterFullName"] . '\',
		\'\',
		\'' . $claimData ["street"] . '\',
		'. $claimData ["streetNumber"] .',
		null,
		null,
		5501,
		\'Godoy Cruz\',
		\'MENDOZA\',
		\'\',
		\'GDR MANUAL\',
		\'261' . $claimData ["requesterPhone"] . '\',
		null,
		null,
		null
		)
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrClaimCoords($filters) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		claim.id id,
		claim.code,
		claim.requesterphone,
		claim.requestername,
		claim.claimaddress,
		claim.entrydate,
		claim.closedate,
		claim.stateid,
		claim.latitude,
		claim.longitude,
		claim.assigned,
		inputtype.name inputtypename,
		subject.name subjectname,
		origin.name originname,
		dependency.name dependencyname,
		cause.name causename,
		state.name statename
		FROM claim
		INNER JOIN state on state.id = claim.stateid
		LEFT JOIN subject on subject.id = claim.subjectid
		INNER JOIN inputtype on inputtype.id = claim.inputtypeid
		INNER JOIN origin on origin.id = claim.originid
		LEFT JOIN cause on cause.id = claim.causeid
		LEFT JOIN dependency on dependency.id = claim.dependencyid
		LEFT JOIN claimsystemuseradr ON claimsystemuseradr.claimid = claim.id
		WHERE (
		(claim.originid = 2 AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = '5'
		)
		)
		OR
		(claim.originid <> 2)
		)
		
		AND claim.requesterphone IS NOT NULL
		AND claim.regionid IS NOT NULL
		AND claim.stateid != 4
		";
		//AND claim.causeid = 14
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

public static function getPublicClaimCoords($filters) {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT  
						claim.id id,
						claim.code,
						claim.entrydate,
						claim.stateid,
						claim.latitude,
						claim.closedate,
						claim.longitude
                                     	FROM claim
					INNER JOIN state on state.id = claim.stateid
					LEFT JOIN subject on subject.id = claim.subjectid
					INNER JOIN inputtype on inputtype.id = claim.inputtypeid
					INNER JOIN origin on origin.id = claim.originid
					LEFT JOIN cause on cause.id = claim.causeid
					LEFT JOIN dependency on dependency.id = claim.dependencyid
					LEFT JOIN claimsystemuseradr ON claimsystemuseradr.claimid = claim.id
					WHERE (
							(claim.originid = 2 AND EXISTS(
															SELECT 1
															FROM telepromclaim
															WHERE telepromclaim.claimid = claim.id
															AND telepromclaim.datum = '5'
														  )
						  )
						OR
						  (claim.originid <> 2)
					)
					
					AND claim.requesterphone IS NOT NULL
					AND claim.regionid IS NOT NULL
					AND claim.stateid = 1
					AND claim.entrydate > (now() - interval '1 month')		
                                       	";

		//AND claim.causeid = 14
/* AND (claim.stateid = 1 OR (claim.stateid in (2,3)  AND claim.closedate = current_date))
                                        AND claim.entrydate > (now() - interval '1 month')
*/
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
				
		self::$logger->debug ( __METHOD__ . ' end' );
				
		return $query;
		
	}

	public static function getPublicClaim($filters) {

                self::initializeSession ();

                self::$logger->debug ( __METHOD__ . ' begin' );

                $query = "SELECT
                                                claim.id id,
                                                claim.code,
                                                claim.entrydate,
                                                claim.stateid,
                                                claim.latitude,
						claim.closedate,
                                                claim.longitude
                                        FROM claim
                                        INNER JOIN state on state.id = claim.stateid
                                        LEFT JOIN subject on subject.id = claim.subjectid
                                        INNER JOIN inputtype on inputtype.id = claim.inputtypeid
                                        INNER JOIN origin on origin.id = claim.originid
                                        LEFT JOIN cause on cause.id = claim.causeid
                                        LEFT JOIN dependency on dependency.id = claim.dependencyid
                                        LEFT JOIN claimsystemuseradr ON claimsystemuseradr.claimid = claim.id
                                        WHERE (
                                                        (claim.originid = 2 AND EXISTS(
                                                                                                                        SELECT 1
                                                                                                                        FROM telepromclaim
                                                                                                                        WHERE telepromclaim.claimid = claim.id
                                                                                                                        AND telepromclaim.datum = '5'
                                                                                                                  )
                                                  )
                                                OR
                                                  (claim.originid <> 2)
                                        )
                                        
                                        AND claim.requesterphone IS NOT NULL
                                        AND claim.regionid IS NOT NULL
                                        AND claim.entrydate > (now() - interval '1 month')
				";

		//AND claim.causeid = 14

                 if (is_array ( $filters ) && count ( $filters ) > 0) {
                        foreach ( $filters as $filter ) {
                                $query .= $filter->getCriteriaQueryExact ();
                        }
                }

                self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

                self::$logger->debug ( __METHOD__ . ' end' );

                return $query;

        }

	public static function getAllStates($adrClaimStates, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		id,
		name
		FROM state
		WHERE 1=1
		";

		if (is_array ( $adrClaimStates ) && count ( $adrClaimStates ) > 0) {
			$values = '';
				
			foreach ($adrClaimStates as $key => $value) {

				$values .= $value;
				if($value != count($adrClaimStates)) {
					$values .= ", ";
				}

			}
			$query .= "AND id IN(".$values.")";
		}

		$query .= '
		ORDER BY id ' . $order . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAdrUnassignedClaimsCoords($groupId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		claim.id,
		claim.code,
		claim.claimaddress,
		claim.stateid,
		claim.entrydate,
		claim.latitude,
		claim.causeid,
		claim.longitude,
		claim.priority,
		claim.requestername,
		claim.requesterphone,
		claim.closedate,
		claim.assigned,
		claim.groupid,
		subject.name AS subjectname,
		inputtype.name AS inputtypename,
		cause.name AS causename,
		cause.icon AS icon,
		origin.name AS originname,
		dependency.name AS dependencyname,
		state.name AS statename

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
		(claim.originid <> ".claimsConcepts::CLAIMTYPETELEPROMID.")
		)
		
		AND claim.stateid = ".claimsConcepts::PENDINGSTATE."
		AND claimsystemuseradr.systemuseradrid IS NULL
		AND claim.regionid IS NOT NULL
		AND latitude IS NOT NULL AND longitude IS NOT NULL
		AND latitude <> '' AND longitude <> ''
		AND latitude !='' and longitude !=''
		";

		if($groupId!=null && $groupId != "undefined"){
			$query .= 'AND claim.groupid ='.$groupId;
		}
 //AND claim.causeid = ".claimsConcepts::ALUMBRADO_PUBLICO_CAUSE_ID."
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getAssignedClaimsForUser($filters,$groupId, $orderField) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		claim.id,
		claim.code,
		claim.claimaddress,
		claim.stateid,
		claim.priority,
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
		claim.requesterphone,
		claim.groupid
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
		(claim.originid <> ".claimsConcepts::CLAIMTYPETELEPROMID.")
		)
		
		AND claim.stateid = ".claimsConcepts::PENDINGSTATE."
		AND claim.regionid IS NOT NULL
		";

			if($groupId!=null && $groupId != "undefined"){
			$query .= 'AND claim.groupid ='.$groupId;
		}
     //AND claim.causeid = ".claimsConcepts::ALUMBRADO_PUBLICO_CAUSE_ID."
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		//order
		if($orderField!=null){
			$query .= 'ORDER BY '.$orderField.' ASC';
		}

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function getClaimsMapGroup() {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		c.id as id,
		c.code as code,
		c.latitude as latitude,
		c.longitude as longitude,
		c.groupid as groupid,
		g.icon as icon,
		g.name as namegroup
		FROM claim c
		LEFT JOIN claimgroup g ON g.id = c.groupid
		WHERE regionid IS NOT NULL and latitude !='' and longitude !=''
		";
		//claim.groupid IS NULL 
		//AND claim.stateid = ".claimsConcepts::PENDINGSTATE."
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	public static function getClaimByCode($filters, $order) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		claim.id AS id,
		claim.code AS code
		FROM claim
		INNER JOIN state on state.id = claim.stateid
		LEFT JOIN subject on subject.id = claim.subjectid
		INNER JOIN inputtype on inputtype.id = claim.inputtypeid
		INNER JOIN origin on origin.id = claim.originid
		LEFT JOIN cause on cause.id = claim.causeid
		LEFT JOIN dependency on dependency.id = claim.dependencyid
		WHERE (
		(claim.originid = ".claimsConcepts::CLAIMTYPETELEPROMID." AND EXISTS(
		SELECT 1
		FROM telepromclaim
		WHERE telepromclaim.claimid = claim.id
		AND telepromclaim.datum = '5'
		)
		)
		OR
		(claim.originid <> ".claimsConcepts::CLAIMTYPETELEPROMID.")
		)
		AND claim.requesterphone IS NOT NULL
		AND claim.regionid IS NOT NULL
		AND claim.stateid != ".claimsConcepts::CLOSEDSTATENOGEO."
		";

		//		AND claim.causeid = ".claimsConcepts::ALUMBRADO_PUBLICO_CAUSE_ID."


		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}

		$query .= '
		ORDER BY claim.code ' . $order . '
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	
	public static function getClaimsByGroup($groupId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT 
		claim.id AS id,
		claim.code AS code,
		claim.stateid,
		claim.substateid,
		claim.entrydate,
		claim.latitude,
		claim.longitude,
		claim.groupid
		FROM claim
		WHERE groupid=$groupId and stateid=1;
		";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	public static function getClaimsByUser($userId, $groupId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT
		claim.id AS id,
		claim.code AS code,
		claim.systemuserid,	
		claim.detail,
		claim.claimaddress,
		claim.stateid,
		claim.substateid,
		claim.entrydate,
		claim.latitude,
		claim.longitude
		listPlace
		FROM claim
		INNER JOIN claimsystemuseradr ON claimsystemuseradr.claimid = claim.id
		WHERE claimsystemuseradr.systemuseradrid = ".$userId."
		";
		
		if($groupId!=null && $groupId != "undefined"){
			$query .= 'AND claim.groupid ='.$groupId;
		}
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function unassignUserByClaims($claims) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimIds = '';
		for($i = 0; $i < count($claims); $i++) {
			$claimIds .= $claims[$i]['id'];
			if($i < (count($claims) - 1)) {
				$claimIds .= ', ';
			}
		}

		$query = "UPDATE claim
					SET systemuserid = null
					WHERE id IN(".$claimIds.") AND claim.stateid = ".claimsConcepts::PENDINGSTATE;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	public static function unassignGroupByClaims($claims) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimIds = '';
		for($i = 0; $i < count($claims); $i++) {
			$claimIds .= $claims[$i]['id'];
			if($i < (count($claims) - 1)) {
				$claimIds .= ', ';
			}
		}

		$query = "UPDATE claim
					SET groupid = null
					WHERE id IN(".$claimIds.") AND claim.stateid = ".claimsConcepts::PENDINGSTATE;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function assignClaimsToUser($userId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimIds = '';
		for($i = 0; $i < count($claimData); $i++) {
			$claimIds .= $claimData[$i];
			if($i < (count($claimData) - 1 )) {
				$claimIds .= ', ';
			}
		}

		$query = "UPDATE claim
					SET systemuserid = ".$userId."
					WHERE id IN(".$claimIds.")
		";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	public static function assignClaimsToGroup($groupId, $claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimIds = '';
		for($i = 0; $i < count($claimData); $i++) {
			$claimIds .= $claimData[$i];
			if($i < (count($claimData) - 1 )) {
				$claimIds .= ', ';
			}
		}

		$query = "UPDATE claim
					SET groupid = ".$groupId."
					WHERE id IN(".$claimIds.")
		";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function removeClaimFromList($claimData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$claimIds = '';
		for($i = 0; $i < count($claimData); $i++) {
			$claimIds .= $claimData[$i]['id'];
			if($i < (count($claimData) - 1 )) {
				$claimIds .= ', ';
			}
		}

		$query = "DELETE FROM claimsystemuseradr
		WHERE claimid IN(".$claimIds.")
		";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	public static function setListPlace($userId, $claimId, $placeNum) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "INSERT INTO claimsystemuseradr(
		systemuseradrid,
		claimid,
		listplace
		) VALUES(
		".$userId.",
		".$claimId.",
		".$placeNum."
		)";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}


	public static function setListPlaceForClaim($userId, $code) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );
		$placeNum = "(select COALESCE(max(listplace)+1,1) from claimsystemuseradr where systemuseradrid=".$userId.")";
		$claimId = "(select id from claim where code='".$code."')";

		$query = "INSERT INTO claimsystemuseradr(
		systemuseradrid,
		claimid,
		listplace
		) VALUES(
		".$userId.",
		".$claimId.",
		".$placeNum."
		)";

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

	/**
	 * Cambia el estado a un reclamo en particular
	 *
	 * @param int $claimId
	 * @param int $stateId
	 * @return string
	 */
	public static function changeStateClaim($claimId, $stateId) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );


		$dateQuery = '';
		if ($stateId == claimsConcepts::CLOSEDSTATE || $stateId == claimsConcepts::CLOSEDSTATENOGEO) {
			$dateQuery = ', closedate = \'' . date ( "Y-m-d" ) . '\'';
		}

		if($stateId == claimsConcepts::CLOSEDSTATENOGEO) {
			$regionQuery = ', regionid = -1';
		}
			
		$query = 'UPDATE claim
		SET stateid = ' . $stateId . '
		' . $dateQuery .'
		' . $regionQuery.'
		WHERE id = ' . $claimId ;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	

	public static function getAllClaimStreet($filters, $order){
	
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT DISTINCT map_city.street FROM map_city WHERE type = '."'".claimsConcepts::CLAIM_STREET_NUMBER."'";
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		$query .=' AND number is not null';
		$query .= ' ORDER BY map_city.street '.$order;
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	public static function getAllNumberStreet($filters, $order){
	
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT DISTINCT map_city.number FROM map_city WHERE type = '."'".claimsConcepts::CLAIM_STREET_NUMBER."'";
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		$query .= ' ORDER BY map_city.number '.$order;
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	public static function getAllDistrict($filters, $order){
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT DISTINCT map_city.district FROM map_city WHERE type = '."'".claimsConcepts::CLAIM_DISTRICT_BLOCK_HOUSE."'";
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
	
		$query .= ' ORDER BY map_city.district '.$order;
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	public static function getAllBlockDistrict($filters, $order){
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT DISTINCT map_city.block FROM map_city WHERE type = '."'".claimsConcepts::CLAIM_DISTRICT_BLOCK_HOUSE."'";
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
	
		$query .= ' ORDER BY map_city.block '.$order;
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	public static function getAllHomeBlock($filters, $order){
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT DISTINCT map_city.home FROM map_city WHERE type = '."'".claimsConcepts::CLAIM_DISTRICT_BLOCK_HOUSE."'";
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
	
		$query .= ' ORDER BY map_city.home '.$order;
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	public static function getLatLong($filters){
	
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT map_city.id, map_city.latitude, map_city.longitude FROM map_city WHERE 1=1 ';
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	public static function getTypeAddress($filters){
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT * FROM map_city WHERE 1=1 ';
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			foreach ( $filters as $filter ) {
				$query .= $filter->getCriteriaQuery ();
			}
		}
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	
	}
	public static function getCountMapCity(){
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT count(*) FROM map_city';
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	public static function getTypeAddressConceptById($id){
		self::initializeSession();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT type from map_city WHERE id='.$id;
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;		
	}
	
	public static function getTypeAddressById($id){
		self::initializeSession();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$query = 'SELECT * from map_city WHERE id='.$id;		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;	
		
	}
	
	public static function getMaterialsByClaim($id){
		
		self::initializeSession();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT 
							materialldr.id,
							materialldr.name,
							materialldr.description
					 FROM 
							claimclosureldr 
					 INNER JOIN 
							claimclosureldr_materialldr 
					 ON 
							claimclosureldr.id = claimclosureldr_materialldr.claimclosureldrid
					 INNER JOIN 
							materialldr 
					  ON 
							claimclosureldr_materialldr.materialldrid = materialldr.id
					 WHERE 
							claimclosureldr.claimid ='.$id;
				
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;	
				
	}
	
	public static function getWithoutFixingByClaim($id){
		
		self::initializeSession();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT 
							withoutfixingldr.id,
							withoutfixingldr.name,
							withoutfixingldr.description
					  FROM 
							withoutfixingldr
					  INNER JOIN 
							claimclosureldr 
					  ON 
							withoutfixingldr.id = claimclosureldr.withoutfixingldrid	
					  WHERE claimid  ='.$id;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
				
	}
	
	public static function getClosedDescription($id){
		self::initializeSession();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT 
				  	description  
				  FROM 
					claimclosureldr 
				  WHERE 
				  	claimid = '.$id.
				  	' LIMIT 1';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
		
	}

	public static function getClaimPic($id) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query ='SELECT id,claim_id,convert_from(photo::bytea, \'UTF8\')
		FROM claim_pic
		WHERE claim_id = '.$id.'
		';

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}
	
}
