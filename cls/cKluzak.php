<?php

class cKluzak {

	var $ok_zavod = true; 					# jestli kluzak smi do zavodu
	var $prehrati = 0;
	var $vaha,$rychlost,$nosnost = 0;
	
	function cKluzak($p) { 					# __construct priradi $this->casti idcka veci, $p == UID
		$this->setTabs();
		$this->login = $p;					# UID
		
		if(func_num_args() > 1) {			# simluace
			$args = func_get_args();
			$this->getCasti($args[1]);		# dostane ze skladu casti kluzaku
		} else {
			$this->getCasti();				
		}
		
		$this->fetchParts($this->casti);	# prida promenny z $this->casti a zjisti o kazdy soucastcce vlastnosti
		$this->setVydrze();					# odlisi max_vydrz a vydrz
		$this->checkParts(); 				# zkontroluje, jestli ma hrac vsechny potrebny predmety v kluzaku a kdyztak vyhodi hlasku
		
		$this->getVaha();					# zkontroluje nosnost/vahu a kdyztak vyhodi hlasku
		
		$this->getRychlost(); 				# dostane max. rychlost a nastavi $this->rychlost
		$this->getOvladat(); 				# nastavi $this->ovladatelnost
		$this->getOdolnost(); 				# nastavi $this->odolnost
		$this->getZrychleni();				# nastavi $this->zrychleni
		$this->getChlazeni();				# nastavi $this->chlazeni
		$this->checkChlazeni();				# zjisti, jestli je chladic dost silnej
		$this->getSpotreba();				# nastavi $this->spotreba !!!!!!! ZDROJ a ne spotreba motoru
		
		if($this->vaha > $this->podvozek['nosnost']) $this->prevazeni();
	}
	
	function setTabs() {
		$tabs[1] = "podvozek";
		$tabs[2] = "motor";
		$tabs[3] = "drzaky";
		$tabs[4] = "chladic";
		$tabs[5] = "deska";
		$tabs[6] = "brzdy";
		$tabs[7] = "zdroj";
		$tabs[8] = "pancerovani";
		$tabs[9] = "suspenzory";
		$tabs[10] = "p_motory";
		
		$this->tabs = $tabs; 
		
		$tabs2[1] = "podvozky";
		$tabs2[2] = "motory";
		$tabs2[3] = "drzaky";
		$tabs2[4] = "chladice";
		$tabs2[5] = "desky";
		$tabs2[6] = "brzdy";
		$tabs2[7] = "zdroje";
		$tabs2[8] = "pancerovani";
		$tabs2[9] = "suspenzory";
		$tabs2[10] = "p_motory";
		
		$this->tabs2 = $tabs2;
		
		$kategorie[1] = "Podvozky";
		$kategorie[2] = "Motory";
		$kategorie[3] = "Energodržáky";
		$kategorie[4] = "Chladiče";
		$kategorie[5] = "Palubní desky";
		$kategorie[6] = "Brzdy";
		$kategorie[7] = "Zdroje";
		$kategorie[8] = "Pancéřování";
		$kategorie[9] = "Suspenzory";
		$kategorie[10] = "Přídavné motory";
		
		$this->katz = $kategorie;
		
		$kategorie[1] = "Podvozek";
		$kategorie[2] = "Motor";
		$kategorie[3] = "Energodržáky";
		$kategorie[4] = "Chladič";
		$kategorie[5] = "Palubní deska";
		$kategorie[6] = "Brzdy";
		$kategorie[7] = "Zdroj";
		$kategorie[8] = "Pancéřování";
		$kategorie[9] = "Suspenzory";
		$kategorie[10] = "Přídavný motor";
		
		$this->nazvy_predmetu = $kategorie;
	}
	
	function refresh() {
		foreach($this->tabs as $ajdee=>$it) {
			if($this->{$it}['vydrz'] <= 5 && isset($this->{$it}['nazev'])) { 
				unset($this->{$it});
				if($ajdee < 8) $this->ok_zavod = false;
			}
		}
			$this->checkParts;
		if($this->ok_zavod) {
			$this->getOdolnost(); 
			$this->getOvladat(); 
			$this->getRychlost();
			$this->getZrychleni();
			if($this->vaha > $this->podvozek['nosnost']) $this->prevazeni();
		}
	}
		
	function poskod($id,$dmg) {
		if(!isset($this->tabs[$id])) return 0;
		$this->{$this->tabs[$id]}['vydrz'] -= abs($dmg);
		if($this->{$this->tabs[$id]}['vydrz'] < 6) {
			$this->{$this->tabs[$id]}['vydrz'] = 0;
			$this->odstav($id);
		}
	}
	
