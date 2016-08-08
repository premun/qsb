<?php

class cPage {
	function cPage($name) {
		global $err;
		
		$this->fill_data = array();
		$this->fill_data['skindir'] = './skin/';
		
		@$this->obsah = file_get_contents('./skin/pages/'.$name.'.tpl');
		if(!$this->obsah) @$this->obsah = file_get_contents('./skin/'.$name.'.tpl');
		
		if(!$this->obsah) {
			$err->add('Prazdny nebo nenalezeny soubor '.$name.'.tpl','page');
			return false;
		}
		$this->main = $this->get('MAIN',$this->obsah);
	}
	
	function get($co,$kde) {
		if(ereg('\{'.strtoupper(addslashes($co)).'\}(.)+\{\:\:'.$co.'\}',$kde,$found)) {
			$f = $this->removeTags($co,$found[0]);
			return $f;
		} else {
			if(strtoupper($co) == 'MAIN') {
				return $this->obsah;
			}
			return false;
		}
	}
	
	function getTables() {
		while(strpos($this->obsah,'{TABLE',$offset)) {
			$start = strpos($this->obsah,'{TABLE',$offset);
			$end = strpos($this->obsah,'}',$start);
			$name = substr($this->obsah,$start+7,$end-$start-7);
			$end2 = strpos($this->obsah,'{::TABLE}',$end);
			$obsah = substr($this->obsah,$start+8+strlen($name),$end2-$start-8-strlen($name));
			
			$start2 = strpos($this->obsah,'{ROW}',$end);
			$end3 = strpos($this->obsah,'{::ROW}',$start2);
			$row = substr($this->obsah,$start2+5,$end3-$start2-5);
			
			$obsah = substr($obsah,0,strpos($obsah,'{ROW}')).'{LINES}'.substr($obsah,strpos($obsah,'{::ROW}')+7);
			
			$tables[$name]['obsah'] = $obsah;
			$tables[$name]['row'] = $row;
			
			$offset = $end2+9;			
		}
				
		$this->tables = $tables;
	}
	
	function getTable($name,$data) {
		if(!is_array($this->tables)) $this->getTables();
	
		$table = $this->tables[$name];
		$obsah = $table['obsah'];
		$line = $table['row'];
		
		if(!is_resource($data) && !is_array($data)) {
			if($args[2]) {
				$this->swap($args[2],'');
			}			
			return '';
		}
		
		if(is_resource($data)) {
			for($i=0;$i<p($data);$i++) {
				$row = fa($data);
				$data2[] = $row;
			}
			$data = $data2;
		}
		
		if(is_array($data)) {
			foreach($data as $row) {
				$radka = $line;
				foreach($row as $tag=>$val) {
					$radka = str_replace('{'.strtoupper($tag).'}',$val,$radka);
				}
				$lines .= $radka;
			}		
		}
		$obsah = str_replace('{LINES}',$lines,$obsah);
		
		$args = func_get_args();
		
		if($args[2]) {
			$this->swap($args[2],$obsah);
		}
		
		return $obsah;
	}

	function ext($name) {
		if(!is_array($this->ext)) $this->getExceptions();
		
		$args = func_get_args();
		
		if($args[2]) do_header($args[2]);
		
		$this->main = (jhadr() ? '' : $this->ext['COMMON']).$this->ext[$name];
		
		if(is_array($args[3])) {
			$this->fill($args[3]);
		}
		
		if(jhadr()) {
			if(count($this->fill_data)) $this->fill($this->fill_data);
			return $this->main;
		}
		
		$this->finish();
		
		if($args[1]) do_footer();
		
	}

	function misc($name) {
		if(!is_array($this->misc)) $this->getMiscs();
		
		$args = func_get_args();
		
		$misc = $this->misc[$name];
		
		if(is_array($args[2])) {
			foreach($args[2] as $co=>$cim) {
				$misc = str_replace('{'.strtoupper($co).'}',$cim,$misc);
			}
		}
		
		if($args[1]) {
			$this->swap($args[1],$misc);
		}
		
		return $misc;
	}

	function getExceptions() {
		$offset = 0;
		
		while(strpos($this->obsah,'{EXT',$offset)) {
			$start = strpos($this->obsah,'{EXT',$offset);
			$end = strpos($this->obsah,'}',$start);
			$name = substr($this->obsah,$start+5,$end-$start-5);
			$end2 = strpos($this->obsah,'{::EXT}',$end);
			$obsah = substr($this->obsah,$start+6+strlen($name),$end2-$start-6-strlen($name));
			$offset = $end2+7;
			
			$exts[$name] = $obsah;
		}
		$this->ext = $exts;
	}

	function getMiscs() {
		$offset = 0;
		
		while(strpos($this->obsah,'{MISC',$offset)) {
			$start = strpos($this->obsah,'{MISC',$offset);
			$end = strpos($this->obsah,'}',$start);
			$name = substr($this->obsah,$start+6,$end-$start-6);
			$end2 = strpos($this->obsah,'{::MISC}',$end);
			$obsah = substr($this->obsah,$start+7+strlen($name),$end2-$start-7-strlen($name));
			$offset = $end2+7;
			
			$miscs[$name] = $obsah;
		}
		$this->misc = $miscs;
	}
	
	function setCommon($name) {
		if(!is_array($this->ext)) $this->getExceptions();
		$this->ext['COMMON'] = $this->ext[strtoupper($name)];
		if(strtoupper($name) == 'MAIN' && !isset($this->ext['MAIN'])) $this->ext['COMMON'] = $this->main;
	}
	
	function append($name) {
		@$obsah = file_get_contents('./skin/pages/'.$name.'.tpl');
		if(!$obsah) @$obsah = file_get_contents($this->skindir.$name.'.tpl');
		if(!$obsah) {
			//$err->add('Prazdny nebo nenalezeny soubor '.$name.'.tpl','page');
			return false;
		}
		$this->obsah .= $obsah;
		
		$com = $this->ext['COMMON'];
		
		if(is_array($this->ext)) $this->getExceptions();
		if(is_array($this->misc)) $this->getMiscs();
		if(is_array($this->tables)) $this->getTables();
		
		$this->ext['COMMON'] = $com;
	}
	
	function fill($data) {
		foreach($data as $tag=>$val) $this->main = str_replace('{'.strtoupper($tag).'}',$val,$this->main);
	}
	
	function fa($key, $value) {
		$this->fill_data[$key] = $value;
	}
	
	function removeTags($tag,$kde) {
		$obsah = str_replace('{'.$tag.'}','',$kde);
		$obsah = str_replace('{::'.$tag.'}','',$obsah);
		return $obsah;
	}
	
	function swap($co,$cim) {
		$this->main = str_replace('{'.$co.'}',$cim,$this->main);
	}
	
	function finish() {
		if(count($this->fill_data)) $this->fill($this->fill_data);
		
		if(jhadr()) return $this->main;
			
		echo $this->main;
	}

}
?>
