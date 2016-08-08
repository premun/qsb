<?php

class cPrepocet {
	function cPrepocet($type,$auth,$db,$logg,$info) {
		$this->type = $type;
		$this->auth = $auth;
		$this->logg = $logg;
		$this->info = $info;
		$this->db = $db;
		
		switch($type) {
			case 13:
				$this->cas = 13;
				break;
				
			case 16:
				$this->cas = 16;
				break;
				
			case 19:
				$this->cas = 19;
				break;
				
			default:
				$this->cas = 0;
				break;
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function run() {
		if($this->auth) {
			if($_GET['auth'] != 'ok') return false;
		}
		
		$this->staveni_budov();
		$this->vykup_predmetu();
		$this->brigady();
		$this->doplneni_zbozi();
		
		$paliva_ceny = $this->paliva_ceny();
	
		if(!$this->type) {				# Hlavni prepocet
			$this->socialni_davky(3000);
			//$this->casopis();
			$this->budovy();
			$this->stajove_platy();
			$this->zakladani();
			$this->opravari();
			$this->etapy();
			$this->uroky();
		}
		
		$this->zavody();
		$this->boti();
		$this->zdaneni_paliva($paliva_ceny);
		
		$this->finish();
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function finish() {
		global $Sql;
		
		$Sql->q('UPDATE sys set entity = "'.date('H:i d.m.').'" WHERE val = -42');
		$Sql->q('UPDATE postavy set prestiz = 1 WHERE prestiz < 1');
	
		/*if($this->db && !$this->type) {
			@include '../mysqldump.php';
		}*/
		
		if($this->logg) {
			$fp = fopen('../vypisy/prepocty/'.date("Y-m-d").'_'.$this->type.'.txt','w');
			fwrite($fp,'SQL: '.$_SESSION['sql']);
			fclose($fp);
		}
		
		if($this->info) {
			echo date('d.m.Y H:i').' SQL: '.$_SESSION['sql'];
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function zavody() {
		global $Sql;
		$cas = $this->type;
		
		$Sql->q('UPDATE zavody set datum = "'.date('Y-m-d').'" WHERE datum = "4200-12-24" AND vitez = 0');
		
		$Sql->q('UPDATE zavody set datum = "'.date('Y-m-d').'" 
				WHERE vitez = 0 AND datum < "'.date('Y-m-d',time()).'"');		
							
		switch($cas) {
			case 13:
				$result = $Sql->q('SELECT * FROM zavody WHERE datum = "'.date('Y-m-d').'" AND vitez = 0 AND cas = 13');
				break;
				
			case 16:
				$result = $Sql->q('SELECT * FROM zavody WHERE datum = "'.date('Y-m-d').'" AND vitez = 0 AND (cas = 13 OR cas = 16)');
				break;
				
			case 19:
				$result = $Sql->q('SELECT * FROM zavody WHERE datum = "'.date('Y-m-d').'" AND vitez = 0 AND (cas = 13 OR cas = 16 OR cas = 19)');
				break;
				
			default:
				$result = $Sql->q('SELECT * FROM zavody WHERE datum = "'.date('Y-m-d').'" AND vitez = 0');
				break;
		}
		
		# $result = seznam zavodu, co se eventuelne pojedou
		
		if(!p($result)) return true;
		
		$this->zavody = array();
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$row['cas'] = $this->cas;
			$this->zavody[$row['id']] = new cZavod($row['id'],$row);	# novej zavod
			
			if(!$this->zavody[$row['id']]->zavodnici()) {				# kdyz je dost lidi
				unset($this->zavody[$row['id']]);
			}
		}

		if(!count($this->zavody)) return true;
		
		$max_o = 21;
		$min_o = 4;
		
		$result2 = $Sql->q("SELECT id,r,a,o FROM rasy ORDER BY id ASC");
		for($i=0;$i<p($result2);$i++) {
			$rasa2 = fa($result2);
			$rasy[$rasa2['id']]['r'] = $rasa2['r'];
			$rasy[$rasa2['id']]['a'] = $rasa2['a'];
			$rasy[$rasa2['id']]['o'] = ($rasa2['o']+$min_o)/$max_o;
		}
		
		$this->rasy = $rasy;
		
		$result2 = $Sql->q("SELECT id,nazev,nebezpeci,rychlost FROM trate_druhy ORDER BY id ASC");
		for($i=0;$i<p($result2);$i++) {
			$kousky = fa($result2);
			$useky[$kousky['id']]['nazev'] = $kousky['nazev'];
			$useky[$kousky['id']]['nebezpeci'] = $kousky['nebezpeci'];
			$useky[$kousky['id']]['rychlost'] = $kousky['rychlost'];
		}
		
		$this->useky = $useky;
		
		foreach($this->zavody as $id => $zavod) $this->zavody[$id]->inic($this->rasy,$this->useky);		# nacteme data, protoze tyhle zavody se uz urcite pojedou
		
		foreach($this->zavody as $id => $zavod) {
			$this->zavody[$id]->odjed_zavod();
			//zavod_vyhry($this->zavody[$id]);
			//$sazky = zavod_sazky($this->zavody[$id]);
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function socialni_davky($amount) {
		global $Sql;
		$Sql->q('UPDATE postavy as p 
				 LEFT JOIN hraci as h ON h.id = p.login 
				 SET p.penize = p.penize+'.$amount.'
				 WHERE h.status > 0');

		finance(0,$amount,1,2);
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function doplneni_zbozi() {
		global $Sql;
		$Sql->q('UPDATE zbozi set kusy = celkem');
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function staveni_budov() {		# stajovy budovy
		global $Sql;
		$Sql->q('UPDATE budovy set staveni = staveni-1 WHERE staveni > 0');
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function vykup_predmetu() {		# systemaci kupujou predmety od hracu
		global $Sql;
		
		$lidi = fa($Sql->q('SELECT COUNT(id) as pocet FROM hraci WHERE status > 0'));

		$predmetu = ceil($lidi['pocet']/50)*2; 
		
		$celkem = rand(1,$predmetu); # kolik predmetu se proda
		
		if(rand(0,1)) {
			$tabs[1] = "podvozky";
			$tabs[2] = "motory";
			$tabs[3] = "drzaky";
			$tabs[4] = "chladice";
			$tabs[5] = "desky";
			$tabs[6] = "brzdy";
			$tabs[7] = "zdroje";
			$tabs[8] = "pancerovani";
			$tabs[9] = "suspenzory";
			$tabs[10] = "p_motory";
		
			for($i=0;$i<$celkem;$i++) {
				$res = $Sql->q('SELECT s.id as id, s.cena2 as cena, s.login as login, s.typ as typ, r.o as o FROM sklad as s 
								LEFT JOIN postavy as p ON p.login = s.login
								LEFT JOIN rasy as r ON r.id = p.rasa 
								WHERE p.vyloha = 1 AND s.umisteni = 2 
								ORDER BY RAND() LIMIT 1');
				if(p($res)) {
					$predmet = fa($res);
					$cena = $predmet['o'];
					$cena = round((((100-$predmet['o']*0.6)*($predmet['cena']/2)/100)+(1.03*($predmet['cena']/2)))/2);
					$Sql->q('UPDATE postavy set penize = penize+'.$cena.' WHERE login = '.$predmet['login']);
					
					finance($predmet['login'],$cena,1,10);
					
					$msg = 'Systemovy obchodnik zakoupil predmet z tve vylohy za [B][O]'.numF($cena).'Is[/O][/B].
					
SYSTEM';
					
					sendPosta(0,$predmet['login'],$msg);
					
					$Sql->q('DELETE FROM sklad WHERE id = '.$predmet['id']);
					$Sql->q('DELETE FROM sablony WHERE login = '.$predmet['login'].' AND '.$tabs[$predmet['typ']].' = '.$predmet['id']);
					$Sql->q('UPDATE stats SET prodej2 = prodej2+1 WHERE login = '.$predmet['login']);
				}
			}
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function paliva_ceny() {
		global $Sql;
		
		$benzin = rand(0,30)-15;
		$plutonium = rand(0,26)-13;
		$raselina = rand(0,16)-8;
		$nafta = rand(0,20)-10;
		$vodik = rand(0,16)-8;
		$kadmium = rand(0,12)-6;
		$uran = rand(0,8)-4;
		$antihmota = rand(0,6)-3;
		
		$paliva[1] = 0;
		$paliva[2] = 0;
		$paliva[3] = 0;
		$paliva[4] = $raselina;
		$paliva[5] = $raselina;
		$paliva[6] = $nafta;
		$paliva[7] = $nafta;
		$paliva[8] = $nafta;
		$paliva[9] = $benzin;
		$paliva[10] = $benzin;
		$paliva[11] = $benzin;
		$paliva[12] = $vodik;
		$paliva[13] = $vodik;
		$paliva[14] = $kadmium;
		$paliva[15] = $kadmium;
		$paliva[16] = $kadmium;
		$paliva[17] = $uran;
		$paliva[18] = $uran;
		$paliva[19] = $uran;
		$paliva[20] = $uran;
		$paliva[21] = $plutonium;
		$paliva[22] = $antihmota;
		$paliva[23] = 0;
		$paliva[24] = 0;
		$paliva[25] = 0;
		$paliva[26] = $antihmota;
		
		$result = $Sql->q('SELECT id,stala_cena FROM paliva_ceny ORDER BY id ASC');
		
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			$ceny[$row['id']] = $row['stala_cena'];
		}
		
		foreach($paliva as $ind=>$val) {
			$ceny[$ind] = $ceny[$ind]/100*(100+$val);
			$Sql->q('UPDATE paliva_ceny set cena = '.$ceny[$ind].' WHERE id = '.($ind));
		}
		
		return $ceny;
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function zdaneni_paliva($ceny) {
		global $Sql;
		
		$result = $Sql->q('SELECT p.sklad as sklad, p.penize as penize, p.login as login, SUM(s.mnozstvi) as celkem, r.o as o 
							FROM paliva_sklad as s 
							LEFT JOIN postavy as p ON p.login = s.login 
							LEFT JOIN rasy as r ON r.id = p.rasa 
							WHERE s.staj = 0 GROUP BY s.login');
								
		for($i=0;$i<p($result);$i++) {
			$platit = 0;
			$row = fa($result);		
			
			if($row['celkem'] <= $row['sklad']) continue;
			
			$koeficient = - $row['o'] * 0.02 + 0.72;	
			$penize = $row['penize'];
			$penize2 = $penize;	
			$pres = $row['celkem']-$row['sklad'];			
			
			$result3 = $Sql->q('SELECT id, palivo, mnozstvi FROM paliva_sklad WHERE staj = 0 AND login = '.$row['login'].' ORDER BY mnozstvi DESC');
			
			$paliva = array();
			$paliva_celkem = 0;
			
			for($j=0;$j<p($result3);$j++) { # musi se spocitat celkova dan
				$row2 = fa($result3);
				$paliva[$row2['palivo']] = $row2['mnozstvi'];
				$paliva_celkem += $row2['mnozstvi'];
			}
			
			$cena = 0;
			foreach($paliva as $id=>$mn) {
				$cena += $ceny[$id]*$pres*$koeficient*$mn/$paliva_celkem;
				//echo $id.'['.$mn.'] => '.round($pres*$mn/$paliva_celkem).' - '.round($ceny[$id]*$pres*$koeficient*$mn/$paliva_celkem).',-<br />';
			}	
			
			$cena = round($cena/2);
			
			if($penize >= $cena) {
				$Sql->q('UPDATE postavy set penize = penize-'.$cena.' WHERE login = '.$row['login']);
				$Sql->q('UPDATE stats set udrzba = udrzba+1 WHERE login = '.$row['login']);
				finance($row['login'],abs($cena),0,35);	
				continue;
			} else {
				if($penize != 0) {
					$Sql->q('UPDATE postavy set penize = 0 WHERE login = '.$row['login']);
					$Sql->q('UPDATE stats set udrzba = udrzba+1 WHERE login = '.$row['login']);
					$cena = $cena-$penize;
					finance($row['login'],abs($penize),0,35);	
				}
				
				$ok = false;
				foreach($paliva as $id=>$mn) {
					if($ok == false) {
						if($mn*$ceny[$id] < $cena) {
							$cena -= $mn*$ceny[$id];
							$Sql->q('DELETE FROM paliva_sklad WHERE palivo = '.$id.' AND login = '.$row['login']);
						}
						if($mn*$ceny[$id] == $cena) {
							$cena = 0;
							$Sql->q('DELETE FROM paliva_sklad WHERE palivo = '.$id.' AND login = '.$row['login']);
							$ok = true;
						}
						if($mn*$ceny[$id] > $cena) {
							$Sql->q('UPDATE paliva_sklad set mnozstvi = mnozstvi-'.ceil($cena/$ceny[$id]).' WHERE palivo = '.$id.' AND login = '.$row['login']);
							$ok = true;
						}
					}
				}
			}
			
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function brigady() {
		global $Sql;
	
		$result = $Sql->q('SELECT * from brigadnici');
		
		if(p($result) > 0) {
			$res = $Sql->q('SELECT * from brigady');
			
			for($i=0;$i<p($res);$i++) {
				$row = fa($res);
				$prestiz[$row['id']] = $row['prestiz2'];
				$penize[$row['id']] = $row['penize'];
				$extra[$row['id']] = $row['rasa'];
			}
			
			$result = $Sql->q('SELECT * from brigadnici');
			for($j=0;$j<p($result);$j++) {
				$brigadnik = fa($result);
				$brig = $brigadnik['login'];
				$b = $brigadnik['brigada'];
				$hrac = fa($Sql->q('SELECT * from postavy WHERE login = '.$brig));
				if($hrac['rasa'] == $extra[$b]) { 
					$prachy = $penize[$b]*1.20; 
				} else { 
					$prachy = $penize[$b]; 
				}
				$pr = $prestiz[$b];
				$Sql->q('UPDATE postavy set penize = '.($hrac['penize']+$prachy).', prestiz = '.($hrac['prestiz']-$pr).' WHERE login = '.$hrac['login']);
				$Sql->q('UPDATE stats set brigady1 = brigady1+'.$prachy.', brigady2 = brigady2+'.$pr.' WHERE login = '.$hrac['login']);
				finance($hrac['login'],$prachy,1,36);
			}
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	function casopis() {
		/*global $Sql;
			
		$c = fa($Sql->q('SELECT val from sys WHERE entity = "casopis"'));
		$c = $c['val'];
		$c--;
		$Sql->q('UPDATE sys set val = '.$c.' WHERE entity = "casopis"');
		
		if($c > 0) {
			return 0;
		} 
		if($c == 0) {
			$cislo = fa($Sql->q('SELECT val2 from casopis WHERE val1 = "cislo"'));
			$Sql->q('UPDATE casopis set val2 = '.($cislo[val2]+1).' WHERE val1 = "cislo"');
			$Sql->q('UPDATE sys set val = 4 WHERE entity = "casopis"');
			$result = $Sql->q('SELECT * from casopis');
			for($i=0;$i<p($result);$i++) {
				$row = fa($result);
				$co = $row['val1'];
				$to = $row['val2'];
				if($co == "cislo") $cislo = $to;
				if($co == "zavody") $zavody = $to;
				if($co == "movitost") $movitost = $to;
				if($co == "veci") $veci = $to;
				if($co == "nakup") $nakup = $to;
				if($co == "sazka") $sazka = $to;
				if($co == "sazka2") $sazka2 = $to;
			}
			
			$prestiz = fa($Sql->q("SELECT hraci.login as jmeno FROM postavy as p LEFT JOIN hraci ON hraci.id = p.login WHERE hraci.status > -1 ORDER BY p.prestiz DESC LIMIT 0,1"));
			$prestiz = $prestiz['jmeno'];
			
			$prestiz2 = fa($Sql->q("SELECT hraci.login as jmeno FROM postavy as p LEFT JOIN hraci ON hraci.id = p.login WHERE hraci.status > -1 ORDER BY p.prestiz DESC LIMIT 1,1"));
			$prestiz2 = $prestiz2['jmeno'];
			
			$zavody = $zavody;
			
			$msg = '<h3>QSB Times <span class="ultra">(císlo '.$cislo.')</span></h3>
			<strong>Nejrychlejší a nejprehlednejší magazín v tomto i jakémkoli jiném vesmíru</strong><br />
			<br />
			Co se zase událo? Kdo kde vyhrál a kolik kdo vsadil? Jedine v QSB Timesu, každé 4 dny!
			<hr /><br />
			Nejprestižnejším clovekem se stal <span class="extra"><strong>'.$prestiz.'</strong></span>. Na paty mu ovšem šlape velmi ambiciózní <span class="extra"><strong>'.$prestiz2.'</strong></span>, takže uvidíme, kdo to bude príští týden. Nejvetší obnos tento týden vsadil <span class="extra"><strong>'.getNick($sazka).'</strong></span> a bylo to celých <span class="extra"><strong>'.numF($sazka2).' Is</strong></span>!<br />
			Celkem jste u systémových obchodníku utratili <span class="extra"><strong>'.numF($nakup).' Is</strong></span> pri nákupu <span class="extra"><strong>'.$veci.'</strong></span> predmetu. Posloužily vám k odjetí <span class="extra"><strong>'.$zavody.'</strong></span> závodu.
			<br /><br />
			To je pro dnešek vše a nezapomente - <span class="extra"><strong><strong>'.date('d.m.',time()+4*86400).'</strong></span> opet cerstvé info!';
			
			if($cislo < 10) $cislo = '0'.$cislo;
			
			$fp = fopen('../vypisy/casopis/casak_'.$cislo.'.txt','w');
			fwrite($fp,$msg);
			fclose($fp);
		}*/
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function budovy() {
		global $Sql;	
	
		$result = $Sql->q('SELECT id,penize FROM budovy_typy');
		for($i=0;$i<p($result);$i++) {
			$b = fa($result);
			$penize[$b['id']] = $b['penize'];
		}
		$kancly = 0;
		$result = $Sql->q('SELECT id from staje');
		for($i=0;$i<p($result);$i++) {
			$staj = fa($result);
			$money = 0;
			$res = $Sql->q('SELECT budova FROM budovy WHERE staj = '.$staj['id'].' AND staveni = 0');
			for($j=0;$j<p($res);$j++) {
				$n = fa($res);
				$money += $penize[$n['budova']];
				if($n['budova'] == 8) {
					$kancly++;
				}
			}
			$money += $money*$kancly*0.1;
			$Sql->q('UPDATE staje SET kasa = kasa+'.$money.' WHERE id = '.$staj['id']);
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function etapy() {
		global $Sql;	
		$result = fa($Sql->q('SELECT val FROM sys WHERE entity = "etapa"'));
		$etapa = $result['val'];

		$next = etapa($etapa+1);

		if($next == date('j.n.', time()) || $next == date('j.n.', time()+24*60*60)) {
		
			if($etapa == 1) $Sql->q('UPDATE sys set val = "-1" WHERE entity = "pohar"');
			
			$Sql->q('UPDATE sys set val = '.($etapa+1).' WHERE entity = "etapa"');
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function stajove_platy() {
		global $Sql;
	
		$result = $Sql->q('SELECT login, penize, staj FROM stajovnici WHERE penize > 0 ORDER BY stav ASC');
		
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			
			$staj = fa($Sql->q('SELECT kasa FROM staje WHERE id = '.$row['staj']));
			$kasa = $staj['kasa'];
			
			if($row['penize'] > $kasa) {
				$k_hraci = $kasa;
				$z_kasy = $kasa;
			} else {
				$k_hraci = $row['penize'];
				$z_kasy = $row['penize'];
			}
			
			$Sql->q('UPDATE staje set kasa = kasa-'.$z_kasy.' WHERE id = '.$row['staj']);
			$Sql->q('UPDATE postavy set penize = penize+'.$k_hraci.' WHERE login = '.$row['login']);
			finance($row['login'],$k_hraci,1,34);
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function uroky() {
		global $Sql;
	
		$tempBanka = new banka(1);
	
		$res = $Sql->q('SELECT * FROM pujcky');
		
		for($i=0;$i<p($res);$i++) {
			$row = fa($res);
			$splaceno = false;
			$idcko = $row['id'];
			$penize = getPenize($row['hrac']);
			$puv_penize = $penize;
			
			$newVyse = $row['vyse'] * (1 + $row['ir']/100); 
			if($row['splatnost'] == 0 && $row['typ'] == "P") {
				if($penize >= $newVyse) {
					$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
					finance($row['hrac'],$puvodni_penize,0,27);
					$splaceno = true;
				} else { // pri nesplaceni se uroci dvounasobnou sazbou
				$newVyse = $row['vyse'] / (1 + $row['ir']/100) * (1 + 2*$row['ir']/100);
				$msg = 'K bankovnimu domu [B]'.$tempBanka->jmeno.'[/B], mas dnes splatnou pujcku, na jejiz uhrazeni jsi nemel dost penez! Zbyva uhradit [B][O]'.numF($newVyse).' Is[/O][/B], pokud tuto castku neuhradis do dvou dnu, bude prodan tvuj majetek!
				
		Meziplanetarni vrchni exekutor';
					sendPosta(0,$row['hrac'],$msg);
				}
			}
		
			// 1. den po splatnosti-> vyssi urok
			if($row['splatnost'] == -1 && $row['typ'] == "P") {
				if($penize>= $newVyse) {
					$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
					finance($row['hrac'],$newVyse,0,27);
					$splaceno = true;
				} else {
					$newVyse = $row['vyse'] * (1 + 2*$row['ir']/100);
				}
			}
			
			// 2. den po splatnosti-> prodani soucastek a paliva, zabaveni vkladu
			if($row['splatnost'] == -2 && $row['typ'] == "P") {
				if($penize >= $newVyse) {
					$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
					finance($row['hrac'],$puvodni_penize,0,27);
					$splaceno = true;
				} else {
					$newVyse = $row['vyse'] / (1 + $row['ir']/100) * (1 + 2*$row['ir']/100);
					// nejdrive zkusi banka vzit jen vklady
					if(($tempBanka->getVyseVkladu($row['hrac']) + $penize) >= $newVyse) {
						$tempBanka->vybraniVkladu($tempBanka->getVyseVkladu($row['hrac']), $row['hrac']); 
						$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
						finance($row['hrac'],$newVyse,0,27);
						$splaceno = true;
						$msg = 'Byla uvalena exekuce na tvuj vklad v bance, aby mohl byt splacen tvuj zavazek (pujcka) k bance [B]'.$tempBanka->jmeno.'[/B].
		
		Meziplanetarni vrchni exekutor';
						sendPosta(0,$row['hrac'],$msg);    
					} else { // vklad na splaceni nestaci
						$vklad = $tempBanka->getVyseVkladu($row['hrac']);
						if($vklad) {
							$tempBanka->vybraniVkladu($vklad, $row['hrac']);
							$penize += $vklad;
						}
						
						$zbyva = $newVyse-$penize;
						
						$sumaPalivo = 0; // banka rozproda hracovo palivo
						$result = $Sql->q('SELECT s.mnozstvi as mnozstvi, p.cena as cena, s.palivo as palivo FROM paliva_sklad as s LEFT JOIN paliva_ceny as p ON p.id = s.palivo WHERE s.login = '.$row['hrac']);
						if(p($result) != 0) {
							for($i=0;$i<p($result);$i++) {
								$pal = fa($result); // nakumulujeme cenu paliva
								
								if($sumaPalivo < $zbyva) {
									$sumaPalivo += $pal['mnozstvi']*$pal['cena'];
									// prodame palivo
									$Sql->q('DELETE FROM paliva_sklad WHERE login = '.$row['hrac'].' AND palivo = '.$pal['palivo']);           
								}
							}
						}				
						
						$penize += $sumaPalivo;
						$Sql->q('UPDATE postavy SET penize = penize+'.$sumaPalivo.' WHERE login = '.$row['hrac']); // penize pricteny hraci z prodaneho paliva
						
						if($penize >= $newVyse) { // staci prodej paliva na splaceni?
							$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
							finance($row['hrac'],$puvodni_penize,0,27);
							$splaceno = true;
							$msg = 'Byla uvalena exekuce na tvuj vklad a tve palivo, ktere bylo prodano na trhu, aby mohl byt splacen tvuj zavazek k bance [B]'.$tempBanka->jmeno.'[/B].
		
		Meziplanetarni vrchni exekutor';
							sendPosta(0,$row['hrac'],$msg);
						} else {	// banka proda soucastky do kluzaku
							$res3 = $Sql->q('SELECT * FROM sklad WHERE login = '.$row['hrac'].' ORDER BY umisteni DESC, cena DESC');
							$i=0;
							while ($i<p($res3) && !$splaceno) {
								$soucastka = fa($res3);
								$penize += 0.7*$soucastka['cena'];	// pridani penez hraci za prodej soucastky
								$Sql->q('UPDATE postavy SET penize = '.$penize.' WHERE login = '.$row['hrac']);
							
								$Sql->q('DELETE FROM sklad WHERE id='.$soucastka['id'].' AND login='.$row['hrac']); // vymaz soucastky z db
								// pokud byla soucastka z kluzaku a hrac je v zavode, tak se z neho vyhodi
								if($soucastka['umisteni'] = 1) {
									$res4 = $Sql->q('SELECT zavodnici.id AS idzav FROM zavodnici LEFT JOIN zavody ON zavodnici.zavod = zavody.id WHERE zavodnici.login = '.$row['hrac'].' AND zavody.vitez=0');
									if(p($res4) != 0) {
										for($g=0;$g<p($res4);$g++) {
											$smazat = fa($res4);
											$Sql->q('DELETE FROM zavodnici WHERE id = '.$smazat['idzav']);
										}
										// posta hraci
										$msg = 'V exekuci byla zabavena cast tveho kluzaku. Zavod, do ktereho jsi byl prihlasen nemuzes odjet.';
										sendPosta(0,$row['hrac'],$msg);
									}              
								}
		
								if($penize >= $newVyse) {
									$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
									finance($row['hrac'],$puvodni_penize,0,27);
									$splaceno = true;
								}
								$i++;
							}
							// neni-li stale splaceno, jde hrac do minusu proste
							if(!$splaceno) {
								$tempBanka->splaceniPujcky($newVyse, $row['hrac']);
								finance($row['hrac'],$puvodni_penize,0,27);
								$splaceno = true;
							}      
							$msg = 'Byla uvalena exekuce na tvuj vklad, tve palivo a soucastky tveho kluzaku, aby mohl byt splacen tvuj zavazek k bance [B]'.$tempBanka->jmeno.'[/B].
		
		Meziplanetarni vrchni exekutor';
							sendPosta(0,$row['hrac'],$msg);
						}
					}
				}
			}
			if($row['typ'] == "P") {
				$newSplatnost = $row['splatnost'] - 1;
			} else {
				$newSplatnost = 0;
			} 
			 
			if(!$splaceno) $Sql->q('UPDATE pujcky SET vyse='.$newVyse.', splatnost='.$newSplatnost.' WHERE id='.$idcko);
		}
	}
	
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function opravari() {
		global $Sql;
	
		$result = $Sql->q('SELECT p.login as id, p.penize as penize FROM opravari as o LEFT JOIN postavy as p ON p.login = o.login');
		
		$msg = 'Protoze jsi nemel na denni poplatky ('.numF(OPRAVAR_DENNE).' Is), byl jsi vyloucen z cechu opravaru.

SYSTEM';
		
		for($i=0;$i<p($result);$i++) {
			$row = fa($result);
			if($row['penize'] >= OPRAVAR_DENNE) {
				$Sql->q('UPDATE postavy set penize = penize-'.OPRAVAR_DENNE.' WHERE login = '.$row['id']);
				finance($row['id'],OPRAVAR_DENNE,0,39);
			} else {
				$Sql->q('DELETE FROM opravari WHERE login = '.$row['id']);
				sendPosta(0,$row['id'],$msg);
			}
		}
	}	
		
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function zakladani() {
		global $Sql,$pohar_trate;
	
		$sport_trate = array(197,77,251,233,44,194,45,79,84,224,20,31,199,78,87,41,254);
		$combi_trate = array(259,192,114,67,47,34,263,69,258,178,174,37,24,127,162,228);
		$wrecker_trate = array(243,211,82,180,85,236,62,73,245,156,89);
		$multi_trate = array(224,119,56,97,102,166,110,67,47,34,81,258,36,37,111);
		$extra_trate = array(262,132,167,69,92,70,174,272,274,267,270,269);
		$ultra_trate = array(127,223,253,105,225,235,107,266,273,271,268,275);
		
		$this->zaloz(5,2,17500,420,"WRECKER",$wrecker_trate,0,0,0,'',1);
		$this->zaloz(5,2,17500,420,"SPORT",$sport_trate,0,0,0,'',1);
		$this->zaloz(5,2,17500,420,"COMBI",$combi_trate,0,0,0,'',1);
		
		$this->zaloz(6,4,19500,420,"MULTI",$multi_trate,0,0,0,'',2);
		$this->zaloz(10,3,24500,820,"EXTRA",$extra_trate,0,0,0,'',3);
		$this->zaloz(10,3,29200,1120,"ULTRA",$ultra_trate,0,0,0,'',3);
		$this->zaloz(10,3,39200,1120,"HYPER",$ultra_trate,0,0,0,'',4);
		$this->zaloz(10,4,59200,1120,"UBER",$ultra_trate,0,0,0,'',5);
		$this->zaloz(10,3,79200,1120,"ABSOLUT",$ultra_trate,0,0,0,'',6);
		
		########################## POHAR ##############################
		$trate = $pohar_trate;
		
		$res = $Sql->q('SELECT val FROM sys WHERE entity = "pohar"');
		if(p($res) == 0) return true;
		
		$sys = fa($res);
		
		$val = $sys['val'];
		
		if($val < 0) return true;
		
		$newVal = $val-1;
		$zalozit = false;
		
		if($val == 7 || $val == 5) { # Pondeli nebo streda (zaklada se na stredu nebo pondeli)
			$dopredu = 2;
			$zalozit = true;
		}
		
		if($val == 3) { # Nedele (zaklada se na pondeli)
			$dopredu = 3;
			$zalozit = true;
		}
		
		if($val == 0) $newVal = 7;
		
		$zalozit = true;	# QSB cup denne, rusi predchozi
		$dopredu = 1;
		
		if($zalozit == true && $this->cas == 0) {
			$datum = date("Y-m-d",time()+86400*$dopredu);
			$pocet = p($Sql->q('SELECT login FROM pohar'));
			if($pocet < 4) $pocet = 4;
			$celkem = fa($Sql->q('SELECT * FROM sys WHERE entity = "pohar_zavod"'));
			if(isset($trate[$celkem['val']])) {
				$jedna_trat[0] = $trate[$celkem['val']];
				$this->zaloz(1,$pocet+2,60000,5000,fuckDia(str_replace(' ','_',POHAR_NAZEV)),$jedna_trat,0,0,2,$datum,-1);
				$Sql->q('UPDATE sys set val = "'.($celkem['val']+1).'" WHERE entity = "pohar_zavod"');
			}
		}
		
		//$Sql->q('UPDATE sys set val = "'.$newVal.'" WHERE entity = "pohar"');
	}
	
	function zaloz($pocet,$max,$dotace,$vklad,$nazev2,$trate,$pr,$pr2,$typ,$datum,$cena) {
		global $Sql;
		while($this->zalozeno($pocet,$max,$pr,$pr2,$dotace,$typ,$nazev2)) {
			$nazev = $this->getZavodNazev($nazev2);
			if($datum == "") $datum = date("Y-m-d",time()+86400);
			$trat = $trate[rand(0,count($trate)-1)];
			$casy[0] = 13;
			$casy[1] = 13;
			$casy[2] = 16;
			$casy[3] = 19;
			$popis = "Zavod poradan systemem";
			
			$cas = $casy[rand(0,count($casy)-1)];
			
			if($typ == 2) $popis = "Dalsi exkluzivni zavod ".POHAR_NAZEV."u!";
			if($typ == 2) $cas = 0;
			
			$Sql->q('INSERT into zavody(login,nazev,popis,vklad,dotace,datum,pocet,trat,vitez,cas,prestiz,prestiz2,typ,cena) values(0,"'.$nazev.'","'.$popis.'",'.$vklad.','.$dotace.',"'.$datum.'",'.$pocet.','.$trat.',0,'.$cas.','.$pr.','.$pr2.','.$typ.','.$cena.')');
			if($typ == 2) break;
		}
	}
	
	function zalozeno($pocet,$max,$pr,$pr2,$dotace,$typ,$nazev) {
		global $Sql;
		if($typ == 2) return true;
		$result = $Sql->q('SELECT typ FROM zavody WHERE vitez = 0 AND pocet = '.$pocet.' AND typ = '.$typ.' AND prestiz = '.$pr.' AND prestiz2 = '.$pr2.' AND nazev LIKE "%'.$nazev.'%" AND dotace = '.$dotace);
		if(p($result) < $max) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function getZavodNazev($nazev) {
		global $Sql;
		$res = $Sql->q('SELECT val FROM sys WHERE entity = "zavody"');
		$row = fa($res);
		$nazev = "SYS_".$nazev."_".($row['val']+1);
		$nazev2 = $nazev;
		$nazev = "";
		$Sql->q('UPDATE sys SET val = val+1 WHERE entity = "zavody"');
		return $nazev2;
	}
		
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	################################################################################################################################################
	
	function boti() {
		global $Sql;
		$sablony = array();
		$zavody = array();
		$rasy = array();
		
		$result = $Sql->q('SELECT id, r, a, o FROM rasy ORDER BY id ASC');
		while($row = fa($result)) {
			$koef = min($row['r'], $row['a'])/2;
		
			$row['sance_s'] = $row['r'] - $koef;;
			$row['sance_c'] = $row['sance_s']+$koef*2;
			$row['sance_w'] = $row['sance_s']+$row['sance_c']+$row['a'] - $koef;
		
			$rasy[$row['id']] = $row;
		}
		
		$rasy[1]['procenta'] = 1180;
		$rasy[2]['procenta'] = 482;
		$rasy[3]['procenta'] = 939;
		$rasy[4]['procenta'] = 966;
		$rasy[5]['procenta'] = 936;
		$rasy[6]['procenta'] = 978;
		$rasy[7]['procenta'] = 1064;
		$rasy[8]['procenta'] = 739;
		$rasy[9]['procenta'] = 726;
		$rasy[10]['procenta'] = 244;
		$rasy[11]['procenta'] = 892;
		$rasy[12]['procenta'] = 855;
		
		$result = $Sql->q('SELECT id, typ, cena, kategorie, ovladatelnost, odolnost FROM boti_kluzaky ORDER BY cena ASC');
		while($row = fa($result)) {
			$sablony[$row['cena']][$row['typ']][] = $row;
		}
						
		$result = $Sql->q('SELECT id, cena, pocet, trat FROM zavody
						   WHERE vitez = 0 AND login = 0 AND typ = 0
						   ORDER BY datum DESC, RAND() ASC');
						   
		while($row = fa($result)) {
			$pocet = p($Sql->q('SELECT zavod FROM zavodnici WHERE zavod = '.$row['id']));
			if($pocet >= $row['pocet'] && $row['pocet']) continue;
			
			$zavody[$row['cena']][] = array('id' => $row['id'], 'volno' => $row['pocet']-$pocet, 'trat' => $row['trat']);
		}
		
		$row = fa($Sql->q('SELECT val FROM sys WHERE entity = "restart"'));
		$den = ceil((time()-$row['val'])/(24*60*60));
		
		$zacatky = array(0, 1, 1, 4, 8, 12, 17);
		
		for($cena=1; $cena<7; $cena++) {
			$x = max(1, $den-$zacatky[$cena]);
			$sance = 0.3*$x*$x + 0.8*$x + 8.8;
			$sance *= 1.2;
			$sance = min(400, $sance);
						
			while($sance > 0) {
				if(rand(0,99) > min($sance, 100)) continue;
				$sance -= 100;

				if(!count($zavody[$cena])) break;

				# ZAVOD
				$zid = rand(0, count($zavody[$cena])-1);
				$zavod = $zavody[$cena][$zid]['id'];
				$zavody[$cena][$zid]['volno']--;
				if(!$zavody[$cena][$zid]['volno']) 
					unset($zavody[$cena][$zid]);
				
				# RASY
				$rand_rasa = rand(1,10000);
				$soucet = 0;
				foreach($rasy as $r) {
					$soucet += $r['procenta'];
					if($soucet >= $rand_rasa) {
						$rasa = $r['id'];
						break;
					}
					
					$rasa = 12;
				}
				
				$rand_typ = rand(1, $rasy[$rasa]['sance_w']);
				$typ = 3;
				if($rand_typ < $rasy[$rasa]['sance_c']) $typ = 2;
				if($rand_typ < $rasy[$rasa]['sance_s']) $typ = 1;
				
				# SABLONY
				$sablona = $sablony[$cena][$typ][rand(0, count($sablony[$cena][$typ])-1)];
				if(!$sablona) break;
				
				$taktika = rand(1,3);
				$postoj = rand(1,3);
				
				$agresivita = $rasy[$rasa]['a'] + $sablona['odolnost'] + rand(-6, 6) - 100 + $typ*10;
				$agresivita = min($agresivita, 100);
				$agresivita = max($agresivita, -100);
				
				$trat = fa($Sql->q('SELECT trat, useky FROM trate WHERE id = '.$zavody[$cena][$zid]['trat']));
				$diff = getDiffOpt($trat['trat']);
				
				$opatrnost = 100 - (($rasy[$rasa]['r'] + 2*$sablona['ovladatelnost'])/3 + $rasy[$rasa]['a']/6 + $sablona['odolnost']/5 - sqrt($trat['useky']*$diff)/2);
				$opatrnost = min($opatrnost, 85);
				$opatrnost = max($opatrnost, 15);
				$opatrnost += rand(-7, 8);
				$opatrnost = min($opatrnost, 85);
				$opatrnost = max($opatrnost, 15);
				
				pridatBota($zavod, $sablona['id'], $rasa, $agresivita, $opatrnost, $postoj, $taktika);
			}
		}
	}
}
?>