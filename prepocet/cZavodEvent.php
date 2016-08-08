<?php

/*
CRASH:
	usek, login, typ, predmet, pancerovani, skody
CHLAZENI:
	usek, login, typ, predmet, skody_chlazeni, skody
*/

class cZavodEvent {
	function cZavodEvent($ticks, $usek, $login, $type, $data) {
		$this->type = $type;
		$this->usek = $usek;
		$this->login = $login;
		$this->cas = $ticks;
		
		$this->process($data);
	}
	
	function process($data) {
		$null = 'login2,skody,dmg1,dmg2,predmet,pancerovani,skody_chladic';
		
		foreach(explode(',',$null) as $var) 
			$this->{$var} = 0;
		
		$this->fatal = false;

		switch($this->type) {
			case 'chlazeni':
				$this->predmet = $data[0];
				$this->skody_chladic = $data[1];
				$this->skody = $data[2];
				break;
				
			case 'crash':
				$this->predmet = $data[0];
				$this->skody = $data[1];
				$this->pancerovani = $data[2];
				$this->zpomaleni = $data[3];
				break;
				
			case 'uhyb':
				$this->login2 = $data[0];
				$this->predmet = $data[1];
				$this->skody = $data[2];
				$this->pancerovani = $data[3];	
				$this->zpomaleni = $data[4];
				break;
				
			case 'souboj':
				$this->login2 = $data[0];
				$this->dmg1 = $data[1];
				$this->dmg2 = $data[2];
				$this->predmety1 = $data[3];
				$this->predmety2 = $data[4];
				$this->zpomaleni1 = $data[5];
				$this->zpomaleni2 = $data[6];
				break;			
		}
	}
}
?>