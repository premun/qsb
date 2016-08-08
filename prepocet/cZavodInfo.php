<?php

class cZavodInfo {
	function cZavodInfo($zavod) {
		$this->cas = 0;
		$this->ticks = 0;
		
		$this->hraci = $zavod->hraci;
		$this->data = array();
		
		$this->poradi = array();
		$this->vzdalenosti = array();
		$this->udalosti = array();
		$this->rychlosti = array();
		$this->casy = array();
		
		# zaloha kluzaku
		foreach($this->hraci as $hrac) {
			$this->rychlosti[$hrac->id][0] = 0;
			//$this->data['kluzaky'][$hrac->id] = clone $hrac->kluzak;
			//$this->data['prestiz_start'][$hrac->id] = $hrac->prestiz;
		}
	}
	
	function tick($zavod) {
		$this->cas += TICK;
		
		$this->casy[$this->ticks] = $this->cas;
		
		$this->poradi[$this->cas] = $zavod->poradi;	
		
		foreach($zavod->hraci as $hrac) {
			if(!$hrac->kluzak->ok_zavod) continue;
			if($hrac->dojel) continue;
			$this->vzdalenosti[$hrac->id][$this->ticks] = round($hrac->vzdalenost,2);
			$this->rychlosti[$hrac->id][$this->ticks] = round($hrac->rychlost);
		}
		
		$this->ticks++;
	}
	
	function udalost($usek, $hrac, $type) {
		$args = func_get_args();
		array_shift($args);
		array_shift($args);
		array_shift($args);
	
		$this->udalosti[] = new cZavodEvent($this->ticks, $usek, $hrac, $type, $args);
	}
	
	function fatal($fatal = true) {
		$this->udalosti[count($this->udalosti)-1]->fatal = $fatal;
	}
	
	function fatal1($fatal = true) {
		$this->udalosti[count($this->udalosti)-1]->fatal1 = $fatal;
	}
	
	function fatal2($fatal = true) {
		$this->udalosti[count($this->udalosti)-1]->fatal2 = $fatal;
	}
	
	function hracInfo($uid) {
		$data = array();
		
		$info = 'dmg,skody,uhyby,vyvolane,nevyvolane,vyrazeni';
		
		foreach(explode(',',$info) as $name) 
			$data[$name] = 0;
		
		foreach($this->udalosti as $udalost) {
			if($udalost->login != $uid && $udalost->login2 != $uid) continue;
			
			switch($udalost->type) {
				case 'souboj':
					if($udalost->login2 == $uid) {
						$data['dmg'] += $udalost->dmg2;
						$data['skody'] += $udalost->dmg1;
						$data['nevyvolane']++;
						
						if($udalost->fatal1) $data['vyrazeni']++;
					} else {
						$data['dmg'] += $udalost->dmg1;
						$data['skody'] += $udalost->dmg2;
						$data['vyvolane']++;
						
						if($udalost->fatal2) $data['vyrazeni']++;
					}					
					break;
					
				case 'uhyb':
					if($udalost->login2 == $uid) {
						$data['uhyby']++;
						$data['nevyvolane']++;
					} else {
						$data['skody'] += $udalost->skody + $udalost->pancerovani;
						$data['vyvolane']++;
					}
					break;
					
				case 'chlazeni':
					$data['skody'] += $udalost->skody + $udalost->skody_chladic;
					break;
					
				case 'crash':
					$data['skody'] += $udalost->skody + $udalost->pancerovani;
					break;
			}
		}
		
		return $data;
	}
	
	public function __sleep() {		
		return array('poradi','casy','vzdalenosti','udalosti','rychlosti');
	}
}
?>