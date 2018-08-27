<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimPicDB.class.php');
/**
 * Created by PhpStorm.
 * User: Equipo 1
 * Date: 17/05/2017
 * Time: 03:08 PM
 */
class ClaimPic
{


    private $id;

    private $claim_id;

    private $photo;

   

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getClaimId()
    {
        return $this->claim_id;
    }

    /**
     * @param mixed $claim_id
     */
    public function setClaimId($claim_id)
    {
        $this->claim_id = $claim_id;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    
    

    
}