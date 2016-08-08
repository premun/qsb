<?php

class cTimer {
	function cTimer() {
		$this->starttime();
	}
	
	function getmicrotime() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}   
	
	function starttime() {
		$this->st = $this->getmicrotime();
	}
	
	function displaytime() {
		$this->et = $this->getmicrotime();
		return round(($this->et - $this->st), 4);
	}
}
?>