	function updateSkody() {
		if($this->login < 0) return true;
	
		global $Sql;
		for($i=1;$i<11;$i++) {
			if(!isset($this->{$this->tabs[$i]}['nazev'])) {
				$Sql->q('UPDATE sklad SET vydrz = 0 WHERE login = '.$this->login.' AND umisteni = 1 AND typ = '.$i);
				continue;
			}
			$vydrz = $this->{$this->tabs[$i]}['vydrz'];
			if($vydrz < $this->{$this->tabs[$i]}['vydrz2']) {
				$Sql->q('UPDATE sklad SET vydrz = '.round($vydrz).' WHERE login = '.$this->login.' AND umisteni = 1 AND typ = '.$i.' AND zbozi = '.$this->{$this->tabs[$i]}['id']);	
				if($vydrz < 6) $this->odstav($i); 
			} 
		}
	}
	
	function odstav($id) { # vynda soucastku a umisti do skladu
		global $Sql;
		if(!isset($this->tabs[$id])) return 0;
		if(!isset($this->{$this->tabs[$id]}['nazev'])) return 0;
		if($this->{$this->tabs[$id]}['vydrz'] > 5) return 0;
		//$result = $Sql->q('UPDATE sklad SET vydrz = 0 WHERE login = '.$this->login.' AND umisteni = 1 AND typ = '.$id.' AND zbozi = '.$this->{$this->tabs[$id]}['id']);
		unset($this->{$this->tabs[$id]});
		if($id < 8) $this->ok_zavod = false;
		
		$this->refresh();
	}
		
	function getTabs($i) {
		if($i == 1) return $this->tabs;
		return $this->tabs2;
	}
	
	function prumer($vazeny) {
		$celkem = 0;
		$pocet = 0;
		
		$p = func_num_args();
		$args = func_get_args();

		if($vazeny) {
			for($i=1;$i<$p;$i+=2) {
				$celkem += $args[$i]*$args[$i+1];
				$pocet += $args[$i+1];
			}
			$prumer = $celkem/$pocet;
								
		} else {
			for($i=1;$i<$p;$i++) {
				$celkem += $args[$i];
			}			
			$prumer = $celkem/($p-1);
		}
		
		return $prumer;
	}
	
	function scw($cislo, $koef) {		
		switch($this->podvozek['typ']) {
			case 1:
				$koef = 1 + $koef;
				break;
				
			case 2:
				$koef = 1;
				break;
				
			case 3:
				$koef = 1 - $koef;
				break;
		}
		
		return $cislo * $koef;		
		//return $cislo * (1 + ($this->podvozek['typ'] == 2 ? 0 : ($this->podvozek['typ'] == 3 ? -1 : 1))*$koef);
	}
	
	function getVaha() {
		$vaha = $this->motor['vaha']+$this->deska['vaha']+$this->p_motory['vaha']+$this->pancerovani['vaha']-$this->suspenzory['vaha']+$this->brzdy['vaha'];
		if($vaha > $this->podvozek['nosnost'] && $this->podvozek['nosnost']) {
			$this->addHlaska(1);
			//$this->ok_zavod = false;
		}
		
		$this->vaha = $vaha;
		
		return $vaha;
	}
	
	function prevazeni() {			
		$prevazeni = $this->vaha-$this->podvozek['nosnost'];
		
		if($prevazeni < 1) return false;
		if(!$this->podvozek['nosnost']) return false;
	
		# rychlost:
		$def = $this->scw(1.5, -0.5);
		
		$this->rychlost = max(40,round($this->rychlost-$def*$prevazeni));
		
		# zrychleni:
		$def = 1 + (1.8*$prevazeni)/100;
		$def = $this->scw($def, 0.85);
		
		$this->zrychleni = round($this->zrychleni/$def);
		
		# ovladatelnost:
		$def = 1 + (1.05*$prevazeni)/100;
		$def = $this->scw($def, 0.95);
		
		$this->ovladat = round($this->ovladat/$def);
		
		# odolnost:
		$def = 1 + $prevazeni/1000;
		$def = $this->scw($def, 0.9);
		
		$def = min (1.1, $def);
		
		$this->odolnost = round($this->odolnost*$def);
	}
	
	function getRychlost() {
		@$motor = $this->motor['rychlost']*($this->motor['vydrz']/$this->motor['max_vydrz']);
		$motor = $this->prumer(true, $this->motor['rychlost'], 1.2, $motor, 1);
		
		$motor *= ($this->vaha/KLUZAK_MAX_VAHA)/(-2.1)+1.183;
		
		if($this->p_motory['zrychleni']) {
            @$booster = $this->p_motory['zrychleni']*($this->p_motory['vydrz']/$this->p_motory['max_vydrz']);
		    $booster = $this->prumer(true, $this->motor['rychlost'], 1.5, $booster, 1);
        }
        
		$motor = $this->scw($motor, 0.1);
		$motor += $booster/5;
			
		$this->rychlost = round($motor);
	}
	
