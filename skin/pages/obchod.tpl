{MAIN}
<style type="text/css">
#box {
	display: none;
	width: 160px;
	height: 30px;
	background-color: #000000;
	border: 1px solid #FF9900;
	position: fixed;
	margin-top: 85px;
	z-index: 10;
	padding: 4px;
	overflow: hidden;
	text-align: left;
}

#box strong {
	position: relative;
	top: -2px;
}

.zavody tr:hover td {
	background-color: #191919;
}

.oddelovac:hover td {
	background-color: #191919;
}

#box span {
	color: #585858;
}
</style>

<h3>Obchod</h3>
<ul style="float: left; position: relative; left: 30px">
	<li><a href="obchod.php?action=casti&filtr=1">Koupit předmět</a></li>
	<li><a href="obchod.php?action=sklad">Můj sklad</a></li>
	<li><a href="obchod.php?action=vyloha">Moje výloha</a></li>
	<li><a href="obchod.php?action=sablony">Přednastavené kluzáky</a></li>
</ul>
<ul style="float: right; position: relative; left: -90px">
	<li><a href="obchod.php?action=paliva">Paliva</a></li>
	<li><a href="obchod.php?action=opravari">Opraváři</a></li>
	<li><a href="prehledy.php?action=finance">Finance</a></li>
	<li><a href="items.php">Přehled předmětů</a></li>
</ul>
<hr style="clear: both" />
{OBSAH}
{::MAIN}

{EXT PRAZDNY_SKLAD}
<h3>Sklad</h3>
Tvůj sklad je prázdný
{::EXT}

{MISC PRAZDNA_VYLOHA}
<br />
<br />
Výloha je prázdná
{::MISC}

{EXT VYLOHA}
<h3>Výloha hráče {HRAC}</h3>
{PREDMETY}
<br />
<br />
{::EXT}

{MISC ZADNI_HRACI}
<br />Žádní hráči<br /><br />
{::MISC}

{MISC SKLAD}
<h3>Sklad</h3>
<br />
&nbsp;&nbsp;&nbsp;&nbsp;<a href="repair.php?action=all">Opravit všechny předměty v kluzáku</a>
{PREDMETY}
<br /><br />
{PALIVA}
<div id="box"></div>
{::MISC}

{MISC VYLOHA}
<h3>Výloha</h3>
{ZMENA}
{PREDMETY}
<br /><br />
{PALIVA}
{::MISC}

{EXT VYLOHA_CENA}
Prodejní cena musí být v rozmezí <strong>{CENA1} </strong>-<strong> {CENA2}</strong>.
<br />
<br />
<form action="vyloha.php" method="post" name="vyloha_cena">
	<input type="hidden" name="action" value="{ACTION}" />
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="vyloha" value="{VYLOHA}" />
	Zvol prodejní cenu: <input type="text" name="cena" value="{CENA3}" />
</form>
{::EXT}

{EXT VYLOHA_SABLONA}
Tento předmět je použit v některé z tvých šablon <strong>({SABLONY})</strong>. Pokud bude předmět prodán, všechny šablony, které tento předmět používají budou smazány spolu s ním. Umístěním do výlohy ale šablony nesmažeš.
<form action="vyloha.php" method="post" name="vyloha_cena">
	<input type="hidden" name="action" value="nastav_cenu" />
	<input type="hidden" name="action2" value="sablony" />
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="vyloha" value="{VYLOHA}" />
	<input type="hidden" name="cena" value="{CENA}" />
</form>
{::EXT}

{MISC SKRYT_VYLOHU}<div style="margin-left: 25px"><a href="vyloha.php?action=skryt">Skrýt výlohu před systémovými obchodníky</a> <span class="ultra">(během přepočtů)</span></div>{::MISC}
{MISC ZOBRAZIT_VYLOHU}<div style="margin-left: 25px"><a href="vyloha.php?action=zobrazit">Umožnit prodej předmětů systémovým obchdníkům</a><br />
<span class="ultra">(během přepočtů kupují náhodně předměty, ale za nižsí ceny)</span></div>{::MISC}

