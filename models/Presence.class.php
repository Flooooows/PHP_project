<?php
class Presence{
	private $_courseName;
	private $_sessionName;
	private $_type;
  private $_presence;
  private $_startDate;
	public function __construct($courseName,$sessionName,$type,$presence,$startDate){
		$this->_courseName = $courseName;
		$this->_sessionName = $sessionName;
		$this->_type = $type;
		$this->_presence = $presence;
		$this->_startDate = $startDate;
	}

	public function courseName(){
		return $this->_courseName;
	}

	public function sessionName(){
		return $this->_sessionName;
	}

	public function type(){
		return $this->_type;
	}

	public function presence(){
		return $this->_presence;
	}

	public function startDate(){
		return $this->_startDate;
	}

}
?>
