<?php
class cSouboje {	
	function cSouboje($hraci) {
		$this->hraci = $hraci;
	}

	function souper($hrac, $range) {
		
		$kandidati = array();
		$pred = array();
		$za = array();
		
		foreach($this->hraci as $kandidat) {
			if($kandidat->id == $hrac->id) continue;
			if(!$kandidat->kluzak->ok_zavod) continue;
			if($kandidat->dojel) continue;
			if($kandidat->staj == $hrac->staj && $hrac->staj) continue;
			if(abs($hrac->vzdalenost-$kandidat->vzdalenost) > $range) continue;
			
			if($kandidat->vzdalenost > $hrac->vzdalenost) $pred[] = $kandidat->id;
				else $za[] = $kandidat->id;
			
			$kandidati[] = $kandidat->id;
		}
		
		if(!count($kandidati)) return 0;
		
		if(in_array($hrac->obet, $kandidati))  # otazka, jestli ma prednost obet pred taktikou!
			return $hrac->obet;
		
		$this->hrac = $hrac;
		
		$kandidat = 0;
		
		if(!count($kandidati)) return 0;
		
		if($hrac->agresivita == 0) { 
			usort($kandidati, array($this, "nejblizsi_obeti"));	
					
			$kandidat = $kandidati[0];
			
		} else {
			switch($this->hrac->taktika) {
				case 1: // atakovat pozici
					if(count($pred))
						$kandidat = $pred[rand(0,count($pred)-1)];
				
					break;
					
				case 2: // branit pozici
					if(count($za))
						$kandidat = $za[rand(0,count($za)-1)];
						
					break;
					
				case 3: // atakovat nejblizsiho
					usort($kandidati, array($this, "nejblizsi_obeti"));
					
					$kandidat = $kandidati[0];
					
					break;
			}
		}
		
		if(!$kandidat) 
			$kandidat = $kandidati[rand(0,count($kandidati)-1)];
		
		return $kandidat;
	}
	
	function nejblizsi_obeti($a, $b) {
		$hrac1 = $this->hraci[$a];
		$hrac2 = $this->hraci[$b];
	
		$prvni = abs($this->hrac->vzdalenost-$hrac1->vzdalenost);
		$druha = abs($this->hrac->vzdalenost-$hrac2->vzdalenost);
	
		if($prvni < $druha) return -1;
		if($prvni > $druha) return 1;
		if($prvni == $druha) return rand(0,1) ? 1 : -1;
	}
	
	function utocnici($tick) {
		$kandidati = array();
		
		foreach($this->hraci as $kandidat) {
	
			if($kandidat->agresivita < 0) continue;
			if($kandidat->posledni_utok == $kandidat->usek) continue;
			if(!$kandidat->kluzak->ok_zavod) continue;
			if($kandidat->dojel) continue;
			if(!$kandidat->usek) continue;
			if(rand(0,99) > ($kandidat->agresivita+$kandidat->agrese+($kandidat->agresivita == 0 ? 70 : 80))/3) continue;
			if(!$kandidat->kluzak->bezpecnost($kandidat->agresivita, $kandidat->agrese)) continue;
						
			$kandidati[] = $kandidat->id;
		}		
		
		if(!count($kandidati)) return $kanidati;
	
		usort($kandidati, array($this, "serad_utocniky"));
		
		return $kandidati;
	}
	
	function serad_utocniky($a, $b) {	
		$iniciativa1 = $this->hraci[$a]->kluzak->prumer(true, $this->hraci[$a]->agrese, 6, $this->hraci[$a]->agresivita, 4);
		$iniciativa2 = $this->hraci[$b]->kluzak->prumer(true, $this->hraci[$b]->agrese, 6, $this->hraci[$b]->agresivita, 4);
	
		if($iniciativa1 > $iniciativa2) return -1;
		if($iniciativa1 < $iniciativa2) return 1;
		
		if($this->hraci[$a]->poradi > $this->hraci[$b]->poradi) return -1;
		if($this->hraci[$a]->poradi < $this->hraci[$b]->poradi) return -1;
	}
	
	function sance_na_souboj($hrac1, $hrac2) {
		global $jizdni_styly;
		
		# pricitani tady zvysuje sanci na uhyb
		$sance = (-1*$hrac2->agresivita+100)/4;			# 0-50%
		$sance += $hrac2->reflexy/20*7;					# 0-35%
		$sance += $hrac2->kluzak->ovladatelnost/20*3;	# 0-15%
		$sance += rand(0,10)-5;
		
		if($hrac1->agresivita > 0 && $hrac2->agresivita < 0) { # +/- 15% za styly
			switch($jizdni_styly[1][$hrac2->postoj]['vztahy'][$hrac1->postoj]) {
				case 2:
					$sance += 15;
					break;
					
				case 0:
					$sance -= 7;
					break;
			}
		}
		
		if($hrac2->agresivita < 0 && count($zavod->hraci) > 2) { 
			$taktiky = 0;
		
			if($hrac2->vzdalenost > $hrac1->vzdalenost) { # obet je vepredu
				if($hrac2->taktika == 1) {
					$taktiky = 10;
				}
				
				if($hrac2->taktika == 2) {
					$taktiky = -5;
				}
			}
		
			if($hrac2->vzdalenost < $hrac1->vzdalenost) { # obet je vzadu
				if($hrac2->taktika == 1) {
					$taktiky = -5;
				}
				
				if($hrac2->taktika == 2) {
					$taktiky = 10;
				}
			}
			
			$sance += $taktiky;
			
			if($hrac1->id == $hrac2->obet) {
				$sance += 7;
			} else {
				$sance -= 3;
			}
		}
		
		$sance = 100-$sance; # udela se sance na trefeni a ne na uhyb
		
		# a tady jsou bonusy pro utocnika:
		
		$sance += 0.00064*$hrac1->agresivita*$hrac1->agresivita+0.016*$hrac1->agresivita;
		$sance += $hrac1->kluzak->ovladatelnost/20*3;
		$sance += $hrac1->reflexy/50*3;
		
		return round($sance);
	}
}
?>