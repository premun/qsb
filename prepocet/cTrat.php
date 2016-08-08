<?php

class cTrat {
	function cTrat($id,$zavod_login) {
		global $Sql;
		
		$trat = fa($Sql->q("SELECT * FROM trate WHERE id = ".$id));
		
		$casti = explode(',', $trat['trat']);
		
		if($zavod_login != 0 && $trat['login'] != 0 && $trat['login'] != $zavod_login) {
			//if(strtotime($res15['val']) < strtotime($trat['datum'])) {
				$Sql->q('UPDATE postavy set penize = penize + '.POUZITI_TRATE.' WHERE login = '.$trat['login']);
				finance($trat['login'],POUZITI_TRATE,1,16);
			//}
		}		
		
		$this->useky = $casti;
		$this->delka = count($casti);
	}
}
?>