{MISC PALIVA}
<h3>Paliva</h3>
Maximální nezdaněná velikost tvého skladu: <span class="extra">{VELIKOST} l</span><br />
<span class="ultra">(přes {VELIKOST} l paliva na skladu platíš každý přepočet údržbu)</span><br />
{ZVETSIT}
<br />
{MUJ_MOTOR}
{PALIVA}
<br />
<br />
{::MISC}

{MISC CASTI}
<h3>Nákup částí kluzáků</h3>
<a href="http://world.qsb.cz/clanek/58/jak_efektivne_nakupovat" target="_blank">Zde</a> je návod, jak nejefektivněji nakoupit předmět.<br />
Vyber obchodníka, u kterého chceš nakupovat:<br /><br />
{OBCHODNICI}
<form action="obchod.php?action=casti" method="get" name="form1">
	<input type="hidden" value="{ACTION}" name="action" />
    Filtr: 
	{FILTER}
	<input type="submit" class="submit" name="ok" style="display: none" value="" />
	&nbsp;&nbsp;<a href="showVyloha.php?action=all">Zobrazit kompletní výlohu všech hráčů</a>
	<br /><br />
</form>
{HRACI}
{::MISC}

{TABLE TYP}
{ROW}
<br /><br />
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="kluzak2_items">
		<td class="val"><img src="./skin/img/{PIC}.jpg" alt="{NAZEV}" onclick="location='items.php?typ={J}'" class="submit" style="width: 80px; height: 64px" /></td>
		<td>{NAZEV}</td>
	</tr>	
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="horni">
		<td class="prvni">Název</td>
		<td style="text-align: center; width: 3px">&nbsp;Opotřebení&nbsp;</td>	  
		<td style="text-align: center;">&nbsp;&nbsp;&nbsp;Cena&nbsp;&nbsp;&nbsp;</td>
		<td style="text-align: right; padding-right: 8px;">Přemístit</td>
	</tr>
		{PREDMETY}
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0" style="border-top-width: 0px">
	<tr>
		<td class="lista"></td>
	</tr>
</table>
{::ROW}
{::TABLE}

{TABLE PREDMETY}
{ROW}
<tr class="kluzak2_items">
	<td class="prvni" style="width: 120px"><a href="showItem.php?id={ID}&typ={TYP}" class="common">{NAZEV}</a>&nbsp;<span class="ultra">{TYP2}</span></td>
	<td style="text-align: center">{VYDRZ}</td>
	<td style="text-align: center">{CENA}</td>
	{AKCE}
</tr>
{::ROW}
{::TABLE}

{TABLE PALIVA}
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="kluzak2_items">
		<td class="val"><img src="./skin/img/drop.jpg" alt="Palivo" style="width: 80px; height: 64px" onclick="location='obchod.php?action=paliva'" class="submit" /></td>
		<td>Paliva</td>
	</tr>	
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0">
	<tr class="horni">
	  <td class="prvni">Název</td>
	  <td>Množství</td>
	  <td>Cena (kg/l/ks)</td>
	  <td>&nbsp;</td>
	</tr>
	{ROW}
	<tr>
		<td class="prvni" style="height: 19px; vertical-align: middle"><a href="buyPalivo.php?id={ID}" style="color: white">{NAZEV}</a></td>
		<td>{MNOZSTVI} {JEDNOTKA}</td>
		<td>{CENA}</td>
		<td style="text-align: right; padding-right: 8px;"><a class="submit" onclick="jHadr('sellPalivo.php?id={ID}', {})">Prodat</a></td>
	</tr>	
	{::ROW}
</table>
<table class="kluzak2" cellspacing="0" cellpadding="0">
<tr><td class="lista"></td></tr>
</table><br /><br />
{::TABLE}

