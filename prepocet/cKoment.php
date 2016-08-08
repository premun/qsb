<?php

class cKoment {
	function cKoment($hraci, $trat) {
		$this->komentar = '';
		$this->ids = array();
		$this->vety = loadVety('all');
		$this->trat = $trat;
		
		foreach($hraci as $hrac) {
			$this->hraci[$hrac->id] = $hrac->login;
			$this->ids[] = $hrac->id;
		}
	}
	
	function pridej($typ,$usek,$hraci) {
		if(!count($this->vety[$typ])) $this->vety[$typ] = loadVety($typ); # refreshuju zasobnik v pripade potreby

		if(!count($this->vety[$typ])) return 'COMMENT::'.strtoupper($typ).' not found';

		$n = rand(0,count($this->vety[$typ])-1);
		$veta = $this->vety[$typ][$n];
		unset($this->vety[$typ][$n]);		# najdu si a vyradim vetu ze zasobniku

		sort($this->vety[$typ]);

		if(!$veta) { # tohle se defakto nemuze stat
			return 'COMMENT::'.strtoupper($typ).' not found';
		}

		if(is_array($hraci)) {	# nahradim si ID nickama
			foreach($hraci as $p => $hrac) {
				$hraci[$p] = $this->hraci[$hrac];			
			}
		} else {
			$hraci = $this->hraci[$hraci];
		}
		
		$rand1 = '';
		$rand2 = '';
		
		switch($typ) {		# nebudeme liny, zejo..
			case 'start':   # rozepisuje se to kvuli randum a crashum
				$pocet = count($hraci);
				$nicky = implode(', ', $hraci);
				
				$veta = $this->nahrad($veta,array('pocet' => $pocet, 'nicky' => $nicky));				
				break;
				
			case 'fav':
				$fav = $hraci;
				$g = 0;
				if(count($this->hraci) > 1) while(($rand1 == $fav || $rand1 == '') && $g < 200) {
					$rand1 = $this->hraci[$this->ids[rand(0,count($this->ids))]];
					$g++;
				}

				$veta = $this->nahrad($veta,array('fav' => $fav, 'rand1' => $rand1));				
				break;
			
			case 'postartu':
				$pocet = count($hraci);
				$prvni = $hraci[0];
				$posledni = $hraci[count($hraci)-1];
				$nicky = implode(', ', $hraci);
				
				$veta = $this->nahrad($veta,array('pocet' => $pocet, 'poradi' => $nicky, 'prvni' => $prvni, 'posledni' => $posledni, 'nicky' => $nicky));				
				break;
			
			case 'vycpavky':
				$pocet = count($hraci);
				$nicky = implode(', ', $hraci);
				$rand1 = $this->hraci[$this->ids[rand(0,count($this->ids))]];
				if(count($this->hraci) > 2) while($rand1 == $rand2 || $rand2 == '') $rand2 = $this->hraci[$this->ids[rand(0,count($this->ids))]];
				
				$veta = $this->nahrad($veta,array('pocet' => $pocet, 'poradi' => $nicky, 'rand1' => $rand1, 'rand2' => $rand2, 'nicky' => $nicky));				
				break;
				
			case 'crash1':
				if(count($this->hraci) > 1) while($rand1 == $hraci || $rand1 == '') $rand1 = $this->hraci[$this->ids[rand(0,count($this->ids))]];
			
				$veta = $this->nahrad($veta,array('crash' => $hraci, 'rand1' => $rand1));				
				break;
				
			case 'crash2':
				$veta = $this->nahrad($veta,array('crash1' => $hraci[0], 'crash2' => $hraci[1]));				
				break;
				
			case 'uhnul':
				$veta = $this->nahrad($veta,array('crash1' => $hraci[0], 'crash2' => $hraci[1]));				
				break;
				
			case 'tcrash':
				$veta = $this->nahrad($veta,array('crash' => $hraci));				
				break;
				
			case 'chlazeni':
				$veta = $this->nahrad($veta,array('crash' => $hraci));				
				break;
				
			case 'vedeni':
				$veta = $this->nahrad($veta,array('prvni' => $hraci[0]));				
				break;
				
			case 'stale':
				$veta = $this->nahrad($veta,array('prvni' => $hraci[0]));				
				break;
			
			case 'poradiv':
				$pocet = count($hraci);
				$nicky = implode(', ', $hraci);
				$prvni = $hraci[0];
				$posledni = $hraci[count($hraci)-1];
				
				$veta = $this->nahrad($veta,array('pocet' => $pocet, 'poradi' => $nicky, 'prvni' => $prvni, 'posledni' => $posledni, 'nicky' => $nicky));				
				break;
			
			case 'finish':
				$pocet = count($hraci);
				$nicky = implode(', ', $hraci);
				$prvni = $hraci[0];
				$posledni = $hraci[count($hraci)-1];
				
				$veta = $this->nahrad($veta,array('pocet' => $pocet, 'poradi' => $nicky, 'prvni' => $prvni, 'posledni' => $posledni, 'nicky' => $nicky));				
				break;
				
			case 'finish_one':
				$veta = $this->nahrad($veta,array('prvni' => $hraci[0]));				
				break;
		}
		$this->add($usek,$veta,$typ);
		
		return $veta;
	}
	
	function nahrad($veta,$tagy) {
		foreach($tagy as $tag => $hodnota) {
			$veta = str_replace('{'.strtoupper($tag).'}','[B]'.$hodnota.'[/B]',$veta);
		}
		
		return $veta;
	}
	
	function vyrad($id) {
		unset($this->hraci[$id]);
		foreach($this->ids as $p => $id2) 
			if($id2 == $id) unset($this->ids[$p]);
	}
	
	function add($usek,$veta,$typ) {
		if($this->last != $usek) {
			if($typ != 'start' && !ereg('finish',$typ)) $this->koment .= '<tr><td><strong class="extra">'.$this->useky[$this->trat[$usek]]['nazev'].'</strong></td></tr>';
		}
		$this->last = $usek;
		$this->koment .= '<tr><td'.($typ == 'start' || ereg('finish',$typ) ? '' : ' style="padding-left: 35px"').'>'.($typ == 'start' || ereg('finish',$typ) || $typ == 'tcrash' ? '<strong class="extra">'.$veta.'</strong>' : $veta).'</td></tr>';
	}
}
?>