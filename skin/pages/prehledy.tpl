{MAIN}
<h3>Přehledy</h3>
<ul style="float: left; position: relative; left: 30px">
	<li><a href="prehledy.php?action=hraci">Hráči</a></li>
	<li><a href="prehledy.php?action=online">Online hráči</a></li>
	<li><a href="prehledy.php?action=ladder">Žebříček jezdců</a></li>
	<li><a href="prehledy.php?action=staje">Stáje</a></li>
</ul>
<ul style="float: right; position: relative; left: -90px">
	<li><a href="prehledy.php?action=questy&typ=all">Questy</a></li>
	<li><a href="items.php">Přehled předmětů</a></li>
	<li><a href="prehledy.php?action=finance">Finance</a></li>
	<li><a href="prehledy.php?action=stats">Hall of Fame</a></li>
</ul>
<hr style="clear: both" />
{OBSAH}
{::MAIN}

{MISC HRACI}
<h3>Přehled hráčů</h3>
<br />
{PREHLED}
{SIPKY}
{::MISC}

{MISC ZADNI}Žádní hráči{::MISC}
{MISC ZADNE}Zatím nebyly založeny žádné stáje{::MISC}
{MISC ZADNY}Zatím nevyšlo žádné číslo{::MISC}
{MISC PODSEKCE}<br />Vyber prosím podsekci{::MISC}

{TABLE HRACI}
<form action="showProfile.php" method="get">
Vyhledat&nbsp;hráče:&nbsp;<input type="text" name="login" rel="ajaxList" size="20" />&nbsp;<input type="submit" value=" Vyhledat " />
</form>
<br />
<br />
<table cellspacing="0" cellpadding="1" class="prehledy">
    <tr class="horni">
		<td class="id" style="width: 3px">#</td>
        <td class="id" style="width: 3px;"><a href="prehledy.php?action=hraci&sc={SC}&by=id">&nbsp;ID&nbsp;</a></td>
        <td class="nick"><a href="prehledy.php?action=hraci&sc={SC}&by=login">Nick</a></td>
        <td class="icq" style="width: 3px; text-align: center">&nbsp;<a href="prehledy.php?action=hraci&sc={SC}&by=cas">Aktivita</a>&nbsp;</td>
        <td class="rasa">Rasa</td>
    </tr>
	{ROW}
    <tr>
        <td class="id" style="width: 3px">{PORADI}</td>
        <td class="id">{ID}</td>
        <td class="nick"><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
        <td class="icq">{CASIK}</td>
        <td class="rasa">{RASA}</td>
    </tr>    
    {::ROW}
    <tr>
    	<td class="lista" colspan="5"></td>
    </tr>
</table><br /><br />
{::TABLE}

{MISC ZEBRICEK}
<h3>Žebříček</h3>
<br />
{PREHLED}
{SIPKY}
<div style="margin-left: 160px">
	<span class="extra">C</span> - Celkem závodů<br />
	<span class="extra">1</span> - Prvních míst<br />
	<span class="extra">2</span> - Druhých míst<br />
	<span class="extra">3</span> - Třetích míst
</div>
<br /><br />
{::MISC}

{TABLE ZEBRICEK}
<table cellspacing="0" cellpadding="1" class="prehledy" style="width: 290px">
	<tr class="horni">
        <td class="id">#</td>
        <td class="nick">Nick</td>
        <td class="icq">1</td>
        <td class="icq">2</td>
        <td class="icq">3</td>
        <td class="icq">C</td>
        <td class="icq"><a href="prehledy.php?action=ladder{PRESTIZ}&start={START}">Prestiž</a></td>
    </tr>
    {ROW}
    <tr>
        <td class="id">{MISTO}</td>
        <td class="nick"><a href="showProfile.php?id={LOGIN}">{JMENO}</a></td>
        <td class="icq">{PRVNI}</td>
        <td class="icq">{DRUHY}</td>
        <td class="icq">{TRETI}</td>
        <td class="icq">{ZAVODY}</td>
        <td class="icq" style="text-align: right">{PRESTIZ}&nbsp;&nbsp;</td>
	</tr>
    {::ROW}
    <tr>
    	<td class="lista" colspan="7"></td>
    </tr>
</table>
<br />
<br />
{::TABLE}

{MISC STAJE}
<h3>Stáje</h3>
<br />
{PREHLED}
{::MISC}

