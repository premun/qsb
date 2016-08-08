{MAIN}
<h3>Sázky</h3>
<br />
<strong>Závody na které je možno si vsadit:</strong><br /><br />
<form action="sazky.php" method="get" style="margin-left: 9px" name="form1">
	<input type="checkbox" name="minimum" id="minimum" onchange="document.form1.submit()" {CHECKED}/> <label for="minimum">S dostatečným počtem závodníků k odjetí</label>
</form>
<br />
{MOZNE}
<br /><br /><strong>Tvoje sázky:</strong><br /><br />
{SAZKY}
{::MAIN}

{EXT COMMON_RUSENI}
<h3>Rušení sázky</h3>
{::EXT}

{EXT COMMON_SHOW}
<h3>Sázky</h3>
{::EXT}

{EXT COMMON}
<h3>Sázky</h3>
{::EXT}

{EXT COMMON_BETONRACE}Sázení na závod {NAZEV}{::EXT}

{EXT CANCEL}Tato sázka nebyla podána tebou a tudíž jí nemůžeš zrušit{::EXT}
{EXT ODJET}Závod, na který je tato sázka, již byl odjet{::EXT}
{EXT DONE}Sázka byla zrušena{::EXT}
{EXT EXIST_ID}Hledaná sázka neexistuje. ID musí být číslo{::EXT}
{EXT EXIST}Hledaná sázka neexistuje{::EXT}
{EXT OWN}Sázka není tvoje{::EXT}
{EXT ZAVOD}Hledaný závod neexistuje{::EXT}
{EXT VSAZENO}Úspěšně vsazeno{::EXT}
{EXT VICKRAT}Nemůžeš si vsadit na jeden závod vícekrát{::EXT}
{EXT ZAVODNICI}Nemůžeš si zatím vsadit, protože v závodu ještě nejsou žádní závodníci{::EXT}
{EXT JEDES}Nemůžeš si vsadit na tento závod, protože v něm taky jedeš{::EXT}
{EXT KLADNE_CISLO}Vsazená částka musí být kladné číslo{::EXT}
{EXT NEMAS_TOLIK}Nemůžeš si vsadit {PENIZE} Is, protože nemáš tolik peněz{::EXT}

{EXT BETONRACE}
<br />
<form action="bet.php" method="post" name="form_vsadit">
Vsadit si na &nbsp;&nbsp;
<select name="zavodnik">{ZAVODNICI}</select>
&nbsp;&nbsp; že  &nbsp;&nbsp;
<select name="misto">
{MISTA}
<option value="0">nedojede</option>
</select> &nbsp;&nbsp;kolik: &nbsp;
<input type="text" name="sazka" size="7" /><br />
<input type="checkbox" name="cancel" /> <label for="cancel">zrušit sázku (a vrátit 90% zpět) v případě při/odhlášení některého jezdce</label><br />
<input type="hidden" name="zavod" value="{ID}" />
</form>
<br />
<span class="error">Při zrušení sázky se vratí nazpět jen 75% vkladu. Zvaž tedy nejdříve jestli opravdu chceš vsadit takto.</span><br />
{::EXT}

{EXT SHOWBET}
<script language="JavaScript">
function zrus() {
  if(confirm("Opravdu si přeješ zrušit sázku? Přijdeš o 25% vsazené částky")) {
    location="abortBet.php?id={IDS}";
  }
}

function auto() {
  if(confirm("Nastavit automatické zrušení sázky v případě změny sestavy závodu?\n(vrací se pouze 90% vsazené částky)")) {
    location="abortBet.php?action=auto&id={IDS}";
  }
}
</script>
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 380px">
    <tr class="horni">
        <td style="padding: 3px" colspan="2"><a href="showRace.php?id={ID}"><strong>{NAZEV}</strong></a></td>
    </tr>
    
    <tr>
        <td class="val">Vsazeno na: </td>
        <td>{ZAVODNIK}</td>
    </tr>
    
    <tr>
        <td class="val">Umístění: </td>
        <td>{MISTO}</td>
    </tr>
    
    <tr>
        <td class="val">Vsazeno: </td>
        <td>{SAZKA}</td>
    </tr>
    
    <tr>
    	<td class="val">Stav: </td>
    	<td>{STAV}</td>
    </tr>
    
    <tr>
    	<td class="val">Výhra: </td>
    	<td>{VYHRA}</td>
    </tr>  
</table>
<br />    
{ZRUSENI}
{::EXT}

{TABLE MOZNE}
<table cellspacing="0" cellpadding="1" class="zavody">
  <tr class="horni">
    <td class="id" style="width: 5px">ID</td>
	<td class="nick">&nbsp;&nbsp;Název závodu</td>
	<td class="info" style="width: 5px">Závodníci</td>
	<td class="info" style="text-align: center; width: 5px;">Dotace</td>
	<td class="info" style="width: 5px"></td>
  </tr>
  {ROW}
    <tr>
    <td class="id">{ID}</td>
    <td class="nick">&nbsp;&nbsp;<a href="showRace.php?id={ID}">{NAZEV}</a></td>
    <td class="info" style="text-align: right">{HRACU}/{MAX}&nbsp;&nbsp;</td>
    <td class="info" style="text-align: right">&nbsp;{DOTACE}&nbsp;</td>
    <td class="info"><a class="submit" onclick="jHadr('betOnRace.php?id={ID}', {})">Vsadit&nbsp;si</a></td>
    </tr>
  {::ROW}
  <tr><td class="lista" colspan="5"></td></tr>
</table>
{::TABLE}

{TABLE SAZKY}
<table cellspacing="0" cellpadding="1" class="zavody">
  <tr class="horni">
    <td></td>
	<td class="nick">Název závodu</td>
	<td class="info">Závodník</td>
	<td class="info">Místo</td>
	<td class="info">&nbsp;Sázka&nbsp;</td>
	<td class="info">Výhra</td>
	<td class="info"></td>
  </tr>
  {ROW}<tr>
    <td class="info" style="border-right-width: 0px; width: 3%; text-align: left; cursor: default"><span style="background-color: {BARVA}">&nbsp;&nbsp;</span></td>
    <td class="info"><a href="showRace.php?id={IDZ}#sazky">{NAZEV}</a></td>
	<td class="nick">{JMENO}</a></td>
	<td class="info" style="text-align: center">{MISTO}</td>
	<td class="info">{SAZKA}</td>
	<td class="info">{PENIZE}</td>
	<td class="info"><a href="showRace.php?id={IDZ}#sazky">Ukázat</a></td>
  </tr>
  {::ROW}
<tr><td class="lista" colspan="7"></td></tr>
</table><br /><br />
{::TABLE}