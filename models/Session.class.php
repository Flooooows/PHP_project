<?php
class Session{
	private $_id;
	private $_code;
	private $_sessionName;
	private $_type;

	public function __construct($id,$code,$sessionName,$type){
		$this->_id = $id;
		$this->_code = $code;
		$this->_sessionName = $sessionName;
		$this->_type = $type;
	}

	public function id(){
		return $this->_id;
	}


	public function code(){
		return $this->_code;
	}

	public function sessionName(){
		return $this->_sessionName;
	}

	public function type(){
		return $this->_type;
	}
}
?>