{MISC MUJ_MOTOR}
<table cellspacing="0" cellpadding="0" class="prehledy" style="width: 290px">
	<tr class="horni">
		<td>&nbsp;Palivo pro tvůj motor</td>
		<td style="text-align: right">Is/l(kg,ks)&nbsp;&nbsp;</td>
		<td style="text-align: right; padding-right: 10px">+/-</td>
	</tr>
	<tr class="submit" onclick="location='buyPalivo.php?id={ID}'">
		<td>&nbsp;&nbsp;{NAZEV}</td>
		<td style="text-align: right">{CENA}&nbsp;&nbsp;&nbsp;</td>
		<td style="text-align: right; padding-right: 6px">{ZMENA}</td>
	</tr>	
	<tr>
		<td class="lista" colspan="3"></td>
	</tr>
</table>
<br />
<br />
{::MISC}

{MISC ZMENA1}
<span style="color: #FF0000">{ZMENA}</span>
{::MISC}

{MISC ZMENA2}
<span style="color: #02FD09">{ZMENA}</span>
{::MISC}

{TABLE PALIVA2}
<table cellspacing="0" cellpadding="0" class="prehledy" style="width: 290px">
	<tr class="horni">
		<td>&nbsp;Ceník paliv</td>
		<td style="text-align: right">Is/l(kg,ks)&nbsp;&nbsp;</td>
		<td style="text-align: right; padding-right: 10px">+/-</td>
	</tr>
	{ROW}
	<tr class="submit" onclick="location='buyPalivo.php?id={ID}'">
		<td>&nbsp;&nbsp;{NAZEV}</td>
		<td style="text-align: right">{CENA}&nbsp;&nbsp;&nbsp;</td>
		<td style="text-align: right; padding-right: 6px">{ZMENA}</td>
	</tr>
	{::ROW}
	<tr>
		<td class="lista" colspan="3"></td>
	</tr>
</table>
{::TABLE}

{TABLE OBCHODNICI}
<table cellspacing="0" cellpadding="0" class="prehledy" style="width: 390px">
	<tr class="horni">
		<td>&nbsp;&nbsp;&nbsp;&nbsp;Jméno</td>
		<td>Specializace</td>
		<td>Rasa</td>
	</tr>
	{ROW}
	<tr onclick="location='showGoods.php?id={ID}'" style="cursor: pointer">
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="showGoods.php?id={ID}">{NAZEV}</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><a href="showGoods.php?id={ID}">{TYP}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>{RASA}</td>
	</tr>
	{::ROW}
	<tr>
		<td colspan="3" class="lista"></td>
	</tr>
</table>
<br /><br />
{::TABLE}

{TABLE FILTER}
<select name="soucastka" onchange="document.form1.ok.click()">
	<option value="0">Všechno</option>
	{ROW}<option value="{VALUE}"{CHECKED}>{NAZEV}</option>{::ROW}	
</select>
{::TABLE}

{TABLE HRACI}
<table cellspacing="0" cellpadding="0" class="prehledy" style="width: 390px">
	<tr class="horni">
		<td>&nbsp;&nbsp;&nbsp;&nbsp;Hráč</td>
		<td>Rasa</td>
		<td style="width: 3px">&nbsp;Věcí&nbsp;</td>
		<td style="width: 3px">&nbsp;</td>
	</tr>
	{ROW}
	<tr>
		<td style="width: 90px">&nbsp;&nbsp;<a href="showVyloha.php?id={LOGIN}&typ={TYP}">{NICK}</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>{RASA}</td>
		<td style="text-align: center">{POCET}</td>
		<td style="text-align: right;"><a href="showVyloha.php?id={LOGIN}&typ={TYP}">&nbsp;&nbsp;Ukaž&nbsp;výlohu&nbsp;&nbsp;</a></td>
	</tr>	
	{::ROW}
	<tr>
		<td colspan="4" class="lista"></td>
	</tr>
</table>
<br /><br />
<br /><br />
<br /><br />
{::TABLE}

{EXT SROT}
Za zešrotování předmětu <strong>{NAZEV}</strong> dostaneš <strong class="extra">{CENA} Is</strong>.
{::EXT}

{EXT OPRAVA}
<h3>Oprava předmětu</h3>
Chystáš se opravit předmět <strong>{NAZEV}</strong>. Bude tě to stát <strong class="extra">{CENA} Is</strong>, protože předmět je opotřeben na <strong>{VYDRZ}%</strong>.<br />
Oprava bude trvat <strong class="extra">{DELKA}</strong> a bude hotova v <strong class="extra">{CAS}</strong>
<br />
<br />
{TLACITKO}
<br /><br />
<a href="obchod.php?action=sklad">Zpět</a>
{::EXT}

