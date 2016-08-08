<?php

class cDialog {	

	function cDialog($title,$type,$options='') {
		$this->data = array();
		$this->type = $type;
		
		$this->set('title',$title);
		
		if($this->type == 'location') $this->url = $title;
		
		if($options) {		
			foreach($options = explode(',',$options) as $option) {
				$kusy = explode(':',$option);
				$this->set(trim($kusy[0]), trim($kusy[1]));
			}
		}
	}
	
	function output() {
		$this->set('buttons', $this->buttons);
	
		if($this->type == 'location') {
			$this->data = array();
			$this->set('goto', $this->url);
		}
	
		if($this->type == 'submit') {
			$this->data = array();
			$this->set('submit_form', $this->url);
		}
		
		if(!jhadr()) return '';
		
		unset($_SESSION['chyba']);
		
		die(json_encode($this->data));
	}
	
	function set($name,$value) {
		$this->data[$name] = $value;
	}
	
	function body($value) {
		$this->set('html',$value);
	}
	
	function obody($value) {
		if($this->is_empty()) $this->set('html',$value);
	}
	
	function title($value) {
		$this->set('title',$value);
	}
	
	function type($type, $optional = '') {		
		if(($type == 'submit' || $type == 'location') && $optional != '') $this->url = $optional;
		
		$this->type = $type;
	}
	
	function button($name, $type, $func = '') {		
		$button['type'] = $type;
		$button['name'] = $name;	
		$button['func'] = $func;
		
		$this->buttons[] = $button;	
	}
	
	function is_empty() {
		if($this->data['html'] == "") return true;
		
		return false;
	}
}

function jhadr() {
	if(REQUEST_METHOD == "JHADR") return true;

	if($_POST['request_method'] == 'jhadr') {
		define("REQUEST_METHOD","JHADR");
		return true;
	}
	return false;
}
?>