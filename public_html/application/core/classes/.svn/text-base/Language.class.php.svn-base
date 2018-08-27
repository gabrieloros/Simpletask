<?php
/**
 * Language class
 * @author Gabriel Guzmán
 *
 */
class Language {

    /**
     * Language ISO code
     * @var string
     */
    private $iso;
    
    /**
     * Language name
     * @var string
     */
    private $name;
    
    /**
     * Language id
     * @var int
     */
    private $id;
	

    /**
     * Create a new language
     *
     * @param  mixed $name Language name
     * @param  mixed $iso Language ISO code
     * @param  int $languageId Language pfwid
     *
     * @return Language the new language
     */
    public function __construct($name, $iso, $id){
        
    	$this->name = $name;
        
        $this->iso = $iso;
        
        $this->id = $id;
              
    }

    /**
	 * @return the $iso
	 */
	public function getIso() {
		return $this->iso;
	}

	/**
	 * @param string $iso
	 */
	public function setIso($iso) {
		$this->iso = $iso;
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

}