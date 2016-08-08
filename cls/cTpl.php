<?
global $obsah;
global $dir;

class cTpl {
	function cTpl() {
		$this->dir = './skin/';
	}
	
	function load($fName) {
		global $err;
	
		$_SESSION['tpl']++;
		if(file_exists($this->dir . $fName . '.tpl')) {
			return file_get_contents($this->dir . $fName . '.tpl'); 
		} else {
			$err->add($this->dir . $fName . '.tpl neexistuje','tpl');
		}
	}

	function replace($co, $cim, $kde) {
		return str_replace('{'.$co.'}', $cim, $kde);
	}
	
	function vypis($obsah) {
		$this->obsah = $this->replace('SKINDIR', $this->dir, $obsah);
		echo $this->obsah;
	}

}
?>
