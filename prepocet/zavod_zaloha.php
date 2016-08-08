<?php
define('TEST', false);
define('TICK', 1/18);
define('DELKA', 20);
define('RANGE', 10);
define('ZRYCHLENI', 250);
define('ZAKLAD_DMG', 40);

function zavod($zavod) {
	if(TEST) echo $zavod->nazev;

	$zavod->info = new cZavodInfo($zavod);
	$zavod->souboje = new cSouboje($zavod->hraci);
	$zavod->prvni = 0;

	$zavod->celkove_poradi = array();
	$zavod->poradi = array();
	
	$rand_predmety = array();
	$rand_procenta = array(	1 => 35, # Podvozky
							2 => 20, # Motory
							3 => 11, # Držáky
							4 => 10, # Chladiče
							5 => 15, # Palubní desky
							6 => 8, # Brzdy
							7 => 10, # Zdroje
							8 => 30, # Pancéřování
							9 => 13, # Suspenzory
						   10 => 13);# Přídavné motory

	foreach($rand_procenta as $predmet => $procenta)
		for($i = 0; $i < $procenta; $i++)
			$rand_predmety[] = $predmet;

	foreach($zavod->hraci as $hrac) $zavod->poradi[] = $hrac->id;	# vytvorime poradi
	
	$zavod->koment->pridej('start', 0, $zavod->poradi);
	$zavod->koment->pridej('fav', 0, $zavod->favorit);
	
######################################################################################## HLAVNI CAST
	$zavod->odjet = false;	
	$ticks = 0;
	
	while(!$zavod->odjet && count($zavod->poradi) > 1) {	
		$ticks++;
			
		if(TEST) echo '<hr />'.round($ticks*TICK*60).' min<br /><div>';
		
		foreach($zavod->hraci as $h=>$hrac) {	
			
			$hrac->kluzak->refresh(); # update a zjisteni jestli je hrac provozu a jizdyschopnej nebo jestli je to walking dead
			
			if(!$hrac->kluzak->ok_zavod) continue; # kdyz uz mu to nejede, tak mu to proste nejede, to po me nechtejte, delit nulou se nema
			if($hrac->dojel) continue; # tak tohle ani nebudu komentovat ...wait!

			if($hrac->usek) { # quest probourani se z posledni pozice
				foreach($zavod->poradi as $misto=>$login) {
					if($login == $hrac->id && $misto+1 > $hrac->nejhorsi) $hrac->nejhorsi = $misto+1;
				}
			}
			
			if($hrac->agresivita < 0) $hrac->kluzak->rychlost += $hrac->agresivita;
			
			# PREHRATI
			if($hrac->kluzak->prehrati > 0) {	# hazarduje hajzlik s chlazenim, ale ja mu to spocitam!
				if(rand(0,99) < $hrac->kluzak->prehrati*3) { 	# spocitam jakoze tady, to mel bejt vtip
					$chlazeni_predmet = array(2,3);
					
					if($hrac->kluzak->ma_suspenzory) 
						$chlazeni_predmet[] = 9;
					
					if($hrac->kluzak->ma_pridavne) 
						$chlazeni_predmet[] = 10;
					
					$predmet = $chlazeni_predmet[rand(0,count($chlazeni_predmet)-1)];

					$skoda_chlazeni = rand($hrac->kluzak->{$hrac->kluzak->tabs[$predmet]}['vydrz']/10,$hrac->kluzak->{$hrac->kluzak->tabs[$predmet]}['vydrz']); # 10% - 100% poskozeni chlazenyho predmetu
					$skoda_chladic = rand($hrac->kluzak->chladic['vydrz']/5, $hrac->kluzak->chladic['vydrz']);
					
					$hrac->kluzak->poskod($predmet, $skoda_chlazeni);
					$hrac->kluzak->poskod(4, $skoda_chladic); # 20% - 100% poskozeni chladice
					
					$zavod->info->udalost($hrac->usek, $hrac->id, 'chlazeni', $predmet, $skoda_chladic, $skoda_chlazeni);
					
					if(!$hrac->kluzak->ok_zavod) {
						$hrac->bonus_prestiz -= 10;
						
						$zavod->koment->pridej('chlazeni',$hrac->usek,$hrac->id);
						$zavod->info->fatal();
						continue;
					} else {
						$zavod->koment->pridej('chlazeni2',$hrac->usek,$hrac->id);
					}
				}
			} 
			# KONEC PREHRATI							
			
			# BOURANI DO TRATI
				
			# reflexy:	0% -5% k rychlosti useku	+10% k nebezpeci
			#		  100% +20% k rychlosti useku	-15% k nebezpeci
			# nebezpeci: +/- 8% k R
			
			$usek_r = $zavod->useky[$zavod->trat->useky[$hrac->usek]]['rychlost'];			
			$usek_r += $hrac->reflexy/4-7; 		  # R podle reflexu +(-7;18)			
			$usek_r += $hrac->kluzak->ovladatelnost/5-10; # R podle ovladatelnost +(-10;10)
			
			$usek_n = $zavod->useky[$zavod->trat->useky[$hrac->usek]]['nebezpeci'];
			$usek_n += (100-$hrac->reflexy)/4-15; 	  # N podle reflexu +(10;-15)
			
			# opatrnost 0.3*R - 100%
			#			100*R - 0%
			$usek_r_old = $usek_r;
			
			if($hrac->opatrnost < 50) {
				$usek_r += abs((($hrac->opatrnost-50)/50)*(100-$usek_r));
			}
			if($hrac->opatrnost > 50) {
				$usek_r *= -0.02*$hrac->opatrnost+2;
			}
			
			$usek_n += 1.25*($usek_r-$usek_r_old);			
			$usek_n += $hrac->agresivita/20+2; # malus za agresivitu jizdy do nebezpeci
			
			$usek_r = round($usek_r);			
			$usek_n = round($usek_n);
			
			$usek_r = max($usek_r,0);
			$usek_r = min($usek_r,100);
			
			# konec uprav pres reflexy a ovladatelnost a prichazi samotna sance na bourani
			
			$test_crash = '';
			
			$sance = $usek_n-0.8*$hrac->kluzak->prumer(true, $hrac->kluzak->ovladatelnost, 7, $hrac->kluzak->ovladatelnost*$hrac->reflexy/100, 3);

			if(rand(0,99) < $sance && 		# NEMYSLIS, ZAPLATIS!
			   $hrac->usek 		   && 
			   $hrac->rychlost > $hrac->reflexy/2 &&
			   $hrac->posledni_bourani != $hrac->usek) {
																									# Alea iacta est!
				$dmg = abs($hrac->rychlost/(rand(8,16)/10));										# pokud teda nejsme takovi kingove, ze nenabourame v tak pomaly rychlosti...
																									# a neni to start
				$dmg += $dmg*(-0.353*$hrac->opatrnost+10)/100; # opatrnost (-20%,+10%)
				$dmg *= (-0.006*$hrac->kluzak->odolnost^2-0.3*$hrac->kluzak->odolnost+100)/100; # odolnost (100%,40%)
				$dmg = abs($dmg*0.8);	
				
				$predmet = $hrac->kluzak->getRandPredmet($rand_predmety);

				if($hrac->kluzak->ma_pancerovani) {
					$ochrana = $hrac->kluzak->pancerovani['ochrana']/100;
					$dmg_pancir = $dmg*$ochrana;
					$dmg_kluzak = abs($dmg-$dmg_pancir);
					
					# Rhino skin 
					if($dmg_pancir > 79) $hrac->questy = addQuest($hrac->id,79,$hrac->questy);
					
					$hrac->kluzak->poskod(8,$dmg_pancir);
					$hrac->kluzak->poskod($predmet,$dmg_kluzak);
					
					$zavod->info->udalost($hrac->usek, $hrac->id, 'crash', $predmet, $dmg_kluzak, $dmg_pancir);
					
				} else {
					$hrac->kluzak->poskod($predmet,$dmg);
					$zavod->info->udalost($hrac->usek, $hrac->id, 'crash', $predmet, $dmg, 0);
				}					
								
				$zavod->koment->pridej('crash1',$hrac->usek,$hrac->id);
				
				# Buldozer
				if($dmg > 199) $hrac->buldozer = 42;
				
				if(TEST) $test_crash = '<tr><td style="color: red">CRASH</td><td>'.round($hrac->rychlost).' km/h, '.round($dmg).' dmg</td></tr>';
				if(TEST) echo '<span style="color: red">'.$hrac->usek.' '.$hrac->login.' CRASH - '.round($dmg).' dmg ('.$hrac->kluzak->tabs[$predmet].' '.@round($hrac->kluzak->{$hrac->kluzak->tabs[$predmet]}['vydrz']/$hrac->kluzak->{$hrac->kluzak->tabs[$predmet]}['max_vydrz']*100).'%)</span><br />';
				
				$hrac->kluzak->refresh();
				if(!$hrac->kluzak->ok_zavod) {
				
					$zavod->info->fatal();
					
					# Nervosity
					if($zavod->poradi[0] == $hrac->id) $hrac->questy = addQuest($hrac->id,78,$hrac->questy);
					
					$zavod->koment->pridej('tcrash',$hrac->usek,$hrac->id);
					continue;
				}
				
				$hrac->rychlost *= min(abs(1-$dmg/$hrac->rychlost), 0.9);
				
				$hrac->posledni_bourani = $hrac->usek;
				
			} # KONEC BOURANI DO TRATI
			
			# zrychlime/zpomalime
			
			$max_rychlost = $hrac->kluzak->rychlost*$usek_r/100;
			
			$zrychleni = ZRYCHLENI*($hrac->kluzak->zrychleni/100);
			$zrychleni *= rand(90,100)/100;
						
			$konec_useku = DELKA-($hrac->vzdalenost-DELKA*$hrac->usek);
			
			$rychlost = $hrac->rychlost+$zrychleni;
			if($rychlost > $max_rychlost) $rychlost = $max_rychlost;
			if($rychlost > $hrac->kluzak->rychlost) $rychlost = $hrac->kluzak->rychlost;
			
			if($rychlost*TICK > $konec_useku) { # prejeli bychom pres hranici useku
			
				$hrac->rychlost += $zrychleni/**($konec_useku/DELKA)*/;
				if($hrac->rychlost > $max_rychlost) $hrac->rychlost = $max_rychlost;
				if($hrac->rychlost > $hrac->kluzak->rychlost) $hrac->rychlost = $hrac->kluzak->rychlost;
				
				if($hrac->usek+1 == $zavod->trat->delka) {					
					$hrac->cas = $ticks*TICK+$konec_useku/$hrac->rychlost;
					$hrac->dojel = true;
					$zavod->celkove_poradi[] = $hrac->id;
					continue;
				}
				
				$hrac->usek++;
				
				$zbyvajici_cas = TICK-$konec_useku/$hrac->rychlost;
				
				# ZNOVA VYGENERUJEM USEK_R, NEBEZPECI NEPOTREBUJEM
				
				# reflexy:	0% -5% k rychlosti useku	+10% k nebezpeci
				#		  100% +20% k rychlosti useku	-15% k nebezpeci
				# nebezpeci: +/- 8% k R
				
				$usek_r = $zavod->useky[$zavod->trat->useky[$hrac->usek]]['rychlost'];			
				$usek_r += $hrac->reflexy/4-7; 		  # R podle reflexu +(-7;18)			
				$usek_r += $hrac->kluzak->ovladatelnost/5-10; # R podle ovladatelnost +(-10;10)			
				
				# opatrnost 0.3*R - 100%
				#			100*R - 0%
				$usek_r_old = $usek_r;
				
				if($hrac->opatrnost < 50) {
					$usek_r += abs((($hrac->opatrnost-50)/50)*(100-$usek_r));
				}
				if($hrac->opatrnost > 50) {
					$usek_r *= -0.02*$hrac->opatrnost+2;
				}
				
				$usek_r = round($usek_r);	
				
				$usek_r = max($usek_r,0);
				$usek_r = min($usek_r,100);
				
				$max_rychlost = $hrac->kluzak->rychlost*$usek_r/100;
				
				if($hrac->rychlost > $max_rychlost) $hrac->rychlost = $max_rychlost;
				
				$hrac->vzdalenost += $hrac->rychlost*$zbyvajici_cas+$konec_useku;
					
			} else {
				$hrac->rychlost += $zrychleni;	
															
				if($hrac->rychlost > $max_rychlost) $hrac->rychlost = $max_rychlost;
				if($hrac->rychlost > $hrac->kluzak->rychlost) $hrac->rychlost = $hrac->kluzak->rychlost;
							
				$hrac->vzdalenost += $hrac->rychlost*TICK;				
			}

			if(TEST) echo '<!--<div style="display: inline-block; margin-left: 40px"><strong>'.$hrac->login.'</strong><br />
							  <table cellspacing="2" cellpadding="2" style="margin-left: 15px">
			   					<tr><td>usek:</td><td>'.$zavod->useky[$zavod->trat->useky[$hrac->usek]]['nazev'].' ('.$hrac->usek.')</td></tr>
			   					<tr><td>rychlost:</td><td>'.round($hrac->rychlost).' km/h</td></tr>
			   					<!--<tr><td>usek_r:</td><td>'.round($usek_r).' %</td></tr>
			   					<tr><td>sance:</td><td>'.round($sance).' %</td></tr>
								<tr><td>vzdalenost:</td><td>'.round($hrac->vzdalenost).' km</td></tr>
								'.$test_crash.'
							  </table>
							</div>//-->';
			
		} # KONEC FOREACH HRACI
		
		# SOUBOJE		
		
		$utocnici = $zavod->souboje->utocnici($ticks); // vsichni potencionalni utocnici serazeny podle agresivity rasy a poradi
		
		if(count($utocnici)) {
			foreach($utocnici as $uid) {
				$utocnik = $zavod->hraci[$uid];
			
				$obet = $zavod->souboje->souper($utocnik, RANGE);
				
				if($obet) {		
					$utocnik->posledni_utok = $utocnik->usek;
					$obet = $zavod->hraci[$obet];
					$sance = $zavod->souboje->sance_na_souboj($utocnik, $obet);
							
					if(TEST) echo '<br /><strong>'.$utocnik->login.' utoci na '.$obet->login.'</strong><br />sance: '.$sance.'%';
					
					if(rand(0,100) < $sance) { # zasah a souboj
# SOUBOJ				
						$utocnik->bonus_prestiz += 3;
								
						$dmg = ZAKLAD_DMG;
						$dmg *= $utocnik->kluzak->odolnost/30;
						
						if($utocnik->agresivita == 0) {
							$dmg *= 0.85;
						} else {
							switch($utocnik->postoj) {
								case 1:
									$dmg *= 1.2;
									break;
									
								case 3:
									$dmg *= 0.7;
									break;
							}
						}
						
						$dmg *= ($utocnik->kluzak->prumer(true, $utocnik->agrese, 4, $obet->agrese, 1)+50)/100;
						$dmg *= 1+$utocnik->agresivita/200;
											
						$pomer = 70;
						if($utocnik->agresivita == 0) $pomer = 62; 
						
						$pomer += ($utocnik->agrese-$obet->agrese)/3;
						$pomer += 1.6*($utocnik->kluzak->odolnost-$obet->kluzak->odolnost)/8;
						$pomer += rand(0,8)-4;
						
						$pomer = min(95, $pomer);
						$pomer = max(5, $pomer);
					
						$dmg1 = $dmg*$pomer/100;
						$dmg2 = $dmg-$dmg1;
						
						$dmg1 -= $dmg1*$obet->kluzak->odolnost/1000*3;
						$dmg2 -= $dmg2*$utocnik->kluzak->odolnost/400;
					
						$zpomaleni1 = $utocnik->odolnost/2+(100-$utocnik->odolnost/2)*$pomer/100+5;
						$zpomaleni2 = $obet->odolnost/2+(100-$obet->odolnost/2)*(100-$pomer)/100+5;
									
						$predmety1 = array();
						$predmety2 = array();
					
						if($utocnik->agresivita == 0) $utocnik->postoj = rand(1,3);
						
						switch($utocnik->postoj) {
							case 1:
								$predmety1 = array($utocnik->kluzak->getRandPredmet($rand_predmety));
								$predmety2 = array($obet->kluzak->getRandPredmet($rand_predmety));
								$zpomaleni1 += 8;
								$zpomaleni2 += 8;
								$dmg1 *= 1.2;
								break;
								
							case 2:
								while(count($predmety1) < rand(1,3)) {
									$predmet = $utocnik->kluzak->getRandPredmet($rand_predmety);
									if(!in_array($predmet, $predmety1)) {
										$predmety1[] = $predmet;
									}
								}
								
								while(count($predmety2) < rand(1,3)) {
									$predmet = $obet->kluzak->getRandPredmet($rand_predmety);
									if(!in_array($predmet, $predmety2)) {
										$predmety2[] = $predmet;
									}
								}
								break;
								
							case 3:
								$zpomaleni1 += 2;
								$zpomaleni2 -= 10;
								$dmg1 *= 0.7;
								
								while(count($predmety1) < rand(2,4)) {
									$predmet = $utocnik->kluzak->getRandPredmet($rand_predmety);
									if(!in_array($predmet, $predmety1)) {
										$predmety1[] = $predmet;
									}
								}
								
								while(count($predmety2) < rand(2,4)) {
									$predmet = $obet->kluzak->getRandPredmet($rand_predmety);
									if(!in_array($predmet, $predmety2)) {
										$predmety2[] = $predmet;
									}
								}
								break;
						}
						
						$zpomaleni1 = max($zpomaleni1, 10);
						$zpomaleni2 = max($zpomaleni2, 10);
						
						$utocnik->rychlost *= $zpomaleni1/100;
						$obet->rychlost    *= $zpomaleni2/100;
					
						$predmety_dmg1 = array();
						$predmety_dmg2 = array();
						
						### UTOCNIK POSKOZENI
						
						$dmg_tmp = $dmg2;						
						if($utocnik->kluzak->ma_pancerovani) {
							$dmg_tmp *= (100-$utocnik->kluzak->pancerovani['ochrana'])/100;
							$predmety_dmg1[8] = $dmg2-$dmg_tmp;
							$utocnik->kluzak->poskod(8, $predmety_dmg1[8]);
							
							if($predmety_dmg1[8] > 79)
								$utocnik->questy = addQuest($utocnik->id,79,$utocnik->questy);
						}					
						
						for($h=0;$h<count($predmety1);$h++) {
							if(!isset($predmety1[$h+1])) {
								$p = 1;
							} else {
								$p = rand(0,50)/100;
							}
							
							$dmg_tmp2 = round($p*$dmg_tmp);
							
							$predmety_dmg1[$predmety1[$h]] += $dmg_tmp2;
							$utocnik->kluzak->poskod($predmety1[$h], $dmg_tmp2);
							$dmg_tmp -= $dmg_tmp2;							
						}	
						
						### OBET POSKOZENI
						
						$dmg_tmp = $dmg1;						
						if($obet->kluzak->ma_pancerovani) {
							$dmg_tmp *= (100-$obet->kluzak->pancerovani['ochrana'])/100;
							$predmety_dmg2[8] = $dmg1-$dmg_tmp;
							$obet->kluzak->poskod(8, $predmety_dmg2[8]);
							
							if($predmety_dmg2[8] > 79)
								$obet->questy = addQuest($obet->id,79,$obet->questy);
						}
						
						for($h=0;$h<count($predmety2);$h++) {
							if(!isset($predmety2[$h+1])) {
								$p = 1;
							} else {
								$p = rand(0,50)/100;
							}
							
							$dmg_tmp2 = round($p*$dmg_tmp);
							
							$predmety_dmg2[$predmety2[$h]] = $dmg_tmp2;
							$obet->kluzak->poskod($predmety2[$h], $dmg_tmp2);
							$dmg_tmp -= $dmg_tmp2;							
						}
						
						$zavod->info->udalost($utocnik->usek, $utocnik->id, 'souboj', $obet->id, 
											  $dmg1, $dmg2, $predmety_dmg1, $predmety_dmg2,
											  $zpomaleni1, $zpomaleni2);
						
						$zavod->koment->pridej('crash2', $utocnik->usek, array($utocnik->id, $obet->id));
						
						if(!$utocnik->kluzak->ok_zavod) {
							$zavod->info->fatal1();
							$obet->bonus_prestiz += 10;
							$zavod->koment->pridej('crash2', $utocnik->usek, $utocnik->id);
						}
						
						if(!$obet->kluzak->ok_zavod) {
							$utocnik->bonus_prestiz += 5;
							$zavod->info->fatal2();
							$zavod->koment->pridej('crash2', $utocnik->usek, $obet->id);
							
							# Pwnage
							if($zavod->poradi[0] == $obet->id && 
							   $zavod->poradi[1] == $utocnik->id) $utocnik->questy = addQuest($utocnik->id,29,$utocnik->questy);
						}
						
						if(TEST) echo '<br />pomer: '.round($pomer).'%
									   <br />dmg: '.round($dmg2).' / '.round($dmg1).'
									   <br />zpomaleni: '.round($zpomaleni1).'% / '.round($zpomaleni2).'%
									   <br />predmety: '.implode(',',$predmety1).' | '.implode(',',$predmety2);
					
					} else { # uhyb
					
						$obet->bonus_prestiz += 5;
					
						if($obet->obet == $utocnik->id) $obet->oracle++;
					
						$usek_r = $zavod->useky[$zavod->trat->useky[$utocnik->usek]]['rychlost'];			
						$usek_r += $hrac->reflexy/4-7; 		  # R podle reflexu +(-7;18)			
						$usek_r += $hrac->kluzak->ovladatelnost/5-10; # R podle ovladatelnost +(-10;10)
						
						$usek_n = $zavod->useky[$zavod->trat->useky[$utocnik->usek]]['nebezpeci'];
						$usek_n += (100-$utocnik->reflexy)/4-15; 	  # N podle reflexu +(10;-15)
						
						# opatrnost 0.3*R - 100%
						#			100*R - 0%
						$usek_r_old = $usek_r;
						
						if($hrac->opatrnost < 50) {
							$usek_r += abs((($utocnik->opatrnost-50)/50)*(100-$usek_r));
						}
						if($hrac->opatrnost > 50) {
							$usek_r *= -0.02*$utocnik->opatrnost+2;
						}
						
						$usek_n += 1.25*($usek_r-$usek_r_old);			
						$usek_n += 5*$utocnik->agresivita/100+2; # malus za agresivitu jizdy do nebezpeci
						
						$usek_r = round($usek_r);			
						$usek_n = round($usek_n);
						
						$usek_r = max($usek_r,0);
						$usek_r = min($usek_r,100);
						
						$sance = $usek_n-0.8*$utocnik->kluzak->prumer(true, $utocnik->kluzak->ovladatelnost, 7, $utocnik->kluzak->ovladatelnost*$utocnik->reflexy/100, 3);
			
						$sance += $utocnik->agresivita*max(0,(100-$sance-10))/100;
			
						if(rand(0,99) < $sance && 		
						   $utocnik->rychlost > $utocnik->reflexy/2) {
																												# Alea iacta est!
							$dmg = abs($utocnik->rychlost/(rand(8,16)/10));										# pokud teda nejsme takovi kingove, ze nenabourame v tak pomaly rychlosti...
																												
							$dmg += $dmg*(-0.353*$utocnik->opatrnost+10)/100; # opatrnost (-20%,+10%)
							$dmg *= (-0.006*$utocnik->kluzak->odolnost^2-0.3*$utocnik->kluzak->odolnost+100)/100; # odolnost (100%,40%)
							$dmg = abs($dmg);	
							
							$predmet = $utocnik->kluzak->getRandPredmet($rand_predmety);
			
							if($utocnik->kluzak->ma_pancerovani) {
								$ochrana = $utocnik->kluzak->pancerovani['ochrana']/100;
								$dmg_pancir = $dmg*$ochrana;
								$dmg_kluzak = abs($dmg-$dmg_pancir);
								
								# Rhino skin 
								if($dmg_pancir > 79) $utocnik->questy = addQuest($utocnik->id,79,$utocnik->questy);
								
								$utocnik->kluzak->poskod(8,$dmg_pancir);
								$utocnik->kluzak->poskod($predmet,$dmg_kluzak);
								
								$zavod->info->udalost($utocnik->usek, $utocnik->id, 'uhyb', $obet->id, $predmet, $dmg_kluzak, $dmg_pancir);
								
							} else {
								$utocnik->kluzak->poskod($predmet,$dmg);
								$zavod->info->udalost($utocnik->usek, $utocnik->id, 'uhyb', $obet->id, $predmet, $dmg, 0);
							}					
						
							if(TEST) echo '<br /><span style="color: red">'.$utocnik->login.' CRASH uhybu - '.round($dmg).' dmg ('.$utocnik->kluzak->tabs[$predmet].' '.@round($utocnik->kluzak->{$utocnik->kluzak->tabs[$predmet]}['vydrz']/$utocnik->kluzak->{$utocnik->kluzak->tabs[$predmet]}['max_vydrz']*100).'%)</span><br />';
							
							$utocnik->kluzak->refresh();
							if(!$utocnik->kluzak->ok_zavod) {
					
								$obet->bonus_prestiz += 10;
								
								$zavod->info->fatal();
								$zavod->koment->pridej('tcrash',$utocnik->usek,$utocnik->id);
								continue;
							} else {
								$zavod->koment->pridej('uhnul',$utocnik->usek,array($utocnik->id, $obet->id));
							}
							
							$utocnik->rychlost *= min(abs(1-$dmg/$utocnik->rychlost), 0.9);
							
						} # KONEC BOURANI DO TRATI	
						  else {
						  	$zavod->info->udalost($utocnik->usek, $utocnik->id, 'uhyb', $obet->id, 0, 0, 0);	  
						}				
					}
				}				
			}
		}
	
		# KONEC SOUBOJU		
		
		# PORADI 
		$zavod->poradic = array();
		$zavod->poradi = array();
		
		$zavod->odjet = true;
		
		foreach($zavod->hraci as $hrac) {
			$zavod->poradic[$hrac->id] = $hrac->vzdalenost;
			if(!$hrac->dojel && $hrac->kluzak->ok_zavod) $zavod->odjet = false;
		}
		
		asort($zavod->poradic);
		//$zavod->poradic = array_reverse($zavod->poradic);
		
		$jezdci = array_keys($zavod->poradic);
		
		if(TEST) echo '<br />';
		
		foreach($jezdci as $misto => $jezdec) {
			foreach($zavod->hraci as $hrac) {
				if($hrac->id == $jezdec && $hrac->kluzak->ok_zavod) {
					$zavod->poradi[] = $jezdec;
					$hrac->poradi = count($zavod->poradi);		
					
					if(TEST) {
						echo count($zavod->poradi).'. '.$hrac->login;
						if(!$misto) {
							$prvni = $hrac->vzdalenost;
						} else {
							echo ' +'.round($prvni-$hrac->vzdalenost).' km';
						}
						
						echo '<br />';
					}							
				}
			}
		}
		
		$zavod->poradi = array_reverse($zavod->poradi);
		
		if($zavod->poradi[0] != $zavod->prvni && $zavod->prvni != 0) {
			$zavod->prvni = $zavod->poradi[0];
			$zavod->koment->pridej('vedeni', $zavodi->hraci[$poradi[0]]->usek, array($zavodi->poradi[0]));
		}
		
		$zavod->info->tick($zavod);
		
		if(TEST) echo '</div>';
		# KONEC PORADI		
	}	
	
	# PORADI 
	$zavod->poradic = array();
	$zavod->poradi = array();
	
	$zavod->odjet = true;
	
	foreach($zavod->hraci as $hrac) {
		$zavod->poradic[$hrac->id] = $hrac->vzdalenost;
	}
	
	asort($zavod->poradic);
	
	$jezdci = array_keys($zavod->poradic);
	
	foreach($jezdci as $misto => $jezdec) {
		foreach($zavod->hraci as $hrac) {
			if($hrac->id == $jezdec && $hrac->kluzak->ok_zavod && !$hrac->dojel) {
				$zavod->poradi[] = $jezdec;
				$hrac->poradi = count($zavod->poradi);								
			}
		}
	}
		
	$zavod->poradi = array_reverse($zavod->poradi);
	
	foreach($zavod->poradi as $login) 
		$zavod->celkove_poradi[] = $login;
		
	$zavod->poradi = $zavod->celkove_poradi;

	if(count($zavod->poradi) > 1) {
		$zavod->koment->pridej('finish',count($zavod->trat->useky)-1,$zavod->poradi);
	} elseif(count($zavod->poradi) == 1) {
		$zavod->koment->pridej('finish_one',count($zavod->trat->useky)-1,$zavod->poradi);
	} elseif(count($zavod->poradi) == 0) {
		$zavod->koment->pridej('finish_no',count($zavod->trat->useky)-1,$zavod->poradi);
	}
	
	return $zavod->poradi;	
}
?>