{TABLE STAJE}
<table cellspacing="0" cellpadding="1" class="prehledy" style="width: 428px">
    <tr class="horni">
        <td class="icq">Název a vlajka stáje</td>
        <td class="icq">Zkratka</td>
        <td class="icq">Vlastník</td>
        <td class="icq" style="width: 3px">Lidí</td>
        <td class="icq">Prestiž</td>
    </tr>
    {ROW}
    <tr>
        <td class="nick"><a href="showStaj.php?id={ID}">{VLAJKA}&nbsp;&nbsp;{NAZEV}</a></td>
        <td class="icq" style="width: 3px; text-align: center">{ZKRATKA}</td>
        <td class="nick" style="width: 3px; text-align: center"><a href="showProfile.php?id={LOGIN}">{VLASTNIK}</a></td>
        <td class="icq" style="text-align: center; width: 3px">{LIDI}</td>
        <td class="icq" style="width: 3px">{PRESTIZ}</td>  
    </tr>
    {::ROW}
    <tr>
    	<td class="lista" colspan="5"></td>
    </tr>
</table><br /><br />
{::TABLE}

{MISC ONLINE}
<h3>Online hráči <span class="ultra">({HRACU})</span></h3>
<br />
{PREHLED}
{::MISC}

{TABLE ONLINE}
<table cellspacing="0" cellpadding="1" class="prehledy">
    <tr class="horni">
        <td class="id"><a href="prehledy.php?action=online&sc={SC}&by=id">ID</a></td>
        <td class="nick"><a href="prehledy.php?action=online&sc={SC}&by=login">Nick</a></td>
        <td class="icq" style="text-align: center; width: 3px">ICQ</td>
        <td class="icq" style="text-align: center; width: 3px"><a href="prehledy.php?action=online&sc={SC}&by=cas">Nečinný</a></td>
        <td class="rasa">&nbsp;Pošta&nbsp;&nbsp;</td>
    </tr>
    {ROW}
	<tr>
        <td class="id" style="text-align: right; width: 3px">{ID}</td>
        <td class="nick"><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
        <td class="icq" style="text-align: center; width: 3px">{ICQ}</td>
        <td class="icq" style="text-align: center; width: 3px">{CAS}</td>
        <td class="rasa" style="width: 3px; text-align: center"><a class="submit" onclick="jHadr('posta.php', {id: '{LOGIN}'})">Napsat</a>&nbsp;&nbsp;</td>
	</tr>
    {::ROW}
    <tr>
    	<td class="lista" colspan="5"></td>
    </tr>
</table><br /><br />
{::TABLE}

{MISC TIMES}
<h3>QSB Times</h3>
Nejrychlejší a nejpřehlednější magazín v tomto i jakémkoli jiném vesmíru<br />
<br />
{PREHLED}
{::MISC}

{TABLE TIMES}
<div style="margin-left: 56px;">
    {ROW}<strong>QSB Times výtisk číslo {C1}</strong> &nbsp;&nbsp;&nbsp;&nbsp; <a href="showVytisk.php?id={C2}">ukázat</a><br />{::ROW}
</div>
{::TABLE}

{MISC FINANCE}
<h3>Finance</h3>
Zde si můžeš prohlédnout své veškeré peněžní transakce a třeba zjistit, kolik sis vydělal za jaký závod. V sekci Home máš pak přehled financi podle dnů.
<br />
<br />
<span{SKRYTI}>Nejvíce jsi měl tuto sezónu <strong><span class="extra">{NEJVIC} Is</span></strong> <strong><span class="extra">{KDY}</span></strong>
<br />
<br /></span>
<form action="prehledy.php" method="get" name="form_typy">
Filtr: {TYPY}
<input type="hidden" name="action" value="finance" />
<input type="submit" id="filter" name="filter" style="display:none" value="true" />
</form>
<br />
<form action="prehledy.php" method="get" name="form_kategorie">
Kategorie: {KATEGORIE}
<input type="hidden" name="action" value="finance" />
<input type="submit" id="filter" name="category" style="display:none" value="true" />
</form>
<br />
<br />
{FINANCE}
<br />
<br />
{::MISC}

