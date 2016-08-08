<?php

class cZavodnik {
	function cZavodnik($data) {
		
		$this->id = $data['login'];
		$this->opatrnost = $data['opatrnost'];
		$this->agresivita = $data['agresivita'];
		$this->postoj = $data['postoj'];
		$this->obet = $data['obet'];
		$this->taktika = $data['taktika'];
		$this->rychlost = 0;
		$this->usek = 0;
		$this->vzdalenost = 0;
		$this->poradi = 0;
	}
	
	function inic($rasy) {
		global $Sql;
		
		$this->kluzak = new cKluzak($this->id);
		
		if(!$this->kluzak->ok_zavod) return true;
		
		if($this->id < 0) { # bot
			$this->login = getNick($this->id);
			$this->posta_zavody = 0;
			$this->bonus_prestiz = 0;
			$bot = fa($Sql->q('SELECT * FROM boti WHERE id = '.abs($this->id)));
			$this->prestiz = $bot['prestiz'];
			$this->questy = array();
		
			$this->rasa = $bot['rasa'];
			$this->agrese = $rasy[$this->rasa]['a'];
			$this->reflexy = $rasy[$this->rasa]['r'];
			$this->obchodnictvi = $rasy[$this->rasa]['o'];
			$this->staj = 0;
			
			return true;
		}
		
		$result = $Sql->q('SELECT login, posta_zavody FROM hraci WHERE id = '.$this->id);
		$postava = fa($result);
	
		$this->login = $postava['login'];
		$this->posta_zavody = $postava['posta_zavody'];
		
		$result = $Sql->q('SELECT rasa, prestiz FROM postavy WHERE login = '.$this->id);
		$postava = fa($result);
		
		$this->prestiz = $postava['prestiz'];
		$this->bonus_prestiz = 0;
		$this->rasa = $postava['rasa'];
		
		$result = $Sql->q('SELECT * FROM stats WHERE login = '.$this->id);
		$stats = fa($result);
		$this->stats = $stats;
		
		$this->questy = $stats['questy'];
		
		$this->agrese = $rasy[$this->rasa]['a'];
		$this->reflexy = $rasy[$this->rasa]['r'];
		$this->obchodnictvi = $rasy[$this->rasa]['o'];
		
		$this->staj = 0;
		$result = $Sql->q('SELECT staj, pomer FROM stajovnici WHERE login = '.$this->id);
		if(p($result)) {
			$row = fa($result);
			$this->staj = $row['staj'];
			$this->staj_pomer = $row['pomer'];
		}
		
		$Sql->q('UPDATE postavy SET zavody = zavody+1 WHERE login = '.$this->id);
	}
}
?>