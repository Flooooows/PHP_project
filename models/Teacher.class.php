<?php
class Teacher{
	private $_email;
	private $_name;
	private $_firstName;
	private $_responsability;

	public function __construct($email,$name,$firstName,$responsability){
		$this->_email = $email;
		$this->_name = $name;
		$this->_firstName = $firstName;
		$this->_responsability = $responsability;
	}

	public function email(){
		return $this->_email;
	}


	public function name(){
		return $this->_name;
	}

	public function firstName(){
		return $this->_firstName;
	}

	public function responsability(){
		return $this->_responsability;
	}
}
?>
