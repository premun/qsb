<?php

// Jediny dochovaly kod admina Hannibala.
// Ocekava se, ze je to posledni existujici relika, ze zrejmych duvodu ponechana v puvodnim stavu.

  class banka
  {
    var $id;
    var $jmeno;
    var $vlastnik;
    var $ir1; //urokova sazba pro poskytnute pujcky
    var $ir2; //urokova sazba pro prijate vklady
    var $kapital; //kapital banky

    function banka($id)
    // konstruktor
    {
      GLOBAL $Sql;
      $result = $Sql->q('SELECT * FROM banky WHERE id='.$id);
      $row = fa($result);
      $this->id = $row['id'];
      $this->jmeno = $row['jmeno'];
      $this->vlastnik = $row['vlastnik'];
      $this->ir1 = $row['ir1'];
      $this->ir2 = $row['ir2'];
      $this->kapital = $row['kapital'];
    }

    function zanikBanky()
    // destruktor
    {
      GLOBAL $Sql;
      $Sql->q('DELETE FROM banky WHERE id='.$this->id);
      //banka smazana z tabulky bank
    }

    function zmenIR1($novaIR)
    {
      $this->ir1 = $novaIR;
      GLOBAL $Sql;
      $Sql->q('UPDATE banky SET ir1='.$novyIR.' WHERE id='.$this->id);
    }

    function zmenaIR2($novaIR)
    {
      $this->ir2 = $novaIR;
      GLOBAL $Sql;
      $Sql->q('UPDATE banky SET ir2='.$novyIR.' WHERE id='.$this->id);
    }

    function zmenPenizeHraci($penize, $hrac)
    {
      GLOBAL $Sql;
        $result2 = $Sql->q('SELECT * FROM postavy WHERE login='.$hrac);
        $row2 = fa($result2);
        $kolko = $row2['penize'] + $penize;
        $Sql->q('UPDATE postavy SET penize='.$kolko.' WHERE login='.$row2['login']);
    }

    function poskytnutiPujcky($vyse, $komu, $splatnost, $sazba)
    {
      GLOBAL $Sql;
      if ($vyse<=$this->kapital)
      {
        // ubrani kapitalu bance
        $this->kapital = $this->kapital - $vyse;
        $Sql->q('UPDATE banky SET kapital='.$this->kapital.' WHERE id='.$this->id);
        // pridani penez hraci
        $this->zmenPenizeHraci($vyse, $komu);
        // uprava pujcky v db
        $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$komu.' AND banka='.$this->id.' AND ir='.$sazba.' AND splatnost='.$splatnost.' AND typ="P"');
        if (p($result) <> 0){
          $row = fa($result);
          $vyse = $vyse + $row['vyse'];
          $idcko = $row['id'];
          $Sql->q('UPDATE pujcky SET vyse='.$vyse.' WHERE id='.$idcko);
        }
        else $result = $Sql->q('INSERT INTO pujcky(banka, hrac, ir, splatnost, vyse, typ) VALUES('.$this->id.', '.$komu.', '.$sazba.', '.$splatnost.', '.$vyse.', "P")');
      }
    }

    function prijetiVkladu($vyse, $komu, $splatnost)
    {
      GLOBAL $Sql;
        // pridani kapitalu bance
        $this->kapital = $this->kapital + $vyse;
        $Sql->q('UPDATE banky SET kapital='.$this->kapital.' WHERE id='.$this->id);
        // pridani penez hraci
        $this->zmenPenizeHraci(- $vyse, $komu);
        // uprava pujcky v db
        $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$komu.' AND banka='.$this->id.' AND ir='.$this->ir2.' AND splatnost='.$splatnost.' AND typ="V"');
        if (p($result) <> 0){
          $row = fa($result);
          $newVyse = $vyse/((100+$this->ir2)/100) + $row['vyse'];
          $idcko = $row['id'];
          $Sql->q('UPDATE pujcky SET vyse='.$newVyse.' WHERE id='.$idcko);
        }
        else {
          $newVyse = $vyse/((100+$this->ir2)/100);
          $result = $Sql->q('INSERT INTO pujcky(banka, hrac, ir, splatnost, vyse, typ) VALUES('.$this->id.', '.$komu.', '.$this->ir2.', '.$splatnost.', '.$newVyse.', "V")');
        }
    }

    function vybraniVkladu($vyse, $komu)
    {
      GLOBAL $Sql;
        $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$komu.' AND banka='.$this->id.' AND typ="V"');
        $row = fa($result);
        // vybrani pred splatnosti u terminovanych vkladu zpusobi ztratu v podobe pokuty
        if ($row['splatnost']>0){
          $vyseAurok = $vyse / ((100+$row['ir']*2)/100)^5;
        }
        else {$vyseAurok = $vyse;}
        // ubrani kapitalu bance
        $this->kapital = $this->kapital - $vyseAurok;
        $Sql->q('UPDATE banky SET kapital='.$this->kapital.' WHERE id='.$this->id);
        // pridani penez hraci
        $this->zmenPenizeHraci($vyse, $komu);
        // uprava pujcky v db
          $vyse = $row['vyse'] - $vyseAurok;
          $idcko = $row['id'];
          if ($vyse == 0) {
            $Sql->q('DELETE FROM pujcky WHERE id='.$idcko);
          }
          $Sql->q('UPDATE pujcky SET vyse='.$vyse.' WHERE id='.$idcko);
    }

    function splaceniPujcky($vyse, $komu)
    {
      GLOBAL $Sql;
        $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$komu.' AND banka='.$this->id.' AND typ="P"');
        $row = fa($result);
        // splaceni pred splatnosti zajisti polovicni uroceni dane castky
        if ($row['splatnost']>=0){
          $vyseAurok = $vyse * ((100+$row['ir']/2)/100)^($row['splatnost']+1);
        }
        else {$vyseAurok = $vyse;}
        // pridani kapitalu bance
        $this->kapital = $this->kapital + $vyseAurok;
        $Sql->q('UPDATE banky SET kapital='.$this->kapital.' WHERE id='.$this->id);
        // odebrani penez hraci
        $this->zmenPenizeHraci(- $vyse, $komu);
        // uprava pujcky v db
        $newVyse = $row['vyse'] - $vyse;
        $idcko = $row['id'];
        if ($newVyse <= 0) {
          $Sql->q('DELETE FROM pujcky WHERE id='.$idcko);
        }
        $Sql->q('UPDATE pujcky SET vyse='.$newVyse.' WHERE id='.$idcko);
    }

    function getVyseVkladu($kdo)
    {
      GLOBAL $Sql;
        $result = $Sql->q('SELECT * FROM pujcky WHERE hrac='.$kdo.' AND banka='.$this->id.' AND typ="V"');
        if (p($result)==0) {return 0;}
        else {
          $row = fa($result);
          return $row['vyse'];
        }

    }

  }
?>
