<?php

class cReg {
	function cReg($typ) {
		$typy['JMENO'] = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ ]+$';
		$typy['POPIS'] = '^[A-Za-z0-9_ěščřžýáíéďťňúůóĚŠČŘŽÝÁÍÉĎŤŇÚŮÓ\-\.\,\+\%\$\#\@\!\?\^\*\(\)\}\{\  ]+$';
		$typy['LOGIN'] = '^[A-Za-z0-9_]+$';
		$typy['HESLO'] = '^[A-Za-z0-9_]+$';
		$typy['ICQ'] = '^[0-9]{9}$';
		$typy['EMAIL'] = '^[_a-zA-Z0-9+\-\.]+@[_a-zA-Z0-9+\-]+(\.)[a-zA-Z]{2,4}$';
		$typy['HEXADECIMAL'] = '^(#)([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$';
		$typy['NUMERIC'] = '^[0-9]+$';
		
		$this->typy = $typy;
		$this->reg = $typy[$typ];
		$this->typ = $typ;
	}
	
	function test($co) {
		if(ereg($this->reg,$co)) return true; else return false;
	}
	
	function invalid($co) {
		$chars = '';
		if(!ereg($this->reg,$co)) {
			for($i=0;$i<strlen($co);$i++) {
				if(!ereg(substr($this->reg,1,strlen($this->reg)-2),substr($co,$i,1)) && !ereg(substr($co,$i,1),$chars)) $chars .= substr($co,$i,1);
			}
		}
		return $chars;
	}
	
	function change($typ) {
		$this->reg = $this->typy[$typ];
		$this->typ = $typ;	
	}
}
?>