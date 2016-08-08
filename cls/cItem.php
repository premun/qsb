<?php

class cItem {

  function cItem($id,$typ) {
    global $Sql;
    $this->setTabs();
	$this->typ2 = $typ;
	$this->typ = $typ;
	$this->id = $id;
	$this->kat = $this->katz[$this->typ];
	$result = $Sql->q('SELECT * FROM '.$this->tabs[$this->typ2].' WHERE id = '.$this->id);
	if(p($result) == 0) { 
	  $this->id = "not_found";
	} else {	
	  //vars($result);
	  $row = fa($result);
	  foreach($row as $val=>$ent) $this->{$val} = $ent;
	}
  }

  function setTabs() {
	$tabs2[1] = "podvozky";
	$tabs2[2] = "motory";
	$tabs2[3] = "drzaky";
	$tabs2[4] = "chladice";
	$tabs2[5] = "desky";
	$tabs2[6] = "brzdy";
	$tabs2[7] = "zdroje";
	$tabs2[8] = "pancerovani";
	$tabs2[9] = "suspenzory";
	$tabs2[10] = "p_motory";
	$tabs2[11] = "droidi";
	
	$this->tabs = $tabs2;
	
    $kategorie[1] = "Podvozky";
    $kategorie[2] = "Motory";
    $kategorie[3] = "Energodržáky";
    $kategorie[4] = "Chladiče";
    $kategorie[5] = "Palubní desky";
    $kategorie[6] = "Brzdy";
    $kategorie[7] = "Zdroje";
    $kategorie[8] = "Pancéřování";
    $kategorie[9] = "Suspenzory";
    $kategorie[10] = "Přídavné motory";
    $kategorie[11] = "Opravní droidi";
	
	$this->katz = $kategorie;
  }
}

?>