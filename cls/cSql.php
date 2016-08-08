<?php

class cSql {

	function cSql($server, $login, $heslo, $db) {
		global $err;
		
		@$this->cnnct = mysql_connect($server, $login, $heslo);
			if(!$this->cnnct) {                                                    
			db_down();
			$err->add('Mysql connection failed','sql');
			exit;
		}
		
		$this->database = mysql_select_db($db, $this->cnnct);
		@mysql_query("SET NAMES utf8");
		@mysql_query("SET CHARACTER SET utf8");
		$this->server = $server;
		$this->login = $login;
		$this->db = $db;
		$this->heslo = $heslo;
		$_SESSION['sql'] = 0;
	}
	
	function q($dotaz) {
		global $err;
		
		$_SESSION['sql']++;
		$this->last = $dotaz;
		$this->result = mysql_query($dotaz, $this->cnnct);
		if($this->result) {
			return $this->result;
		} else {
			$err->add($dotaz,'sql');
			return false;
		}
	}

}

function fa($res) {
	if(!$res) return false;
	return mysql_fetch_assoc($res);
}

function fo($res) {
	if(!$res) return false;
	return mysql_fetch_object($res);
}

function p($res) {
	if(!$res) return false;
	return mysql_num_rows($res);
}

function a($res) {
	if(!$res) return false;
	return mysql_affected_rows($res);
}

function vars($res) {
	if(!$res) return false;
	$row = mysql_fetch_assoc($res);
	foreach($row as $key=>$val) {
		global ${$key};
		${$key} = $val;
	}
}

?>