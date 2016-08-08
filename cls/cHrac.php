<?php

class cHrac {
	function cHrac($id,$info) {		# (ID, ['all',''] )
		global $Sql;
			
		$this->id = $id;
		if($info == 'all') $this->getInfo();
		  else {
			$result = $Sql->q('SELECT 
				h.id as id,
				h.login as login,
				h.cas as cas,
				h.status as status,
				h.forum as forum,
				p.rasa as rasa,
				p.prestiz as prestiz,
				p.penize as penize
				FROM hraci as h LEFT JOIN postavy as p ON p.login = h.id WHERE h.id = '.$this->id);

			if(!p($result)) {
				$this->ok = 404;
				return false;
			}

			$row = fa($result);
			foreach($row as $name => $value) $this->{$name} = $value;	
		}
		
	}

	function change($clmn,$val,$op) {		# (SLOUPEC, HODNOTA, ['set','minus','plus'] )
		switch($op) {
			case 'set':
				$Sql->q('UPDATE postavy SET '.$clmn.' = '.$penize.' WHERE login = '.$this->id);
				$this->penize = penize;
				break;
			case 'plus':
				$Sql->q('UPDATE postavy SET '.$clmn.' = '.$clmn.'+'.$penize.' WHERE login = '.$this->id);
				$this->penize += penize;
				break;
			case 'minus':
				$Sql->q('UPDATE postavy SET '.$clmn.' = '.$clmn.'-'.$penize.' WHERE login = '.$this->id);
				$this->penize -= penize;
				break;
		}
	}
	
	function getRasa() {
		global $Sql;
		$this->rasa2 = fa($Sql->q('SELECT * FROM rasy WHERE id = '.$this->rasa));
		return $this->rasa2;
	}  
	
	function getInfo() {
		global $Sql;
	
		$result = $Sql->q('SELECT 
		h.id as id,
		h.login as login,
		h.heslo as heslo,
		h.email as email,
		h.icq as icq,
		h.popis as popis,
		h.IP as ip,
		h.status as status,
		h.forum as forum,
		h.cas as cas,
		h.skin as skin,
		p.rasa as rasa,
		p.prestiz as prestiz,
		p.penize as penize,
		p.zavody as zavody,
		p.popis as popis2,
		p.prvni as prvni,
		p.druhy as druhy,
		p.treti as treti	
		FROM hraci as h LEFT JOIN postavy as p ON p.login = h.id WHERE h.id = '.$this->id);

		if(!p($result)) {
			$this->ok = 404;
			return false;
		}

		$row = fa($result);
		foreach($row as $name => $value) $this->{$name} = $value;	
		
		$stavy = Array();
		$stavy[-2] = 'Zablokovaný hráč';
		$stavy[0] = 'Hráč nedokončil registraci nebo je po restartu';
		$stavy[-1] = 'Hráč nedokončil registraci nebo je po restartu';
		$stavy[1] = 'Hráč';
		$stavy[2] = 'Galaktický konzul';
		$stavy[3] = 'Galaktický konzul';
		$stavy[42] = 'Admin';
		
		$this->stav = $stavy[$this->status];
	}
}
?>