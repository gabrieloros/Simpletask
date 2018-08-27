<?php
class Cause {

	/**
	 * Cause id
	 * @var int
	 */
	private $id;
	
	/**
	 * Cause name
	 * @var string
	 */
	private $name;
	
	/**
	 * Cause subjectId
	 * @var int
	 */
	private $subjectId;


	private $icon;
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $subjectId
	 */
	public function getSubjectId() {
		return $this->subjectId;
	}
	
	/**
	 * @param int $subjectId
	 */
	public function setSubjectId($subjectId) {
		$this->subjectId = $subjectId;
	}

	/**
	 * @return mixed
	 */
	public function getIcon()
	{
		return $this->icon;
	}

	/**
	 * @param mixed $icon
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;
	}
	
}
?>