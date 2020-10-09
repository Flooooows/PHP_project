<?php
class Course{
	private $_name;
	private $_code;
	private $_term;
	private $_ueAa;
	private $_ects;
	private $_abbreviation;

	public function __construct($name,$code,$term,$ueAa,$ects,$abbreviation){
		$this->_name = $name;
		$this->_code = $code;
		$this->_term = $term;
		$this->_ueAa = $ueAa;
		$this->_ects = $ects;
		$this->_abbreviation = $abbreviation;
	}

	public function name(){
		return $this->_name;
	}

	public function code(){
		return $this->_code;
	}

	public function term(){
		return $this->_term;
	}

	public function ueAa(){
		return $this->_ueAa;
	}

	public function ects(){
		return $this->_ects;
	}

	public function abbreviation(){
		return $this->_abbreviation;
	}
}
?>