	function getOvladat() {
		$ovl = $this->deska['ovladat'];
		
		# brzdy a podvozek
		
		@$podvozek = $this->podvozek['ovladat']*($this->podvozek['vydrz']/$this->podvozek['max_vydrz']);
		@$brzdy 	  = $this->brzdy['ovladat']*($this->brzdy['vydrz']/$this->brzdy['max_vydrz']);
		
		$podvozek = $this->prumer(true, $podvozek, 1, $this->podvozek['ovladat'], 2);
		$brzdy 	  =	$this->prumer(true, $brzdy, 1, $this->brzdy['ovladat'], 2);
		
		$ovl += ($podvozek-$ovl)*($brzdy/100);
		
		# hmotnost
		
		$hmotnost = ($this->vaha/KLUZAK_MAX_VAHA-0.5)/5;
		
		$ovl += $ovl*$hmotnost;
		
		$this->ovladatelnost = $ovl;
	}
	
	function getZrychleni() {		
		if(!$this->motor['zrychleni']) {
			$this->zrychleni = 0;
			return false;
		}
		
		@$motor = $this->motor['zrychleni']*($this->motor['vydrz']/$this->motor['max_vydrz']);
		$motor = $this->prumer(true, $this->motor['zrychleni'], 7, $motor, 1);
		
		@$podvozek = $this->podvozek['zrychleni']*($this->podvozek['vydrz']/$this->podvozek['max_vydrz']);
		$podvozek = $this->prumer(true, $this->podvozek['zrychleni'], 7, $podvozek, 1);
		
		@$booster = $this->p_motory['zrychleni']*($this->p_motory['vydrz']/$this->p_motory['max_vydrz']);
		$booster = $this->prumer(true, $this->p_motory['zrychleni'], 7, $booster, 1);
		
		$vaha = ($this->vaha/KLUZAK_MAX_VAHA)/(-2.1)+1.325;
		
		$acc = $motor * $podvozek/100;
		$acc = $this->prumer(true, $acc, 100-$booster, $motor, $booster);
		$acc *= $vaha;
		
		$this->zrychleni = round($acc);
	}  
	
	function getOdolnost() {
		$odol = $this->podvozek['vydrz']*($this->scw(1, -0.03)-0.08);
		
		$proc = 0;
		$pocet = 0;
		
		foreach($this->tabs as $val) {
			if(isset($this->{$val}['vydrz']) && isset($this->{$val}['max_vydrz'])) {
				$proc += $this->{$val}['vydrz']/$this->{$val}['max_vydrz'];
				$pocet++;
			}
		}
		
		$vaha = 0.55 + $this->vaha/KLUZAK_MAX_VAHA;/* vaha, [0.75 - 1.50] */
		@$kluzak_vydrz = $proc/$pocet;   /* kondice kluzaku, [0.00 - 1.00] */
		$dily 	= 0.65 + $pocet/25;		/* stavba kluzaku,	[0.93 - 1.05] */
										 	/*	pancerovani [0 - 100] 	  */
		@$pancir = $this->pancerovani['ochrana']*($this->pancerovani['vydrz']/$this->pancerovani['max_vydrz']);
		$pancir = $this->prumer(true, $this->pancerovani['ochrana'], 2, $pancir, 1);
		
		if(!$pancir) $pancir = 0;		
		
		$odol = $this->scw($odol, -0.1)/10;
		$odol = $this->prumer(true, $odol, 3, $odol*$vaha, 1);
		$odol = $this->prumer(true, $odol, 3+$pancir/15, $kluzak_vydrz, 1);
		$odol *= $dily;
		
		$odol = $this->prumer(true, $odol, 9, 50, 1);
		
		$this->odolnost = round($odol);
	}
	
	function getSpotreba() {
		$spotreba = $this->chladic['zdroj']+$this->deska['zdroj']+$this->drzaky['zdroj']+$this->suspenzory['zdroj']+$this->p_motory['zdroj'];
		if($spotreba > $this->zdroj['vykon'] && $this->zdroj['vykon']) {
			$this->addHlaska(4);
			$this->ok_zavod = false;
		}
		$this->spotreba = $spotreba;
	}
	
	function checkParts() {
		foreach($this->tabs as $ajdee=>$it) {
			if($this->{$it}['vydrz'] <= 5 && isset($this->{$it}['nazev'])) { 
				unset($this->{$it});
			}
			if($ajdee < 8 && !isset($this->{$it}['nazev'])) {
				$this->ok_zavod = false;
				$this->addHlaska(3);
			}
		}
	}
		
