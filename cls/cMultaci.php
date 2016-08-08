<?php

class cMultaci {
	function cMultaci() {
		$this->data = array();
		$this->init();	
	}
	
	function init() {
		$obsah = file_get_contents('vypisy/multaci.txt');
		
		if($data = unserialize($obsah)) {
			$this->data = $data;
		}
	}
	
	function compare($id, $login, $ip) {
		if(!count($this->data))
			return $this->check($id, $login, $ip);

		$ips = array_keys($this->data);
		if(!in_array($ip, $ips)) 
			return $this->check($id, $login, $ip);
		
		if(!isset($this->data[$ip][$id])) {
			$this->data[$ip][$id] = array();
			$this->data[$ip]['nicky'][$id] = $login;
		}
		
		$this->data[$ip][$id][] = time();
		
		$this->save();
		return true;
	}
	
	function check($id, $login, $ip) {
		global $Sql;
	
		$result = $Sql->q('SELECT id, login, cas FROM hraci WHERE IP = "'.$_SERVER['REMOTE_ADDR'].'" AND id != '.$id.' AND status != -2 AND status != 42');
		if(!p($result)) return false;

		$this->data[$ip]['nicky'][$id] = $login;
		$this->data[$ip][$id][] = time();
		
		for($i=0;$i<p($result);$i++) {
			$hrac = fa($result);
			$this->data[$ip][$hrac['id']][] = $hrac['cas'];
			$this->data[$ip]['nicky'][$hrac['id']] = $hrac['login'];
		}
		
		$this->save();
		
		return true;
	}
	
	function save() {
		$fp = fopen('vypisy/multaci.txt','w');
		fwrite($fp,serialize($this->data));
		fclose($fp);
	}
}
?>