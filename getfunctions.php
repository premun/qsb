<?php

############################################################
# PLAYER ###################################################
############################################################

function getStaj($id) {
	global $Sql;
	$result = $Sql->q('SELECT * from stajovnici WHERE login = '.$id);
	if(p($result) == 0) return false;
	$row = fa($result);
	return $row['staj'];
}

function getNick($id) {
	global $Sql,$nasly;
	if($id == 0 || $id == "") return "SYSTEM";
	if(count($nasly) > 0) {
		foreach($nasly as $login=>$nicky) {
			if($login == $id) return $nicky;
		}
	}
	
	if($id > 0) {
		$row = fa($Sql->q('SELECT login FROM hraci WHERE id = '.$id));
		$nasly[$id] = $row['login'];
	} else {
		$row = fa($Sql->q('SELECT j.jmeno as login FROM boti as b LEFT JOIN boti_jmena as j ON j.id = b.login WHERE b.id = '.abs($id)));
		$row['login'] = '~'.$row['login'];
	}
	
	return $row['login'];
}

function getPrestiz($id) {
	global $Sql;
	$result = $Sql->q('SELECT prestiz FROM '.($id > 0 ? 'postavy' : 'boti').' WHERE '.($id > 0 ? 'login = '.$id : 'id = '.abs($id)));
	$row = fa($result);
	return $row['prestiz'];
}

function getPenize($id) {
	global $Sql;
	$result = $Sql->q('SELECT penize FROM postavy WHERE login = '.$id);
	$row = fa($result);
	return $row['penize'];
}

function getRasa($id) {
	global $Sql;
	$row = fa($Sql->q('SELECT rasa from postavy WHERE login = '.$id));
	$result = $Sql->q('SELECT * FROM rasy WHERE id = '.$row['rasa']);
	return fa($result);  
}

function getRasaNazev($id) {
	global $Sql;
	$result = $Sql->q('SELECT nazev from rasy WHERE id = '.$id);
	$row = fa($result);  
	return $row['nazev'];
}

function getFlag($login) {
	global $Sql, $buff_vlajky;
	
	$args = func_get_args();
	if(count($args) > 1) {
		$staj = $args[1];
	} else {
		if(isset($buff_vlajky[-1*abs($login)])) return drawFlag2($buff_vlajky[-1*abs($login)]).' ';
		
		$hrac = fa($Sql->q('SELECT staj FROM stajovnici WHERE login = '.$login));
		
		$staj = $hrac['staj'];
	}
	
	if($staj == '') return '';
	
	if(isset($buff_vlajky[$staj])) return drawFlag2($buff_vlajky[$staj]).' ';
	
	$staj = fa($Sql->q('SELECT id, vlajka FROM staje WHERE id = '.$staj));
	$buff_vlajky[$staj['id']] = $staj['vlajka'];
	
	if($login) $buff_vlajky[-1*abs($login)] = $staj['vlajka'];
	
	return drawFlag2($staj['vlajka']).' ';
}

function getCost($cena,$rasa,$obch) {
	/*$rasa2 = $rasa['id'];
	if($obch == $rasa2) {
		$cena = 0.85*$cena;
	}
	if($rasa2 == 1) {
		if($obch == 12) {
			$cena = 1.3*$cena;  
		} else {
			$cena = 1.1*$cena;  	
		}
	}*/
	$cena = (100-$rasa['o']*2)*$cena/100;
	return $cena;
}

function getCostV($cena,$id,$id2) {
	$zakl = $cena;
	$rasa = getRasa($id);
	$rasa2 = $rasa['id'];
	$rasa3 = getRasa($id2);
	$rasa4 = $rasa3['id'];
	
	if($rasa4 == $rasa2) {
		$cena = $cena;
	}
	if($rasa2 == 1) {
		if($rasa4 == 12) {
			$cena = 1.3*$cena;  
		} else {
			$cena = 1.1*$cena;  	
		}
	}
	$cena = (((100-$rasa['o']*0.6)*$cena/100)+((100+$rasa3['o']*0.3)*$cena/100))/2;
	if($cena < $zakl) {
		$cena = ($cena+$zakl)/2;
	}
	
	return ceil($cena);
}

function getOpravaCas($procenta,$o) {
	$procenta = 100-$procenta;
	$sec = 60;
	$sec -= $o*1.5;
	
	$delka = $procenta*$sec;
	
	$args = func_get_args();
	if(isset($args[2])) {
		$delka -= $delka*$args[2]/100;
	}
	
	return time()+$delka;
}

function getRank($id) {
	global $Sql;
	$result = $Sql->q('SELECT postavy.login from postavy,hraci WHERE postavy.login = hraci.id AND hraci.status > 0 ORDER BY postavy.prvni DESC, postavy.druhy DESC, postavy.treti DESC, postavy.prestiz DESC');
	for($i=1;$i<(p($result)+1);$i++) {
		$hrac = fa($result);
		if($hrac['login'] == $id) {
			return $i;
			break;
		}
	}  
}

