{MAIN}
<h3>Nastavení</h3>
Zde si můžes nastavit všechno, co se týká tvého hráčského účtu, jako jsou hesla, herní menu, ICQ, rasu do příští sezóny, tvůj popis a také zde najdeš nastavení informační pošty ze závodů.
<br />
<br />
<br />

<h3 class="submit" onclick="$('#rasa').toggle('normal')">Změna rasy a kluzáku</h3>
<span style="display: none" id="rasa">
	Pokud si přeješ příští sezónu hrát za jinou rasu nebo začínat s jiným kluzákem a vyzkoušet tak třeba jiný herní styl, zde je to pravé místo. Rasa se změní až s restartem hry, do té doby si můžeš zvolit rasu kolikrát chceš (až ta poslední změna se bude počítat). Rasa ti zůstane do restartu stejná jako máš teď.
	<br />
	<br />
	Změnu rasy a kluzáku provedeš <a href="newRasa.php">zde</a><br />
</span>
<hr />

<h3 class="submit" onclick="$('#posta').toggle('normal')">Pošta ze závodů</h3>
<span style="display: none" id="posta">
	<form action="change.php?action=posta_zavody" method="post">
	<input type="checkbox" {CHECKED} name="posta" />
	Přijímat poštou výsledky závodů
	<input type="submit" value=" Změnit " />
	</form>
	<form action="change.php?action=posta_zavody2" method="post">
	<input type="checkbox" {CHECKED2} name="posta" />
	Oznamovat vstupy do tvojich závodů
	<input type="submit" value=" Změnit " />
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#nabidka').toggle('normal')">Přizpůsobit nabídku</h3>
<span style="display: none" id="nabidka">
	V této sekci si můžete libovolně změnit a přeorganizovat herní menu (vlevo) a přidat si do ní vámi nejpoužívanější odkazy a sekce.<br />
	<br />
	Změnu nabídky provedeš <a href="nastaveni.php?action=menu">zde</a>.
</span>
<hr />

<h3 class="submit" onclick="$('#info').toggle('normal')">Přizpůsobit 'rychlé info'</h3>
<span style="display: none" id="info">
	<form action="change.php?action=rychle_info" method="post">
		{INFO}
		<br />
		<input type="submit" value=" Uložit " />
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#avatar').toggle('normal')">Změna avataru</h3>
<span style="display: none" id="avatar">
	<form action="change.php?action=avatar" method="post" enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="0">
	<tr>
	  <td>Nahrát obrázek:</td>
	</tr>
	<tr>
	  <td><input type="file" name="obr" /></td>
	</tr>
	<tr>
	  <td>Obrázek bude zmenšen na velikost 150x230 (poměr stran zůstane).<br />
	Nahrávejte ve formátu jpeg, bmp, png a gif (statický)<br />
	Obrázky s nevhodným obsahem budou bez milosti mazány!</td>
	</tr>
	<tr>
	  <td style="text-align: right"><input type="submit" value=" Nahrát " /></td>
	</tr>
	</table>
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#heslo').toggle('normal')">Změna hesla</h3>
<span style="display: none" id="heslo">
	<form action="change.php?action=password" method="post">
	<table cellpadding="0" cellspacing="0">
	<tr>
	  <td>Staré heslo: </td><td><input type="password" name="old" maxlength="15" /></td>
	</tr>
	<tr>
	<td>Nové heslo: </td><td><input type="password" name="new" maxlength="15" /></td>
	</tr>
	<tr>
	<td>Nové heslo znovu: &nbsp;&nbsp;&nbsp;</td><td><input type="password" name="new2" maxlength="15" /></td>
	</tr>
	<tr>
	<td colspan="2" style="text-align: right">
	<input type="submit" value=" Změnit " />
	</td>
	</tr>
	</table>
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#irc').toggle('normal')">Změna IRC hesla</h3>
<span style="display: none" id="irc">
	Toto heslo použijete na IRC, pokud se budete přihlašovat u <a href="http://world.qsb.cz/clanek/66/qsbot_manual">QSBota</a>.<br /><br />
	<form action="change.php?action=irc_password" method="post">
	<table cellpadding="0" cellspacing="0">
	<tr>
	<td>Nové heslo: &nbsp;&nbsp;&nbsp;</td><td><input type="password" name="new" maxlength="15" /></td>
	</tr>
	<tr>
	<td colspan="2" style="text-align: right">
	<input type="submit" value=" Změnit " />
	</td>
	</tr>
	</table>
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#popis').toggle('normal')">Změna popisu</h3>
<span style="display: none" id="popis">
<form action="change.php?action=popis" method="post">
<table cellpadding="0" cellspacing="0">
<tr>
  <td>Změnit popis:</td>