{TABLE TYPY}
<select name="typ" onchange="document.form_typy.filter.click()">
	<option value="0">Vše</option>
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE KATEGORIE}
<select name="kategorie" onchange="document.form_kategorie.category.click()">
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE FINANCE}
<table cellspacing="0" cellpadding="1" class="zavody">
    <tr class="horni">
        <td class="info" style="text-align: center">Čas</td>
        <td class="info">Akce</td>
        <td class="info" style="text-align: center">Peníze</td>
    </tr>
{ROW}<tr{ODDELOVAC}>
        <td class="info" style="width: 3px">{CAS}</td>
        <td class="info">{AKCE}</td>
        <td class="info" style="width: 3px; font-weight: bold; color: {BARVA}; text-align: right;">{PENIZE}</td>
    </tr>{::ROW}
    <tr>
    	<td colspan="5" class="lista"></td>
    </tr>
</table>
{::TABLE}

{MISC QUESTY}
<h3>Questy</h3>
<a href="#" onclick="document.getElementById('questy_info').style.display = 'inline'; this.style.display = 'none'">Co jsou questy?</a>
<span id="questy_info" style=" display: none">Questy je sekce, která není až tak důležitá část hry a přímo nezasahuje do průběhu hry ani neovlivňuje herní výsledky. Jde o takové zpestření hry a něco, na co se může hráč soustředit navíc. Je tu spíš pro stálé hráče, kteří chtějí zkusit něco nového, co si také i odnesou do další sezóny. Vaše získané úkoly se totiž nenulují s restartem a můžete je tedy sbírat v průběhu několika sezón. Ten, kdo posbírá všechny, dostane zatím tajnou odměnu.</span>
<br />
<br />
<form action="prehledy.php" method="get" name="form_questy">
<input type="hidden" name="action" value="questy" />
Filtr: {FILTR}
</form>
<br />
<strong class="extra" onclick="$('#splnene').toggle()" style="cursor: pointer"><span id="splnene_plus">-</span> Splněné questy:</strong> <span class="ultra">({SPLNENYCH}/{CELKEM})</span>
<br />
<div id="splnene" style="display: block">
{SPLNENE}
</div>
<br />
<br />
<strong class="extra" onclick="$('#zbyvajici').toggle()" style="cursor: pointer"><span id="zbyvajici_plus">-</span> Zbývající questy:</strong>
<br />
<div id="zbyvajici" style="display: block">
{OSTATNI}
</div>
<br />
<br />
{::MISC}

{TABLE SPLNENE}
{ROW}
<div class="quest">
<br />
<div class="quest_nazev">{NAZEV}</div>
<div class="oddelovac"></div>
<div class="quest_text">
{POPIS}<br />
<span class="ultra">{TYP2}</span>
</div>
<div class="oddelovac"></div>
</div>
{::ROW}
{::TABLE}

{TABLE FILTR QUESTY}
<select name="typ" onchange="document.form_questy.submit()">
	<option value="all">Všechny</option>
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{MISC STATS}
<h3>Hall of Fame</h3>
<br /><br />
{ZEBRICEK}
<br />
<br />
<strong>Nejvíce splněných questů: </strong>
{QUESTY}
<br />
<br />
{::MISC}

{TABLE STATS1}
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="2"><strong>Celkové statistiky</strong></td>
  </tr>
  
  {ROW}<tr>
	  <td class="val">{NAME}:&nbsp;&nbsp;&nbsp;</td>
	  <td style="text-align: left"><a href="showProfile.php?id={ID}">{LOGIN}</a> <span class="ultra">({VALUE})</span></td>
  </tr>{::ROW}
  
  <tr>
  	<td colspan="2" class="lista"></td>
  </tr>
</table>
{::TABLE}

{TABLE QUESTY_LADDER}
<br />
<br />
<table cellpadding="6" cellspacing="3" class="budovy">
	<tr><td style="background-color: black"></td><td style="background-color: black">Hráč</td><td style="background-color: black">Questů</td><td style="background-color: black">Posledně splněný</td></tr>
	{ROW}<tr><td><span class="ultra">{I}.</span></td><td><a href="showProfile.php?id={LOGIN}" class="extra">{NICK}</a></td><td><span class="ultra">{QUESTU}</span></td><td><a class="submit" onclick="jHadr('prehledy.php?action=quest_info',{id: '{QUEST_ID}'})">{QUEST}</a></td></tr>{::ROW}
</table>
{::TABLE}