function getBrigName($id) {
	global $Sql;
	$result = $Sql->q('SELECT nazev from brigady WHERE id = '.$id);
	$row = fa($result);  
	return $row['nazev'];
}


function getMovitost($id,$banka2) {
  global $Sql;
	$result = $Sql->q('SELECT SUM(cena) as movitost FROM sklad WHERE login = '.$id);
	if (p($result) <> 0){
    	$kluzak = fa($result);
    } else $kluzak['movitost'] = 0;

// vklad v bance
	$result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$id.' AND typ="V"');
	if (p($result) <> 0){
    	$vklad = fa($result);
    } else $vklad['vyse']= 0;
  
// hodnota paliva
	$result = $Sql->q('SELECT paliva_ceny.stala_cena AS cena, paliva_sklad.mnozstvi AS mnozstvi FROM paliva_ceny, paliva_sklad WHERE paliva_sklad.login='.$id.' AND paliva_sklad.staj = 0 AND paliva_sklad.palivo = paliva_ceny.id');
	$cena_paliva = 0;
	if (p($result) <> 0){
		for($i=0;$i<p($result);$i++) {
			$palivo = fa($result);
			$cena_paliva = $cena_paliva + $palivo['cena']*$palivo['mnozstvi'];
		}
	}
 
	// VZOREC PRO LIMIT PUJCKY 
	$limit = 2000 + 0.2*$kluzak['movitost'] + 0.3*$cena_paliva;
	return $limit;
}

function getPalivoAll($id) {
	global $Sql;
	$result = $Sql->q('SELECT * FROM paliva_ceny WHERE id = '.$id);
	if(p($result) == 0) return false;
	return fa($result);  
}

function getJednotky() {
	$jednotky = Array();
	$jednotky[1] = 'ks';
	$jednotky[2] = 'ks';
	$jednotky[3] = 'ks';
	$jednotky[4] = 'l';
	$jednotky[5] = 'l';
	$jednotky[6] = 'l';
	$jednotky[7] = 'l';
	$jednotky[8] = 'l';
	$jednotky[9] = 'l';
	$jednotky[10] = 'l';
	$jednotky[11] = 'l';
	$jednotky[12] = 'l';
	$jednotky[13] = 'l';
	$jednotky[14] = 'kg';
	$jednotky[15] = 'kg';
	$jednotky[16] = 'kg';
	$jednotky[17] = 'kg';
	$jednotky[18] = 'kg';
	$jednotky[19] = 'kg';
	$jednotky[20] = 'kg';
	$jednotky[21] = 'kg';
	$jednotky[22] = 'kg';
	$jednotky[23] = 'ks';
	$jednotky[24] = 'ks';
	$jednotky[25] = 'ks';
	$jednotky[26] = 'kg';
	
	return $jednotky;
}

############################################################
# TRAT #####################################################
############################################################

function getDiff($id) {
	global $Sql;
	$result = $Sql->q('SELECT trat FROM trate WHERE id = '.$id);
	$row = fa($result);
	$kusy = explode(',', $row['trat']);
	$celkem = 0;
	
	if(!count($kusy)) return 0;
	
	$result = $Sql->q('SELECT id, nebezpeci FROM trate_druhy ORDER BY id ASC');
	for($i=0;$i<p($result);$i++) {
		$row = fa($result);
		$useky_info[$row['id']] = $row['nebezpeci'];
	}	
	
	foreach($kusy as $value) {
		$celkem += $useky_info[$value];
	}

	return ($celkem/count($kusy));
}

function getDiffOpt($trat) {
	global $Sql, $diff_danger, $diff_max, $diff_first;
	
	if($diff_first != 42) {
		$diff_first = 42;
		
		$result = $Sql->q('SELECT id,nebezpeci FROM trate_druhy ORDER BY id ASC');
		for($i=0;$i<p($result);$i++) {  
			$row = fa($result);
			$diff_danger[$row['id']] = $row['nebezpeci'];
		}
	}
	
	$kusy = explode(',',$trat);
	$celkem = 0;
	
	if(!count($kusy)) return 0;
	
	foreach($kusy as $value) {
		$celkem += $diff_danger[$value];
	}
	
	return $celkem/count($kusy);
}

function getSpotreba($trat,$spotreba) {
	global $Sql;
	
	$trat = fa($Sql->q('SELECT trat FROM trate WHERE id = '.$trat));
	
	$kusy = explode(',',$trat['trat']);
	$spotreba = $spotreba*count($kusy);
	
	return $spotreba;
}

function getDotace($useky,$obtiznost,$delka) {
	$dotace = $useky*1500;
	$dotace *= 1 + ($obtiznost-30)/100;
	$dotace *= 1 + $delka/10;
	
	return $dotace;
}
?>