{MAIN}
<h3>Detaily předmětu</h3>
<br />
<br />
{DETAILY}
{HRACI}
{OBCHODNICI}
<a onclick="history.back()" class="submit">Zpět</a>
{::MAIN}

{EXT COMMON}
<h3>Detaily předmětu</h3>
{::EXT}

{EXT EXIST}
Předmět nebyl nalezen
{::EXT}

{MISC ETAPA}
<div style="text-align: center">
	Tento předmět se objeví na trhu až <strong class="extra">{ETAPA_DATUM}</strong>
</div>
<br />
<br />
{::MISC}

{TABLE DETAILY}
  <table class="zavod" style="margin: auto; width: 350px" cellspacing="1" cellpadding="1">
  <tr class="horni"><td colspan="2"><strong>{NAZEV}</strong></td></tr>
  
  <tr class="nobg">
  <td class="val" class="nobg">Kategorie: </td>
  <td><a href="items.php?typ={TYP}">{KATEGORIE}</a></td>
  </tr>
  
  {ROW}
  <tr class="nobg">
  <td class="val">{ENT} </td>
  <td>{VAL}</td>
  </tr>
  {::ROW}
  
  <tr><td colspan="2" class="lista"></td></tr>  
  </table>
  <br /><br />
{::TABLE}

{TABLE HRACI}
<table class="zavod" style="margin: auto; width: 350px" cellspacing="1" cellpadding="1">
  <tr class="horni"><td colspan="4"><strong>Lze koupit u těchto hráčů</strong></td></tr>
  
  {ROW}
  <tr class="nobg">
    <td class="val"><a href="showVyloha.php?id={LOGIN}">{LOGINN}</a></td>
	<td style="vertical-align: middle">{VYDRZ}</td>
    <td>{CENA} Is</td>
	<td>{KOUPIT}</td>
  </tr>
  {::ROW}
  
  <tr><td colspan="4" class="lista"></td></tr>  
</table><br /><br />
{::TABLE}

{TABLE OBCHODNICI}
<table class="zavod" style="margin: auto; width: 350px" cellspacing="1" cellpadding="1">
  <tr class="horni"><td colspan="4"><strong>Lze koupit u těchto systémových obchodníků</strong></td></tr>
  
  {ROW}
  <tr class="nobg">
    <td><a href="showGoods.php?id={OBCHODNIK_ID}">&nbsp;&nbsp;{OBCHODNIK_NAZEV}&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
    <td style="vertical-align: middle">{RASA}</td>
    <td>{CENA}&nbsp;Is</td>
    <td>{KOUPIT}</td>
  </tr>
  {::ROW}
  
  <tr><td colspan="4" class="lista"></td></tr>  
</table><br /><br />
{::TABLE}