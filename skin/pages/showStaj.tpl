{MAIN}
<h3>Detaily stáje {NAZEV}</h3>
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
  </tr>

  <tr>
  <td class="val">Vlajka: </td>
  <td>{VLAJKA}</td>
  </tr>
  
  <tr>
  <td class="val">Zkratka: </td>
  <td>{ZKRATKA}</td>
  </tr>

  <tr>
  <td class="val">Vlastník: </td>
  <td>{VLASTNIK}</td>
  </tr>
  
  <tr>
  <td class="val">Prestiž: </td>
  <td>{PRESTIZ}</td>
  </tr>

  <tr>
  <td class="val">Hráči: </td>
  <td>{HRACI}</td>
  </tr>  
  
  <tr>
  <td class="val">Budovy: </td>
  <td>{OBSAZENO}/{POZEMEK}<br /></td>
  </tr>

  <tr>
  <td class="val" style="vertical-align: top">Popis: </td>
  <td>{POPIS}</td>
  </tr>
  
  <tr>
  <td colspan="2" class="lista"></td>
  </tr>
</table>
<br /><br />
{::MAIN}

{EXT EXIST}
<h3>Detaily stáje</h3>Hledaná stáj neexistuje<br /><br />
{::EXT}

{TABLE HRACI}
	{ROW}<a href="showProfile.php?id={LOGIN}">{NICK}</a> ({STAV})<br />{::ROW}
{::TABLE}