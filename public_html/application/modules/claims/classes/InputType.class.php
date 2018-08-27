<?php 

class InputType {

	/**
	 * InputType id
	 * @var int
	 */
	private $id;

	/**
	 * InputType name
	 * @var string
	 */
	private $name;

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
}
?>
