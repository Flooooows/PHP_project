<?php
class PresenceSheet{
	private $_id;
	private $_idSession;
  private $_teachMail;
  private $_idWeek;

	public function __construct($id,$idSession,$teachMail,$idWeek){
		$this->_id = $id;
		$this->_idSession = $idSession;
		$this->_teachMail = $teachMail;
		$this->_idWeek = $idWeek;
	}

	public function id(){
		return $this->_id;
	}

	public function idSession(){
		return $this->_idSession;
	}

	public function teachMail(){
		return $this->_teachMail;
	}

	public function idWeek(){
		return $this->_idWeek;
	}
}
?>
