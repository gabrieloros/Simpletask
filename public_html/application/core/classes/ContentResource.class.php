<?php
/**
 * ContentResource.class.php
 *
 * @package core.classes
 * @author Gabriel Guzman
 * DATE OF CREATION: 16/03/2012
 * PURPOSE: Site object implementation
 * 
 */
class ContentResource {
	
	/**
	 * Content resource id
	 * @var int
	 */
	private $id;
	
	/**
	 * Content Resource title
	 * @var string
	 */
	private $title;
	
	/**
	 * Content resource text
	 * @var string
	 */
	private $text;
	
	/**
	 * Build site instance
	 * @param int $id pfwid
	 * @param string $title
	 * @param string $text
	 */
	public function __construct($id, $title, $text) {
		
		$this->setId ( $id );
		
		$this->setTitle ( $title );
		
		$this->setText ( $text );
		
	}
	
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
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return the $text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @param string $text
	 */
	public function setText($text) {
		$this->text = $text;
	}

}