</tr>
<tr>
  <td><textarea cols="42" rows="6" name="popis">{POPIS}</textarea></td>
</tr>
<tr>
  <td style="text-align: right"><input type="submit" value=" Změnit " /></td>
</tr>
</table>
</form>
</span>
<hr />

<h3 class="submit" onclick="$('#icq').toggle('normal')">Změna ICQ</h3>
<span style="display: none" id="icq">
	<form action="change.php?action=icq" method="post">
	<table cellpadding="0" cellspacing="0">
	<tr>
	  <td>Změnit icq: &nbsp;</td>
	  <td><input type="text" name="icq" maxlength="9" size="8" value="{ICQ}" /></td>
	</tr>
	<tr>
	  <td style="text-align: right" colspan="2"><input type="submit" value=" Změnit " /></td>
	</tr>
	</table>
	</form>
</span>
<hr />

<h3 class="submit" onclick="$('#delete').toggle('normal')">Smazat login</h3>
<span style="display: none" id="delete">
	<form action="change.php?action=smazat" method="post">
	Pokud už si nepřeješ dále hrát, můžeš si zde smazat login. Operace je to vratná, ale jen do doby, než přijde první restart (čili do začátku nové sezóny).
	Pokud by jsi smazání chtěl později vrátit, dej vědět adminovi na adrese drhadr@gmail.com nebo na icq 315389695 a on se pokusí proces zvrátit.<br />
	<br />
	<table cellpadding="0" cellspacing="0">
	<tr>
	  <td>Potvrdit heslem: &nbsp;</td>
	  <td>
		<input type="password" name="heslo" />
	  </td>
	</tr>
	<tr>
	  <td style="text-align: right" colspan="2"><input type="submit" value=" Změnit " /></td>
	</tr>
	</table>
	</form>
</span>
<br />
<br />
{::MAIN}

{EXT ZAVODY}<h3>Změna přijímání pošty</h3>
Změna přijímání pošty proběhla úspěšně.<br />{::EXT}
{EXT ZPET}<br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT POPIS1}<h3>Změna popisu</h3>
Změna popisu proběhla úspěšně.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT POPIS2}<h3>Změna popisu</h3>
Změna popisu neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT EXTRA1}Odteď tě o odjetí závodu bude informovat pošta. Přijde ti výsledné pořadí a seznam škod na tvém kluzáku (pokud nějaké budou)<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT EXTRA2}Odteď tě bude o všech vstupech/odstupech z tebou založených závodů bude informovat pošta.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT ZAVODY2}<h3>Změna přijímání pošty</h3>
Změna přijímání pošty neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT SKIN1}<h3>Změna skinu</h3>
Změna skinu proběhla úspěšně.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT SKIN2}<h3>Změna skinu</h3>
Změna skinu neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT HESLO1}<h3>Změna hesla</h3>
Změna hesla proběhla úspěšně.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT HESLO2}<h3>Změna hesla</h3>
Změna hesla neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT ICQ1}<h3>Změna ICQ</h3>
Změna ICQ proběhla úspěšně.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT ICQ2}<h3>Změna ICQ</h3>
Změna ICQ neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT EMAIL1}<h3>Změna e-mailu</h3>
Změna e-mailu proběhla úspěšně.<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}
{EXT EMAIL2}<h3>Změna e-mailu</h3>
Změna e-mailu neproběhla úspěšně. Kontaktuj prosím admina nebo to hoď na chybové fórum<br /><br /><a href="nastaveni.php">Zpět na nastavení</a>{::EXT}

{EXT MENU}
<script type="text/javascript">
<!--
var chosen;

function addCat() {
	if(!isNaN(chosen)) {
		if(nazev = prompt("Zadej jméno nové podkategorie","")) {
			location = "nastaveni.php?action=add&id="+chosen+"&nazev="+nazev;
		}
	} else {
		alert('Nebyla vybrána sekce!');
	}
}

