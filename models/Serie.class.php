<?php
class Serie{
	private $_serieNum;
	private $_block;

	public function __construct($serieNum,$block){
		$this->_serieNum = $serieNum;
		$this->_block = $block;
	}

	public function serieNum(){
		return $this->_serieNum;
	}

	public function block(){
		return $this->_block;
	}

}
?>
