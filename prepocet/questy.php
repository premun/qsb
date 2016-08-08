<?php

function questy($zavod) {
	global $Sql;

	foreach($zavod->hraci as $hrac) {
		if($hrac->id < 0) continue;
	
		$hrac->stats = fa($Sql->q('SELECT * FROM stats WHERE login = '.$hrac->id));
	
		$info = $zavod->info->hracInfo($hrac->id);
	
		//$hrac->soubojeStats();
		
		### STATS
		$dotaz = 'UPDATE stats SET 
		zavody = zavody+1,
		'.($zavod->typ == 2 ? 'poharove_zavody = poharove_zavody+1,' : '').'
		total_dmg = total_dmg+'.abs($info['dmg']).',
		total_skody = total_skody+'.abs($info['skody']).',
		total_vyvolane = total_vyvolane+'.$info['vyvolane'].',
		total_nevyvolane = total_nevyvolane+'.$info['nevyvolane'].',
		total_uhyby = total_uhyby+'.$info['uhyby'].',
		vyrazeni = vyrazeni+'.$info['vyrazeni'].'
		'.($zavod->poradi[0] == $hrac->id ? ', vitezstvi = vitezstvi+1 ' : '').'
		'.(!$hrac->kluzak->ok_zavod ? ', nedojeti = nedojeti+1 ' : '').'
		'.($info['dmg'] > $hrac->stats['max_dmg'] ? ', max_dmg = '.$info['dmg'].' ' : '').'
		'.($info['skody'] > $hrac->stats['max_skody'] ? ', max_skody = '.$info['dmg'].' ' : '').'
		'.($info['uhyby'] > $hrac->stats['max_uhyby'] ? ', max_uhyby = '.$info['uhyby'].' ' : '').'
		'.($info['vyvolane'] > $hrac->stats['max_vyvolane'] ? ', max_vyvolane = '.$info['vyvolane'].' ' : '').'
		'.($info['nevyvolane'] > $hrac->stats['max_nevyvolane'] ? ', max_nevyvolane = '.$info['nevyvolane'] : '').'
		
		WHERE login = '.$hrac->id;
		
		$dotaz = str_replace('+,', '+0,', $dotaz);
		
		$Sql->q($dotaz);
		
		### QUESTY
		
		$hrac->questy = $hrac->stats['questy'];
		$pocet = count($zavod->hraci);
		$poradi = $zavod->poradi;
		
		# Respect
		if(!$info['nevyvolane']) $hrac->questy = addQuest($hrac->id,16,$hrac->questy);
		
		# Catch me if you can
		if($hrac->nejhorsi == 1 && in_array($hrac->id,$poradi)) $hrac->questy = addQuest($hrac->id,17,$hrac->questy);
		
		# Strong will
		if($pocet > 3 && $poradi[0] == $hrac->id && $hrac->nejhorsi > 3) $hrac->questy = addQuest($hrac->id,18,$hrac->questy);
		
		# Amundsen
		if($pocet > 2 && count($poradi) == 1 && $poradi[0] == $hrac->id) $hrac->questy = addQuest($hrac->id,19,$hrac->questy);
		
		if(in_array($hrac->id,$poradi)) { # questy vyzadujici dojeti
		
			# Mosquito
			if($info['vyvolane'] == 1) $hrac->questy = addQuest($hrac->id,20,$hrac->questy);
		
			# Dirty drive
			if($info['vyvolane'] == 2) $hrac->questy = addQuest($hrac->id,21,$hrac->questy);
		
			# Mr. Proper
			if($info['vyvolane'] > 3) $hrac->questy = addQuest($hrac->id,22,$hrac->questy);
		
			# Ghost Rider
			if($info['vyvolane']+$info['nevyvolane'] == 0) $hrac->questy = addQuest($hrac->id,23,$hrac->questy);
			
			# Scratched, Strong will, Trash runner
			$scratched = 0;
			$scratched2 = 0;
			foreach($hrac->kluzak->tabs as $nazev) {
				if(isset($hrac->kluzak->{$nazev}['nazev'])) {
					if($hrac->kluzak->{$nazev}['vydrz']/$hrac->kluzak->{$nazev}['max_vydrz'] < 0.25) {
						$scratched++;
					}
					
					if($hrac->kluzak->{$nazev}['vydrz']/$hrac->kluzak->{$nazev}['max_vydrz'] < 0.45) {
						$scratched2++;
					}
				}
			}
			
			# Scratched
			if($scratched) $hrac->questy = addQuest($hrac->id,85,$hrac->questy);
			
			# Strong will
			if($scratched > 2) $hrac->questy = addQuest($hrac->id,86,$hrac->questy);
			
			# Trash runner
			if($scratched2 > 4 || $scratched2 > 4) $hrac->questy = addQuest($hrac->id,87,$hrac->questy);			
		}
		
		# Coincidence
		if($info['nevyvolane'] > 2) $hrac->questy = addQuest($hrac->id,24,$hrac->questy);
	
		# Fate
		if($info['nevyvolane'] > 4) $hrac->questy = addQuest($hrac->id,25,$hrac->questy);
	
		# Like a wind
		if($info['uhyby'] > 2) $hrac->questy = addQuest($hrac->id,26,$hrac->questy);
	
		# Matrix
		if($info['uhyby'] > 4) $hrac->questy = addQuest($hrac->id,27,$hrac->questy);
	
		# Oracle
		if($hrac->oracle > 2) $hrac->questy = addQuest($hrac->id,98,$hrac->questy);		

		# Meeting party
		if(count($zavod->hraci) > 3) {
			$party = array();
			foreach($zavod->info->udalosti as $udalost) {
				if($udalost->type != 'uhyb' && $udalost->type != 'souboj') continue;
				if($udalost->login == $hrac->id) {
					if(!in_array($udalost->login2,$party)) {
						$party[] = $udalost->login;
					}				
				} else {
					if(!in_array($udalost->login,$party)) {
						$party[] = $udalost->login;
					}
				}
			}
			
			if(count($party)+1 == count($zavod->hraci)) $hrac->questy = addQuest($hrac->id,30,$hrac->questy);
		}
		
		if(!$hrac->kluzak->ok_zavod) continue;
		
		foreach($zavod->info->udalosti as $udalost) {			
			if($udalost->type != 'souboj') continue;
			if($udalost->login != $hrac->id && $udalost->login2 != $hrac->id) continue;
			
			# Defensive mechanism
			if($udalost->login == $hrac->id) {
				if($udalost->fatal2) $hrac->questy = addQuest($hrac->id,36,$hrac->questy);				
			} else {
				if($udalost->fatal1) $hrac->questy = addQuest($hrac->id,36,$hrac->questy);				
			}
			
			# Kamikadze
			if($udalost->fatal1 && $udalost->fatal2)
				$hrac->questy = addQuest($hrac->id,31,$hrac->questy);
		}

		# Black widow
		if($info['vyrazeni'] && $info['vyvolane'] == 1) $hrac->questy = addQuest($hrac->id,32,$hrac->questy);
		
		# Sniper
		if($info['vyrazeni']) $hrac->questy = addQuest($hrac->id,33,$hrac->questy);
		
		# Martial arts
		if($info['vyrazeni'] > 1) $hrac->questy = addQuest($hrac->id,34,$hrac->questy);
			
		# Survival
		if($info['skody'] > 499) $hrac->questy = addQuest($hrac->id,41,$hrac->questy);
		
		# Buldozer	
		if($hrac->buldozer == 42) $hrac->questy = addQuest($hrac->id,42,$hrac->questy);
		
	
		$assault = array();
		$shikana = array();
		
		foreach($zavod->info->udalosti as $udalost) {			
			if($udalost->type != 'souboj') continue;
			if($udalost->login != $hrac->id && $udalost->login2 != $hrac->id) continue;
			
			# Mostly harmless
			if($udalost->dmg1 > 99 && $udalost->dmg1 < 200 && $udalost->login == $hrac->id) {
				$hrac->questy = addQuest($hrac->id,37,$hrac->questy);
			}
			if($udalost->dmg2 > 99 && $udalost->dmg2 < 200 && $udalost->login2 == $hrac->id) {
				$hrac->questy = addQuest($hrac->id,37,$hrac->questy);
			}
			
			# Knock knock
			if(($udalost->dmg1 > 199 && $udalost->login == $hrac->id) || ($udalost->dmg2 > 199 && $udalost->login2 == $hrac->id)) {
				$hrac->questy = addQuest($hrac->id,38,$hrac->questy);
			}		

			# Shikana			
			if($udalost->login == $hrac->id) {
				$shikana[$udalost->login2]++;
				if($shikana[$udalost->login2] == 3) $hrac->questy = addQuest($hrac->id,40,$hrac->questy);			
			} else {
				$shikana[$udalost->login]++;
				if($shikana[$udalost->login] == 3) $hrac->questy = addQuest($hrac->id,40,$hrac->questy);			
			}
						
			# Planned assault
			if($udalost->login == $hrac->id) {
				$assault[$udalost->login2] += $udalost->dmg1;
				if($assault[$udalost->login2] > 299 && $shikana[$udalost->login2] == 2) $hrac->questy = addQuest($hrac->id,39,$hrac->questy);	
			} else {
				$assault[$udalost->login] += $udalost->dmg2;
				if($assault[$udalost->login] > 299 && $shikana[$udalost->login] == 2) $hrac->questy = addQuest($hrac->id,39,$hrac->questy);	
			}
		}
	}
}
?>	