	function getChlazeni() {
		$this->chlazeni = 0;
		foreach($this->tabs as $val) {
			$this->chlazeni += $this->{$val}['chlazeni'];
		}
	}
		
	function checkChlazeni() {
		if($this->chlazeni > $this->chladic['vykon']) {
			if($this->chladic['vykon']) $this->addHlaska(2);
			//$this->ok_zavod = false;
			// tezko rict, jestli te to ma pustit do zavodu, kdyz ti to neuchladi
			$this->prehrati = $this->chladic['vykon']-$this->chlazeni;
		}
	}
	
	function addHlaska($n) {
		$hl[0] = "Neidentifikovaný problém";
		$hl[1] = "Kluzák je přetížen";
		$hl[2] = "Chlazení kluzáku není dostatečné";
		$hl[3] = "Kluzák není kompletní";
		$hl[4] = "Zdroj není dostatečně silný";
		
		if(isset($hl[$n])) { 
			if($n == 3) $this->hlasky = array();
			$this->hlasky[] = $hl[$n];
		} else {
			$this->hlasky[] = $hl[0];
		}
	}
	
	function getHlasky() {
		return $this->hlasky;
	}
	
	function fetchParts($parts) {
		global $Sql;
		for($i=1;$i<11;$i++) {
			if(isset($parts[$this->tabs[$i]]) && $parts[$this->tabs[$i]] != 0) {
				$this->{$this->tabs[$i]} = fa($Sql->q('SELECT * FROM '.$this->tabs2[$i].' WHERE id = '.$parts[$this->tabs[$i]]));
			}
		}
	}
	
	function setVydrze() {
		for($i=1;$i<11;$i++) {
			if(is_array($this->{$this->tabs[$i]})) {
				$this->{$this->tabs[$i]}['max_vydrz'] = $this->{$this->tabs[$i]}['vydrz'];
				$this->{$this->tabs[$i]}['vydrz'] = $this->vydrze[$i];
				$this->{$this->tabs[$i]}['vydrz2'] = $this->vydrze[$i];
			}
		}	
	}
	
	function getCasti() { // ziska casti kluzaku a vrati assoc. pole
		global $Sql;
		$predmety = Array();

		if(func_num_args() > 0) {			# simluace
			$args = func_get_args();
			$result = $Sql->q('SELECT zbozi,typ,cena,vydrz FROM sklad WHERE login = '.$this->login.' AND id IN('.implode(',',$args[0]).')');				
		} else {		
			$result = $Sql->q('SELECT zbozi,typ,cena,vydrz FROM sklad WHERE login = '.$this->login.' AND umisteni = 1');
		}
		
		$this->ma_pancerovani = false;
		$this->ma_suspenzory = false;
		$this->ma_pridavne = false;
		
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			if(isset($this->tabs[$row['typ']]) && $row['vydrz'] > 5) {
				$predmety[$this->tabs[$row['typ']]] = $row['zbozi'];
				$vydrze[$row['typ']] = $row['vydrz'];
				
				if($row['typ'] == 8) $this->ma_pancerovani = true;					
				if($row['typ'] == 9) $this->ma_suspenzory = true;					
				if($row['typ'] == 10) $this->ma_pridavne = true; 
			}
			$this->cena += $row['cena'];
		}
		
		$this->vydrze = $vydrze;
		$this->casti = $predmety;
	}
	
	function getRandPredmet($rand_predmety) {
		$predmet = $rand_predmety[rand(0,count($rand_predmety)-1)];
		while(!isset($this->{$this->tabs[$predmet]}['nazev'])) $predmet = $rand_predmety[rand(0,count($rand_predmety)-1)];
		
		return $predmet;
	}
	
	function bezpecnost($agresivita, $agrese) {
		$a = $this->prumer(true, $agresivita, 2, $agrese, 3);
		
		$vydrz1 = (20-(20*$a)/100)/100;
		$vydrz2 = (45-(45*$a)/100)/100;
		
		$vydrze = array();

		for($i=1;$i<11;$i++) {
			if(is_array($this->{$this->tabs[$i]})) {
				$vydrze[] = $this->{$this->tabs[$i]}['vydrz']/$this->{$this->tabs[$i]}['max_vydrz'];
			}
		}
		
		asort($vydrze);
		
		if($vydrze[0] < $vydrz1) return false;
		if($vydrze[0] < $vydrz2 &&
		   $vydrze[1] < $vydrz2 &&
		   $vydrze[2] < $vydrz2) return false;
		
		return true;
	}
}  
?>