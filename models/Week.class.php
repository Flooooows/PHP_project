<?php
class Week{
	private $_id;
	private $_startdate;
  private $_term;

	public function __construct($id,$startdate,$term){
		$this->_id = $id;
		$this->_startdate = $startdate;
		$this->_term = $term;
	}

	public function id(){
		return $this->_id;
	}

	public function startdate(){
		return $this->_startdate;
	}

	public function term(){
		return $this->_term;
	}
}
?>