{MISC TLACITKO}
<form action="repair.php?sure=sure2&id={ID}&action2={ACTION2}" method="post" name="form_oprava">
{DROIDI}
<input type="submit" class="submit" value=" Opravit " />
</form>
{OPRAVARI}
{::MISC}

{MISC DROIDI1}
Vybrat droida pro opravu: <select name="droid1"><option value="">žádný</option>{DROIDI_SELECT}</select>
<br />
<br />
{::MISC}

{MISC DROIDI2}
<table cellpadding="4" cellspacing="4">
<tr><td>Vybrat droidy pro opravu: </td><td><select name="droid1" onchange="if(document.form_oprava.droid2.value == this.value) document.form_oprava.droid2.value = ''"><option value="">žádný</option>{DROIDI_SELECT}</select></td></tr>
<tr><td></td><td><select name="droid2" onchange="if(document.form_oprava.droid1.value == this.value) document.form_oprava.droid1.value = ''"><option value="">žádný</option>{DROIDI_SELECT}</select></td></tr>
</table>
<br />
<br />
{::MISC}

{TABLE DROIDI_SELECT}{ROW}<option value="{ID}">{NAZEV} {U}/{S}% {V}%</option>{::ROW}{::TABLE}

{TABLE OPRAVARI}
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="background-color: black">Hráč</td>
		<td style="background-color: black">Online</td>
		<td style="background-color: black">Volní droidi</td>
		<td style="background-color: black">Cena</td>
		<td style="background-color: black">Minimum</td>
	</tr>
	{ROW}
	<tr>
		<td style="text-align: left"><a href="showProfile.php?id={LOGIN}">{NICK}</a></td>
		<td style="text-align: left">{ONLINE}</td>
		<td>{DROIDI1}/{DROIDI2}</td>
		<td class="extra">{PROCENTA}%</td>
		<td style="text-align: right" class="extra">{MINIMUM}</td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{TABLE OPRAVARI2}
<h4>Opravit u jiného hráče</h4>
Touto možností můžeš nechat předmět opravit levněji u jiných hráčů (platíš cenu se slevou). Ke krádeži předmětu dojít nemůže, takže se nemáš čeho bát.
<br />
<br />
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="background-color: black">Hráč</td>
		<td style="background-color: black">Online</td>
		<td style="background-color: black">Volní droidi</td>
		<td style="background-color: black">Sleva</td>
		<td style="background-color: black">Výsledná cena</td>
		<td style="background-color: black">&nbsp;</td>
	</tr>
	{ROW}
	<tr>
		<td style="text-align: left"><a href="showProfile.php?id={LOGIN}">{NICK}</a></td>
		<td style="text-align: left">{ONLINE}</td>
		<td>{DROIDI1}/{DROIDI2}</td>
		<td>{PROCENTA}%</td>
		<td><span class="extra">{CENA}</span></td>
		<td><a href="opravar.php?action=opravit&zbozi={ZID}&login={LOGIN}">Opravit</a></td>
	</tr>
	{::ROW}
</table>
<br />
<br />
{::TABLE}

{MISC OPRAVARI}
<h3>Opraváři</h3>
Zde můžeš vidět přehled registrovaných opravářů, sám se registrovat, nebo si upravit svá opravářská nastavení.
<br />
{OPRAVARI}
{REGISTRACE}
{::MISC}

