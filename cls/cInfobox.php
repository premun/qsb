<?php

class cInfobox {
	/*#################
	nová pošta	
	nových ve fóru	
	hrácu online
	-------------------
	neodjeté závody
	opravárské smlouvy
	otevrené sázky
	opravované predmety
	opravené předměty
	ceka na opravu
	volni droidi
	-------------------
	dny na pujcku
	nabídky do stáje
	#################*/

	function cInfobox() {
		$this->rychle_info = $_SESSION['rychle_info'];
		
		if(!count($_SESSION['infobox'])) {
			$this->load();
		} else {
			$this->data = $_SESSION['infobox'];
			$this->update();
		}		
	}
	
	function load() {
		global $Sql;
	
		$data = array();
		$i = 0;

		if($this->rychle_info[$i]) {
			# posta
			$data['posta'] = p($Sql->q('SELECT komu FROM posta WHERE komu = '.UID.' AND (status = 4 OR status = 0)'));
		}

		if($this->rychle_info[++$i]) {
			# forum
			$fora = fa($Sql->q('SELECT forum FROM hraci WHERE id = '.UID));
			$ids = explode(',',$fora['forum']);
			$new = 0;
			for($j=1;$j<8;$j++) {
				$new += p($Sql->q('SELECT place FROM forum WHERE place = '.$j.' AND id > '.($ids[$j-1] == "" ? 0 : $ids[$j-1])));
			}
	
			$result = $Sql->q('SELECT * FROM stajovnici WHERE login = '.UID);
			if(p($result) > 0) {
				$row = fa($result);
				
				$stajovych = p($Sql->q('SELECT place FROM forum WHERE place = "s'.$row['staj'].'" AND cas > '.$row['forum']));
				$new += $stajovych;
			}
			
			$data['forum'] = $new;
		}

		if($this->rychle_info[++$i]) {
			# online
			$data['online'] = p($Sql->q('SELECT id FROM hraci WHERE logged = 1 AND cas > '.(time()-60*15)));
		}

		if($this->rychle_info[++$i]) {
			# zavody
			$data['zavody'] = p($Sql->q('SELECT z.id FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 0'));
		}

		if($this->rychle_info[++$i]) {
			# sazky
			$data['sazky'] = p($Sql->q('SELECT s.id FROM sazky as s LEFT JOIN zavody as z ON z.id = s.zavod WHERE s.login = '.UID.' AND z.vitez = 0'));
		}

		if($this->rychle_info[++$i]) {
			# opravy
			$data['opravy'] = p($Sql->q('SELECT login FROM sklad WHERE typ != 11 AND login = '.UID.' AND umisteni > '.time()));
		}

		if($this->rychle_info[++$i]) {
			# opraveno
			$data['opraveno'] = p($Sql->q('SELECT login FROM sklad WHERE typ != 11 AND login = '.UID.' AND typ != 11 AND umisteni > 1000 AND umisteni < '.time()));
		}

		if($this->rychle_info[++$i]) {
			# opraveno
			$data['ceka'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND umisteni < 0'));
		}

		if($this->rychle_info[++$i]) {
			# droidi
			$data['droidi'] = 0;
			if($celkem = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND typ = 11'))) {
				$opravujici = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND typ = 11 AND umisteni > '.time()));
				$data['droidi'] = ($celkem-$opravujici).'/'.$celkem;
			}	
		}
		
		if($this->rychle_info[++$i]) {
			# smlouvy
			$data['smlouvy'] = p($Sql->q('SELECT umisteni FROM sklad WHERE umisteni = '.(-1*UID)));
		}
	
		if($this->rychle_info[++$i]) {
			# pujcka
			$data['pujcka'] = 0;
			$result = $Sql->q('SELECT splatnost FROM pujcky WHERE hrac = '.UID.' AND typ="P"');
			if(p($result)) {
				$row = fa($result);
				$data['pujcka'] = $row['splatnost'];
				if($data['pujcka'] < 1) $data['pujcka'] = 'O';
			}	
		}

		if($this->rychle_info[++$i]) {
			# staj
			$data['staj'] = p($Sql->q('SELECT login FROM smlouvy WHERE login = '.UID));
		}
			
		$this->data = $data;
		$_SESSION['infobox'] = $data;
	}
	
	function update() {	
		global $Sql;
		
		$data = $this->data;
		$i = 0;

		if($this->rychle_info[$i]) {
			# posta
			$data['posta'] = p($Sql->q('SELECT komu FROM posta WHERE komu = '.UID.' AND (status = 4 OR status = 0)'));
		}
		
		if($this->rychle_info[++$i]) {
			# forum
			$fora = fa($Sql->q('SELECT forum FROM hraci WHERE id = '.UID));
			$ids = explode(',',$fora['forum']);
			$new = 0;
			for($j=1;$j<8;$j++) {
				$new += p($Sql->q('SELECT place FROM forum WHERE place = '.$j.' AND id > '.($ids[$j-1] == "" ? 0 : $ids[$j-1])));
			}
	
			$result = $Sql->q('SELECT * FROM stajovnici WHERE login = '.UID);
			if(p($result) > 0) {
				$row = fa($result);
				
				$stajovych = p($Sql->q('SELECT place FROM forum WHERE place = "s'.$row['staj'].'" AND cas > '.$row['forum']));
				$new += $stajovych;
			}
			
			$data['forum'] = $new;
		}

		if($this->rychle_info[++$i]) {
			# online
			$data['online'] = p($Sql->q('SELECT id FROM hraci WHERE logged = 1 AND cas > '.(time()-60*15)));
		}
		
		if($this->rychle_info[++$i]) {
			# zavody
			$data['zavody'] = p($Sql->q('SELECT z.id FROM zavody as z LEFT JOIN zavodnici as za ON za.zavod = z.id WHERE za.login = '.UID.' AND z.vitez = 0'));
		}

		if($this->rychle_info[++$i]) {
			# sazky
			$data['sazky'] = p($Sql->q('SELECT s.id FROM sazky as s LEFT JOIN zavody as z ON z.id = s.zavod WHERE s.login = '.UID.' AND z.vitez = 0'));
		}

		if($this->rychle_info[++$i]) {
			# opravy
			$data['opravy'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND umisteni > '.time().' AND typ != 11'));
		}

		if($this->rychle_info[++$i]) {
			# opraveno
			$data['opraveno'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND typ != 11 AND umisteni > 1000 AND umisteni < '.time()));
		}

		if($this->rychle_info[++$i]) {
			# opraveno
			$data['ceka'] = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND umisteni < 0'));
		}

		if($this->rychle_info[++$i]) {
			# droidi
			$data['droidi'] = 0;
			if($celkem = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND typ = 11'))) {
				$opravujici = p($Sql->q('SELECT login FROM sklad WHERE login = '.UID.' AND typ = 11 AND umisteni > '.time()));
				$data['droidi'] = $celkem-$opravujici.'/'.$celkem;
			}	
		}

		if($this->rychle_info[++$i]) {
			# smlouvy
			$data['smlouvy'] = p($Sql->q('SELECT umisteni FROM sklad WHERE umisteni = '.(-1*UID)));
		}

		if($this->rychle_info[++$i]) {
			# pujcka
			$data['pujcka'] = 0;
			$result = $Sql->q('SELECT splatnost FROM pujcky WHERE hrac = '.UID.' AND typ="P"');
			if(p($result)) {
				$row = fa($result);
				$data['pujcka'] = $row['splatnost'];
				if($data['pujcka'] < 1) $data['pujcka'] = 'O';
			}	
		}

		if($this->rychle_info[++$i]) {
			# staj
			$data['staj'] = p($Sql->q('SELECT login FROM smlouvy WHERE login = '.UID));			
		}
		
		$this->data = $data;
		$_SESSION['infobox'] = $data;
	}
	
	function alter($name, $value) {
		$this->data[$name] = $value;
		$_SESSION['infobox'][$name] = $value;
	}
	
	function draw() {
		$this->getItems();
		
		$page = new cPage('infobox');
		
		$i=0; if($this->rychle_info[$i]) if($line = $this->getLine('posta')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('forum')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('online')) $data[] = $line;
		
		if(count($data)) $data[count($data)-1]['hr'] = $page->misc('HR');
		
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('zavody')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('sazky')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('opravy')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('opraveno')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('ceka')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('droidi')) $data[] = $line;
		
		if(count($data)) $data[count($data)-1]['hr'] = $page->misc('HR');
		
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('smlouvy')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('pujcka')) $data[] = $line;
		$i++; if($this->rychle_info[$i]) if($line = $this->getLine('staj')) $data[] = $line;
		
		if(count($data)) $data[count($data)-1]['hr'] = '';
		
		return (count($data) ? $page->getTable('INFOBOX',$data) : 'Žádné aktuality');
	}
	
	function getLine($name) {				
		if($this->data[$name]) {
			$row = array('nazev' => str_replace(' ', '&nbsp;', $this->items[$name][$this->pad($this->data[$name])]), 'pocet' => $this->data[$name], 'url' => $this->items[$name]['url'], 'hr' => '');
			if(ereg('\/', $this->data[$name]) && $kusy = explode('/',$this->data[$name])) 
				$row['nazev'] = str_replace(' ', '&nbsp;', $this->items[$name][$this->pad($kusy[0])]);
			
			return $row;
		}
		
		return false;
	}

	function getItems() {
		$infobox_item['posta'][1] = 'nová pošta';
		$infobox_item['posta'][2] = 'nové pošty';
		$infobox_item['posta'][3] = 'nových pošt';
		$infobox_item['posta']['url'] = 'posta.php?action=new';
		$infobox_item['posta']['nazev'] = 'Nová pošta';
		
		$infobox_item['forum'][1] = 'nový ve fóru';
		$infobox_item['forum'][2] = 'nové ve fóru';
		$infobox_item['forum'][3] = 'nových ve fóru';
		$infobox_item['forum']['url'] = 'forum.php?place=3';
		$infobox_item['forum']['nazev'] = 'Nové příspěvky ve fóru';
		
		$infobox_item['online'][1] = 'hráč online';
		$infobox_item['online'][2] = 'hráči online';
		$infobox_item['online'][3] = 'hráčů online';
		$infobox_item['online']['url'] = 'prehledy.php?action=online';
		$infobox_item['online']['nazev'] = 'Hráči online';
		
		$infobox_item['zavody'][1] = 'neodjetý závod';
		$infobox_item['zavody'][2] = 'neodjeté závody';
		$infobox_item['zavody'][3] = 'neodjetých závodu';
		$infobox_item['zavody']['url'] = 'zavody.php?action=mojeneodjete';
		$infobox_item['zavody']['nazev'] = 'Neodjeté závody';
		
		$infobox_item['sazky'][1] = 'čekající sázka';
		$infobox_item['sazky'][2] = 'čekající sázky';
		$infobox_item['sazky'][3] = 'čekajících sázek';
		$infobox_item['sazky']['url'] = 'sazky.php';
		$infobox_item['sazky']['nazev'] = 'Otevřené sázky';
		
		$infobox_item['opravy'][1] = 'opravovaný předmět';
		$infobox_item['opravy'][2] = 'opravované předměty';
		$infobox_item['opravy'][3] = 'opravovaných předmětů';
		$infobox_item['opravy']['url'] = 'obchod.php?action=sklad';
		$infobox_item['opravy']['nazev'] = 'Opravované předměty';
		
		$infobox_item['opraveno'][1] = 'opravený předmět';
		$infobox_item['opraveno'][2] = 'opravené předměty';
		$infobox_item['opraveno'][3] = 'opravených předmětů';
		$infobox_item['opraveno']['url'] = 'obchod.php?action=sklad';
		$infobox_item['opraveno']['nazev'] = 'Doopravené předměty';
		
		$infobox_item['ceka'][1] = 'čeká na opravu';
		$infobox_item['ceka'][2] = 'čekají na opravu';
		$infobox_item['ceka'][3] = 'čekají na opravu';
		$infobox_item['ceka']['url'] = 'obchod.php?action=sklad';
		$infobox_item['ceka']['nazev'] = 'Čekající na opravu';
		
		$infobox_item['droidi'][1] = 'volný droid';
		$infobox_item['droidi'][2] = 'volní droidi';
		$infobox_item['droidi'][3] = 'volných droidů';
		$infobox_item['droidi']['url'] = 'obchod.php?action=sklad';
		$infobox_item['droidi']['nazev'] = 'Volní droidi';
		
		$infobox_item['smlouvy'][1] = 'opravářská smlouva';
		$infobox_item['smlouvy'][2] = 'opravářské smlouvy';
		$infobox_item['smlouvy'][3] = 'opravářských smluv';
		$infobox_item['smlouvy']['url'] = 'obchod.php?action=opravari';
		$infobox_item['smlouvy']['nazev'] = 'Opravářské smlouvy';
		
		$infobox_item['pujcka'][1] = 'den na půjčku';
		$infobox_item['pujcka'][2] = 'dny na půjčku';
		$infobox_item['pujcka'][3] = 'dní na půjčku';
		$infobox_item['pujcka']['url'] = 'banky.php?action=pujcky';
		$infobox_item['pujcka']['nazev'] = 'Zbývající dny na splacení půjčky';
		
		$infobox_item['staj'][1] = 'nabídka do stáje';
		$infobox_item['staj'][2] = 'nabídky do stáje';
		$infobox_item['staj'][3] = 'nabídek do stáje';
		$infobox_item['staj']['url'] = 'staje.php';
		$infobox_item['staj']['nazev'] = 'Nabídky do stáje';
		
		$this->items = $infobox_item;
	}
	
	function pad($pocet) {
		if($pocet > 4) return 3;
		if($pocet > 1) return 2;
		return 1;	
	}
}
?>