function addCatMain(id) {
	location = "nastaveni.php?action=add&id="+document.getElementById('sekce').value;
}

function deleteC() {
	if(!isNaN(chosen)) {
		if(confirm("Opravdu smazat položku "+document.getElementById("kat_"+chosen).innerHTML+"?")) {
			location = "nastaveni.php?action=delete&id="+chosen;
		}
	} else {
		alert('Nebyla vybrána sekce!');
	}
}

function move(dir) {
	if(!isNaN(chosen)) {
		location = "nastaveni.php?action=move&dir="+dir+"&id="+chosen;
	} else {
		alert('Nebyla vybrána sekce!');
	}
}

function choose(id) {
	if(!isNaN(chosen)) {
		document.getElementById("kat_"+chosen).style.fontWeight = "normal";
		document.getElementById("td_"+chosen).style.backgroundColor = "#000";
		document.getElementById("kat_"+chosen).style.color = "#FFFFFF";
	}
		
	chosen = id;
	document.getElementById("kat_"+chosen).style.fontWeight = "bold";
	document.getElementById("kat_"+chosen).style.color = "#333";
	document.getElementById("choosed").innerHTML = '<strong class="ultra" style="font-style: normal">Vybraná&nbsp;položka</strong>&nbsp; '+document.getElementById("kat_"+chosen).innerHTML;
	
	document.getElementById("td_"+chosen).style.backgroundColor = "#111";
	document.getElementById("kat_"+chosen).style.color = "#FF9900";
} 
//-->
</script>
<h3>Přizpůsobit herní nabídku</h3>
V této sekci si můžete libovolně změnit a přeorganizovat herní menu (vlevo) a přidat si do ní vámi nejpoužívanější odkazy a sekce.
<br /><br />
{ULOZIT}
<table class="kategorie_edit" cellspacing="0" style="width: 450px">
	<tr class="hlavicka">
		<td colspan="5"><strong>Ovládací panel</strong></td>
	</tr>
	<tr>
		<td><strong class="ultra">Přidat položku</strong></td><td style="border-left-width: 0px">{SEKCE}</td><td colspan="3" style="border-right: 1px solid #444; text-align: right"><a href="#" onclick="addCatMain()">přidat vybranou položku</a></td>
	</tr>
	<tr>
		<td colspan="2" id="choosed"><strong class="ultra" style="font-style: normal">Vybraná&nbsp;položka</strong>&nbsp;</td>
		<td style="width: 2px; vertical-align: top"><a href="#" onclick="deleteC()">smazat</a></td>
		<td style="width: 2px; vertical-align: top"><a href="#" onclick="move('up')">nahoru</a></td>
		<td style="width: 2px; vertical-align: top; border-right: 1px solid #444"><a href="#" onclick="move('down')">dolů</a></td>
	</tr>
</table>
<br />
<br />
{MENU}
<br />
<br />
{::EXT}

{TABLE SEKCE}
<select id="sekce" style="position: relative; left: 10px; top: 1px;">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE MENU}
<table class="kategorie_edit" cellspacing="0" style="text-align: center">
	<tr class="hlavicka">
		<td><strong>Aktuální vzhled menu</strong></td>
	</tr>
	{ROW}
	<tr>
		<td style="border-right: 1px solid #444; font-size: 11px" class="submit" id="td_{ID}" onclick="choose({ID})"><span id="kat_{ID}">{NAZEV}</span></td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{MISC EMAIL}
<h3 class="submit" onclick="$('#email').toggle('normal')">Změna e-mailu</h3>
<span style="display: none" id="email">
	<form action="change.php?action=email" method="post">
	<table cellpadding="0" cellspacing="0">
	<tr>
	  <td>Změnit e-mail: &nbsp;</td>
	  <td><input type="text" size="25" name="email" value="{EMAIL}" /></td>
	</tr>
	<tr>
	  <td style="text-align: right" colspan="2"><input type="submit" value=" Změnit " /></td>
	</tr>
	</table>
	</form>
</span>
<hr />
{::MISC}

{TABLE INFO}
	{ROW}<input type="checkbox" name="{NAZEV}" id="{NAZEV}"{CHECKED} /> <label for="{NAZEV}">{POPIS}</label><br />{::ROW}
{::TABLE}