{MISC REGISTRACE}
<h4>Registrovat se jako opravář</h4>
Registrace tě bude stát <span class="extra">{OPRAVAR_REGISTRACE} Is</span> a každá další změna údajů <span class="extra">{OPRAVAR_ZMENA} Is</span>. Denně budeš odvádět <span class="extra">{OPRAVAR_DENNE} Is</span> cechu opravářů a pokud nebudeš mít na splacení, budeš z cechu vyloučen a muset provést registraci znovu.<br />
Sleva říká, kolik procent originální ceny opravy ti hráč zaplatí<br />
Registraci doporučujeme jen pokročilejším hráčům.
<br />
<br />
<form action="opravar.php?action=registrace" method="post">
Cena: <input type="text" name="sleva" size="4" />%<br />
<span class="ultra">(Rozmezí slev musí být v rozpětí 50-130%)</span>
<br />
<br />
Minimální cena opravy: <input type="text" name="minimum" size="4" value="0" /> Is<br />
<span class="ultra">(Změna zdarma, levnější opravy nebudeš moct přijímat)</span>
<br />
<br />
<input type="submit" value=" Registrovat " class="submit" />
<br />
<br />
</form>
{::MISC}

{MISC ZMENA_REGISTRACE}
<h4>Otevřené smlouvy</h4>
{SMLOUVY}
<br />
<br />
<h4>Změnit údaje</h4>
Registrace tě bude stát <span class="extra">{OPRAVAR_REGISTRACE} Is</span> a každá další změna údajů <span class="extra">{OPRAVAR_ZMENA} Is</span>. Denně budeš odvádět <span class="extra">{OPRAVAR_DENNE} Is</span> cechu opravářů a pokud nebudeš mít na splacení, budeš z cechu vyloučen a muset provést registraci znovu.<br />
Registraci doporučujeme jen pokročilejším hráčům.
<br />
<br />
<form action="opravar.php?action=zmena" method="post">
Cena: <input type="text" name="sleva" size="4" value="{PROCENTA}" />% &nbsp;&nbsp; <input type="submit" class="submit" value=" Změnit " /><br />
<span class="ultra">(Rozmezí slev musí být v rozpětí 50-130%)</span>
</form>
<br />
<form action="opravar.php?action=minimum" method="post">
Minimální cena: <input type="text" name="minimum" size="4" value="{MINIMUM}" /> Is &nbsp;&nbsp; <input type="submit" value=" Změnit " class="submit" /><br />
<span class="ultra">(Změna zdarma, levnější opravy nebudeš moct přijímat)</span>
</form>
<br />
<input type="button" value=" Zrušit opravářskou registraci " class="submit" onclick="if(confirm('Opravdu si přeješ zrušit tvojí registraci?')) location='opravar.php?action=zrusit_registraci'" style="margin-left: 40px" />
<br />
<br />
<br />
<br />
{::MISC}

{TABLE SMLOUVY}
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="background-color: black">Hráč</td>
		<td style="background-color: black">Peníze od hráče</td>
		<td style="background-color: black">&nbsp;</td>
	</tr>
	{ROW}
	<tr>
		<td style="text-align: left"><a href="posta.php?add={LOGIN}">{NICK}</a></td>
		<td><span class="extra">{PENIZE}</span></td>
		<td><a href="repair.php?action2=cizi&id={ID}">Opravit</a> / <a href="opravar.php?action=odmitnout&zbozi={ID}">Odmítnout</a></td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{MISC ZVETSIT}
<a href="obchod.php?action=zvetsit_sklad">Zvětšit sklad na {ZVETSENI} l za {ZVETSENI2} Is</a><br />
{::MISC}

{TABLE OPRAVA_VSEHO}
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td>Předmět</td>
		<td>Konečný čas</td>
		<td>Cena</td>
	</tr>
	{ROW}
	<tr style="color: #969696">
		<td>{TYP}</td>
		<td>{CAS}</td>
		<td style="text-align: right; color: #FF9900">{CENA}</td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{EXT OPRAVA_VSEHO}
<h3>Oprava více předmětů</h3>
Chystáš se opravit všechny součástky tvého kluzáku. Zde je seznam jednotlivých oprav. Potvrď prosím, že chceš opravu provést.
<br />
<br />
{SEZNAM}
<br />
<br />
<div style="text-align: center">
<input type="button" value=" Opravit " class="submit" onclick="location='repair.php?action=all&sub=sure'" />
&nbsp;&nbsp;&nbsp;
<input type="button" value=" Zrušit " class="submit" onclick="location='obchod.php?action=sklad'" />
</div>
{::EXT}