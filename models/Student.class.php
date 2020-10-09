<?php
class Student{
	private $_email;
	private $_serieNum;
	private $_name;
	private $_firstName;
	private $_block;

	public function __construct($email,$serieNum,$name,$firstName,$block){
		$this->_email = $email;
		$this->_serieNum = $serieNum;
		$this->_name = $name;
		$this->_firstName = $firstName;
		$this->_block = $block;
	}

	public function email(){
		return $this->_email;
	}
	
	public function serieNum(){
		return $this->_serieNum;
	}
	
	public function name(){
		return $this->_name;
	}

	public function firstName(){
		return $this->_firstName;
	}

	public function block(){
		return $this->_block;
	}
}
?>
