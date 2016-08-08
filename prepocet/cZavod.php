<?php

class cZavod {
	function cZavod($id,$data) {
		$this->id = $data['id'];
		$this->typ = $data['typ'];
		$this->nazev = $data['nazev'];
		$this->cas = $data['cas'];
		$this->dotace = $data['dotace'];
		$this->predmet = $data['predmet'];
		$this->sazky = $data['sazky'];
		$this->vklady = $data['vklady'];
		$this->trat_id = $data['trat'];
		$this->login = $data['login'];
		$this->zakladatel = $data['login'];
		$this->minimum = $data['minimum'];	
	}
	
	function zavodnici() {
		global $Sql;
		
		if($this->zakladatel) {
			$pocet = p($Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$this->id.' ORDER BY id ASC'));
		} else {		
			$result = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$this->id.' AND login > 0 ORDER BY id ASC');
			$result2 = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$this->id.' AND login < 0 ORDER BY id ASC');
			$pocet = p($result) + (p($result2)/2);
		}
		
		if($pocet < $this->minimum) {
			if($this->typ == 2) {
				$Sql->q('DELETE FROM zavody WHERE id = '.$this->id);			
			} else {
				$this->odloz();
			}
			return false;
		}
		
		$result = $Sql->q('SELECT * FROM zavodnici WHERE zavod = '.$this->id.' ORDER BY id ASC');
		
		$this->hraci = array();
		for($i=0;$i<p($result);$i++) {
			$hrac = fa($result);
			$this->hraci[$hrac['login']] = new cZavodnik($hrac);
		}	
		
		return true;
	}
	
	function inic($rasy,$useky) {						# zavod se urcite pojede a tak se nactou dodatecne informace az ted, aby se setrilo a moh sem rikat, ze QSB jede na zelenou energii
		global $Sql;
		
		$prestiz = 0;
		foreach($this->hraci as $id=>$zavodnik) {
			$this->hraci[$id]->inic($rasy);
			
			if(!$this->hraci[$id]->kluzak->ok_zavod) {
				$msg = 'Protoze tvuj kluzak nebyl v poradku pri startovni kontrole zavodu [B][O]'.fuckDia($this->nazev).'[/O][/B] nemohl jsi tento zavod odjet a byl jsi vyrazen. Vklad i palivo propada jako odskodne.
					
				SYSTEM';
				sendPosta(0,$this->hraci[$id]->id,$msg);
				$Sql->q('DELETE FROM zavodnici WHERE zavod = '.$this->id.' AND login = '.$this->hraci[$id]->id);
				unset($this->hraci[$id]);
				continue;
			}
			
			if($this->hraci[$id]->prestiz > $prestiz) {
				$prestiz = $this->hraci[$id]->prestiz;
				$favorit = $this->hraci[$id]->id;
			}
		}
		
		$this->favorit = $favorit;
		$this->useky = $useky;		
		$this->trat = new cTrat($this->trat_id, $this->zakladatel);
	}
	
	function odloz() {
		global $Sql;

		switch($this->cas) {
			case 13:
				$Sql->q('UPDATE zavody SET datum = "4200-12-24", cas = 16 WHERE id = '.$this->id);
				break;
				
			case 16:
				$Sql->q('UPDATE zavody SET datum = "4200-12-24", cas = 19 WHERE id = '.$this->id);
				break;
				
			case 19:
				$Sql->q('UPDATE zavody SET datum = "4200-12-24", cas = 0 WHERE id = '.$this->id);
				break;
				
			default:
				$Sql->q('UPDATE zavody SET datum = "4200-12-24", cas = 13 WHERE id = '.$this->id);
				break;
		}
	}
	
	function odjed_zavod() {
		global $Sql;
		
		if($this->dotace > 34999) $Sql->q('UPDATE stats set zalozeni = zalozeni+1 WHERE login = '.$this->zakladatel);

		$this->koment = new cKoment($this->hraci, $this->trat->useky);
		$this->koment->useky = $this->useky;
		$this->koment->koment = '<table class="komentar">';
		
		$this->poradi = zavod($this);
		
		$this->koment->koment .= '</table>';
		
		$fp = fopen('../vypisy/komentare/'.$this->id.'_'.fileName($this->nazev).'.txt','w');
		fwrite($fp, $this->koment->koment);
		fclose($fp);
		
		$Sql->q('UPDATE zavody set vitez = 1 WHERE id = '.$this->id);
		
		foreach($this->hraci as $hrac) $hrac->kluzak->updateSkody();
		
		questy($this);
		
		$this->vyhry();			
		if($this->predmet)
			$this->vyherni_predmet();
		$this->prestize();
		$this->posta();
		$this->sazky();
		
		if($this->zakladatel) {
			$Sql->q('UPDATE postavy SET penize = penize+'.$this->vklady.' WHERE login = '.$this->login); # penize zakladateli
			finance($this->login,$this->vklady,1,6);
			$this->divaci();
		}
		
		$data = serialize($this->info);
		
		$fp = fopen('../vypisy/zavody_info/'.$this->id.'_'.fileName($this->nazev).'.dat', 'w');
		fwrite($fp, $data);
		fclose($fp);
	}
	
	function posta() {	
		foreach($this->hraci as $hrac) {
			if($hrac->posta_zavody) {
				$msg = "Závod [B]".$this->nazev."[/B] byl odjet.\n\n";
				
				if(count($this->poradi) > 0) {
					$msg .= '[O]Pořadí:[/O] ';
					foreach($this->poradi as $misto => $uid) {
						$msg .= "\n[O]".($misto+1).".[/O] ".$this->hraci[$uid]->login;
					}
				}
				
				if(count($this->hraci) > count($this->poradi)) {
					$msg .= "\n[S]-----------[/S]\n[O]Nedojeli:[/O]";
					
					foreach($this->hraci as $hrac2) {
						if(!$hrac2->kluzak->ok_zavod) {
							$msg .= "\n".$hrac2->login;
						}
					}
				}
				
				$msg .= "\n[S]-----------[/S]
						 [O]Vyhrané peníze:[/O] ".numF($hrac->vyhra)." Is
						 [O]Získaná prestiž:[/O] ".($hrac->bonus_prestiz > 0 ? '+' : '-').abs(round($hrac->bonus_prestiz));
			
				$skody1 = '';
				$skody2 = '';
			
				$skody1 .= "\n[S]-----------[/S]\n[O]Škody na tvém kluzáku:[/O]\n";
				
				foreach($hrac->kluzak->tabs as $ind=>$tab) {
					if(isset($hrac->kluzak->{$tab}['nazev'])) {
						if($hrac->kluzak->{$tab}['vydrz2'] > $hrac->kluzak->{$tab}['vydrz']) {
							$skody2 .= "[B]".$hrac->kluzak->nazvy_predmetu[$ind]."[/B] ze ".round($hrac->kluzak->{$tab}['vydrz2']/$hrac->kluzak->{$tab}['max_vydrz']*100)."% na ".round($hrac->kluzak->{$tab}['vydrz']/$hrac->kluzak->{$tab}['max_vydrz']*100)."% celkové výdrže\n";
						}
					} else {
						switch($ind) {
							case 8:
								if($hrac->kluzak->ma_pancerovani)
									$skody2 .= "[B]".$hrac->kluzak->nazvy_predmetu[$ind]." zničeno úplně[/B]\n";
								break;
								
							case 9:
								if($hrac->kluzak->ma_suspenzory)
								$skody2 .= "[B]".$hrac->kluzak->nazvy_predmetu[$ind]." zničeny úplně[/B]\n";
								break;
								
							case 10:
								if($hrac->kluzak->ma_pridavne)
								$skody2 .= "[B]".$hrac->kluzak->nazvy_predmetu[$ind]." zničen úplně[/B]\n";
								break;						
						
							default:
								$skody2 .= "[B]".$hrac->kluzak->nazvy_predmetu[$ind]." zničen úplně[/B]\n";
								break;
						}
					}	
				}
				
				if($skody2 != "") $msg .= $skody1.$skody2;
					else $msg .= "\n";
				
				$info = $this->info->hracInfo($hrac->id);
				
				$msg .= "[S]-----------[/S]
						 [O]Udělené škody:[/O] ".numF($info['dmg'])."
						 [O]Obdržené škody:[/O] ".numF($info['skody'])."
						 [S]-----------[/S]
				
						 Více informací k závodu nalezneš [B][O]<a href=\"showRace.php?id=".$this->id."\">zde</a>[/O][/B].\n\nSYSTEM";
				
				sendPosta(0,$hrac->id,$msg);
			}
		}
	}
	
	function divaci() {
		global $Sql;
		
		$divaci = $this->dotace;
		
		if($this->predmet) {
			$predmet = fa($Sql->q('SELECT cena FROM '.($this->zakladatel ? 'sklad' : 'zbozi').' WHERE id = '.$this->predmet));
		}
		
		$divaci += $predmet['cena'];
		
		$divaci += ((log(count($this->hraci)-1.8)-0.4)*2)*$this->vklady;
		
		$divaci = round($divaci);
		
		$Sql->q('UPDATE postavy set penize = penize+'.$divaci.', prestiz = prestiz+'.ZAVOD_ZALOZENI_PRESTIZ.' WHERE login = '.$this->zakladatel);
		finance($this->zakladatel,$divaci,1,4);
		
		$Sql->q('UPDATE zavody set divaci = '.abs($divaci).' WHERE id = '.$this->id);	
	}
	
	function vyhry() {
		global $Sql;
	
		if(count($this->poradi) == 0) {
			return false;
		}
	
		if($this->typ == 2) {
			foreach($this->hraci as $hrac) {
				if($hrac->id > 0) $Sql->q('UPDATE pohar SET zavody = zavody+1 WHERE login = '.$hrac->id);
			}
			
			$body = array();
			$body[0] = 11;
			$body[1] = 9;
			$body[2] = 7;
			$body[3] = 5;
			$body[4] = 3;
			$body[5] = 2;
			$body[6] = 1;
			
			foreach($body as $misto => $bod) {
				if(isset($this->poradi[$misto])) {
					if($hrac->id > 0) $Sql->q('UPDATE pohar set body = (body+'.$bod.') WHERE login = '.$this->poradi[$misto]);
				}
			}
		}
	
		$dotace = $this->dotace * 0.85;
	
		$vyhry = array();	
		switch (count($this->hraci)) {
			case 2:
				$vyhry[0] = 80;
				$vyhry[1] = 20;
				break;
			case 3:
				$vyhry[0] = 80;
				$vyhry[1] = 25;
				$vyhry[2] = 5;	
				break;
			case 4:
				$vyhry[0] = 80;
				$vyhry[1] = 30;
				$vyhry[2] = 10;
				$vyhry[3] = 5;	
				break;
			case 5:
				$vyhry[0] = 80;
				$vyhry[1] = 40;
				$vyhry[2] = 20;
				$vyhry[3] = 10;
				$vyhry[4] = 5;	
				break;
			case 6:
				$vyhry[0] = 80;
				$vyhry[1] = 50;
				$vyhry[2] = 30;
				$vyhry[3] = 15;
				$vyhry[4] = 8;
				$vyhry[5] = 5;	
				break;
			default:
				$vyhry[0] = 80;
				$vyhry[1] = 60;
				$vyhry[2] = 40;
				$vyhry[3] = 20;
				$vyhry[4] = 15;
				$vyhry[5] = 10;
				$vyhry[5] = 5;
		}
	
		if($this->poradi[0] != '') {
			if($this->poradi[0] > 0) $Sql->q('UPDATE postavy set prvni = prvni+1 WHERE login = '.$this->poradi[0]);
		}
		if($this->poradi[1] != '' && count($this->hraci) > 2) {
			if($this->poradi[1] > 0) $Sql->q('UPDATE postavy set druhy = druhy+1 WHERE login = '.$this->poradi[1]);
		}
		if($this->poradi[2] != ''  && count($this->hraci) > 3) {
			if($this->poradi[2] > 0) $Sql->q('UPDATE postavy set treti = treti+1 WHERE login = '.$this->poradi[2]);
		}
	
		foreach($this->poradi as $misto => $login) {
			$hrac = $this->hraci[$login];
			
			if($vyhry[$misto] > 0) {	
				$rasa_mod = (1+$hrac->obchodnictvi*0.8);
										
				if($hrac->staj) {
					$hrac->vyhra = round($dotace*$vyhry[$misto]/100*(100-$hrac->staj_pomer)/100*$rasa_mod);						
					$Sql->q('UPDATE staje SET kasa = kasa+'.round($dotace*$vyhry[$misto]/100*$hrac->staj_pomer/100*$rasa_mod).' WHERE id = '.$hrac->staj);		
				} else {				
					$hrac->vyhra = round($dotace*$vyhry[$misto]/100*$rasa_mod);
				}
				
				if($login > 0) {
					$Sql->q('UPDATE postavy SET penize = penize+'.$hrac->vyhra.' WHERE login = '.$login);
					finance($login, $hrac->vyhra, 1, 3);	
				}
	
				$Sql->q('UPDATE zavodnici set vyhra = '.round($dotace*$vyhry[$misto]/100*$rasa_mod).' WHERE login = '.$login.' AND zavod = '.$this->id);
			}
		
			if($login > 0)
				$Sql->q('UPDATE stats set useky = useky+'.count($this->trat->useky).' WHERE login = '.$login);
	
			$Sql->q('UPDATE zavodnici SET poradi = '.($misto+1).' WHERE login = '.$login.' AND zavod = '.$this->id);
		}	
	}
	
	function prestize() {	
		global $Sql;
		
		$poradi = array();
		
		foreach($this->hraci as $hrac) {
			$prestiz[$hrac->id] = ($hrac->prestiz < 1 ? 1 : $hrac->prestiz);
			foreach($this->poradi as $misto=>$login) {
				if($hrac->id == $login) {
					$poradi[$hrac->id] = $misto+1;
				}
			}
			if($poradi[$hrac->id] == "") $poradi[$hrac->id] = 0;
		}
		
		foreach($this->hraci as $hrac) {
			$pr = 20;
			
			foreach($poradi as $login => $misto) { # kluci s holkama, holky s klukama
				if($hrac->id != $login) {
					$zaklad = 5;
					if($hrac->kluzak->ok_zavod) { # dojeli jsme
						if($poradi[$login] > $poradi[$hrac->id]) { # jsme pred
							if($prestiz[$login] > $prestiz[$hrac->id]) { # protivnik ma vic prestize
								@$pr += $zaklad+ceil($prestiz[$login]/$prestiz[$hrac->id]*8);
							} else {
								@$pr += $zaklad+ceil($prestiz[$login]/$prestiz[$hrac->id]*2);
							}
						} elseif($poradi[$hrac->id] > $poradi[$login]) { # jsme za
							if($prestiz[$hrac->id] > $prestiz[$login]) { # protivnik ma min prestize
								@$pr -= $zaklad+ceil($prestiz[$hrac->id]/$prestiz[$login]*8);
							} else {
								@$pr -= $zaklad+ceil($prestiz[$hrac->id]/$prestiz[$login]*2);
							}					
						}
					} else { # bourame!
						$pr = -25;
					}
				}
			}		
			
			$pr += $hrac->bonus_prestiz;
			
			if($pr < -70) $pr = -70;
			if($pr > 120) $pr = 120;
			
			$pr = round($pr);
			
			if($hrac->id > 0) $Sql->q('UPDATE postavy set prestiz = prestiz + '.$pr.' WHERE login = '.$hrac->id);
			
			$hrac->bonus_prestiz = $pr;
		}	
	}
	
	function sazky() {
		global $Sql;
		$result = $Sql->q('SELECT id,login,sazka,misto,zavodnik FROM sazky WHERE zavod = '.$this->id);
		if(!$result) {
			return $this->sazky;
		}
		
		$min_sazka = -42;
	
		$vyhra = false;
		for($i=0;$i<p($result);$i++) {
			$sazka = fa($result);
		
			$misto = $sazka['misto'];
			$login = $sazka['login'];
			$zavodnik = $sazka['zavodnik'];
			$sazka2 = $sazka['sazka'];
			$sazka['vyhra'] = false;
			$Sql->q('UPDATE stats SET prosazeno = prosazeno+'.$sazka2.' WHERE login = '.$login);
		
			if($misto == -1) { # nikdo nedojede
				if(!count($this->poradi)) {
					$sazka['vyhra'] = true;
					$vyhra = true;
				}
			}
			
			if($misto == 0) {
				if(!in_array($zavodnik,$this->poradi)) {
					$sazka['vyhra'] = true;
					$vyhra = true;
				}
			}
			
			if($misto > 0) {
				foreach($this->hraci as $hrac) {
					if($hrac->id == $zavodnik) {
						if($this->poradi[$misto-1] == $zavodnik) {	
							$sazka['vyhra'] = true;
							$vyhra = true;
						}
					}
				}
			}
			if($min_sazka > $sazka2 || $min_sazka == -42) $min_sazka = $sazka2;	
			$this->sazka[] = $sazka;
		}
		
		### az sem se rozhodovalo, ktera sazka je vitezna
		### dal jsou vyhry
		
		if(!$vyhra && $this->login > 0 && $this->sazky > 0) {
			$Sql->q('UPDATE postavy SET penize = penize+'.$this->sazky.' WHERE login = '.$this->zakladatel); # penize zakladateli
			finance($this->login,$this->sazky,1,5);
			return $this->sazky;
		}
		
		if(!is_array($this->sazka)) return 0;
		
		$pomer = 0;	
		foreach($this->sazka as $ids=>$sazka) {
			if(!$sazka['vyhra']) continue;
			$pomer += $sazka['sazka']/$min_sazka;
			$this->sazka[$ids]['pomer'] = $sazka['sazka']/$min_sazka;
		}
		
		@$cislo = $this->sazky/$pomer;
		
		foreach($this->sazka as $sazka) {
			if(!$sazka['vyhra']) continue;
			@$sazka['penize'] = round($sazka['pomer']*$cislo+$this->dotace*0.25/$pomer*$sazka['pomer']);
			if($sazka['penize'] > 10*$sazka['sazka']) $sazka['penize'] = $sazka['sazka']*10;
			if($sazka['misto'] == -1) $sazka['penize'] *= 3;
			
			if($sazka['misto'] == 1) addQuest($sazka['zavodnik'],44,'');
			if($sazka['misto'] == 0) addQuest($sazka['zavodnik'],45,'');
			if($sazka['sazka'] > 9999) $questy = addQuest($sazka['login'],68,'');
			if($sazka['sazka'] > 749 && count($this->hraci) > 4 && $sazka['misto'] == 3) addQuest($sazka['login'],69,'');
			
			$Sql->q('UPDATE sazky SET vyhra = 1, penize = '.$sazka['penize'].' WHERE id = '.$sazka['id']);
			$Sql->q('UPDATE postavy SET prestiz = prestiz+'.SAZKA_VYHRA.', penize = penize+'.$sazka['penize'].' WHERE login = '.$sazka['login']);
			$Sql->q('UPDATE stats SET sazky = sazky+1 WHERE login = '.$sazka['login']);
			finance($sazka['login'],$sazka['penize'],1,7);
		}
		
		return 0;	
	}
	
	function vyherni_predmet() {
		global $Sql;
		
		if($this->zakladatel) {
			$predmet = fa($Sql->q('SELECT z.id as zid FROM sklad as s LEFT JOIN zbozi as z ON z.typ = s.typ AND z.zbozi = s.zbozi WHERE s.id = '.$this->predmet));
			$Sql->q('UPDATE sklad set login = '.$this->poradi[0].' WHERE id = '.$this->predmet);
			$Sql->q('UPDATE zavody set predmet = '.($predmet['zid']).' WHERE id = '.$this->id);
		} else {				
			$tabs3[1] = "podvozky";
			$tabs3[2] = "motory";
			$tabs3[3] = "drzaky";
			$tabs3[4] = "chladice";
			$tabs3[5] = "desky";
			$tabs3[6] = "brzdy";
			$tabs3[7] = "zdroje";
			$tabs3[8] = "pancerovani";
			$tabs3[9] = "suspenzory";
			$tabs3[10] = "p_motory";
			$tabs3[11] = "droidi";
		
			$predmet = fa($Sql->q('SELECT zbozi, typ, cena FROM zbozi WHERE id = '.$this->predmet));
			$predmet = array_merge($predmet, fa($Sql->q('SELECT vydrz FROM '.$tabs3[$predmet['typ']].' WHERE id = '.$predmet['zbozi'])));
			$Sql->q('INSERT into sklad (login, zbozi, typ, umisteni, cena, cena2, vydrz) values('.$this->poradi[0].', '.$predmet['zbozi'].','.$predmet['typ'].',0,'.$predmet['cena'].',0,'.$predmet['vydrz'].')');
		}
	}
}
?>