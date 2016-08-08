{MAIN}
<style type="text/css">
#box {
	display: none;
	width: 160px;
	height: auto;
	background-color: #000000;
	border: 1px solid #FF9900;
	position: fixed;
	z-index: 10;
	padding: 4px;
	overflow: hidden;
	text-align: left;
}

#box span {
	color: #585858;
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
</style>
<h3>Závody</h3>
<ul style="float: left; position: relative; left: 30px">
	<li><a href="zavody.php?action=neodjete&empty=on&kat=on">Neodjeté závody</a></li>
	<li><a href="zavody.php?action=odjete">Odjeté závody</a></li>
	<li><a href="zavody.php?action=zalozit">Založit závod</a></li>
</ul>
<ul style="float: right; position: relative; left: -90px">
	<li><a href="zavody.php?action=mojeneodjete">Moje neodjeté závody</a></li>
	<li><a href="zavody.php?action=mojeodjete">Moje odjeté závody</a></li>
	<li><a href="zavody.php?action=zalozene">Mnou založené závody</a></li>
</ul>
{::MAIN}

{EXT PODSEKCE}
<hr style="clear: both" />
<br />
Vyber prosím podsekci <br />
<br />
{::EXT}

{EXT ETAPA}
<hr style="clear: both" />
<br />
Závody lze zakládat až od druhé etapy.
{::EXT}

{EXT DOTACE}
<hr style="clear: both" />
<h3>Založení závodu</h3>
<br />
<form action="zavody.php?action=zalozit" method="post" style="margin-left: 20px">
	Zvol dotaci pro tvůj závod:
	<input type="text" name="dotace"  />
	<input type="submit" value=" Založit závod " class="submit" />
	<br />
	{PREDMET}
	<br />
	<br />
	Dotace musí být zadána předem, aby mohly být vybrány tratě s vhodnou délkou a obtížností pro tvou dotaci. Další informace o tvém závodu budeš nastavovat v druhém kroku zakládání. <br />
	<br />
	Dotace musí být <strong class="extra">{DOTACE_MIN}</strong> - <strong class="extra">{DOTACE_MAX} Is</strong> <em>(včetně ceny předmětu)</em><br />
	<strong class="extra">Předmět se započítává do dotací polovinou své ceny</strong> (ve výběru jsou<br /> už ceny poloviční)
	<br />
	<br />
	Za založení závodu platíš <strong class="extra">{ZAVOD_ZAKLADANI} Is</strong> + zvolenou dotaci. 
	<br />
	Předmět (pokud jsi ho použil jako cenu) ti zůstane ve skladu, ale nesmí už s ním být nijak operováno.
	<br />
	<br />
</form>
{::EXT}

{TABLE PREDMETY_CENY}
	<br />
	Přidat vlastní předmět jako výherní cenu: <em>(nepovinné)</em>
	<select name="predmet">
		<option value=""></option>
		{ROW}<option value="{ID}">{TYP} - {NAZEV} - {VYDRZ}% ({CENA} Is)</option>{::ROW}
	</select>	
{::TABLE}

{EXT ZALOZIT}
<script language="JavaScript">
<!--
	function sure() {
		if(confirm("Opravdu založit závod? Bude tě to stát částku uvedenou v dotacích + {ZAVOD_ZAKLADANI} Is")) {
			document.form1.nova.click();
		}
	}
//-->
</script>
<hr style="clear: both" />
<h3>Založení závodu</h3>
<br />
<strong class="extra">Prestiže</strong> - vynechat oboje (popř. vložit 0) znamená bez omezení. Jedno nechat volné, jedno vyplnit -> otevřené (např. 1100+ uděláte vložením hodnot 1100 a 0). Při vyplnění obou 
prestiží musí být první hodnota menší.<br />
<br />
<strong class="extra">Cena kluzáka</strong> - Hráč má přístup jen do své a do o jeden stupeň vyšší cenové kategorie (podle ceny kluzáku).<br />
<br />
<strong class="extra">Tratě</strong> - Výběr tratí je omezený podle dotace závodu - nemůžes odjet závod o 100 000 Is na trati o 5 úsecích a nulové obtížnosti. Maximální dotace je v profilu každé trati. <br />
<br />
<br />
<form action="new_zavod.php" method="post" name="form_zavod" style="margin-left: 28px">
	<table cellspacing="1" cellpadding="0">
		<tr>
			<td>Název: </td>
			<td><input type="text" name="nazev" /></td>
		</tr>
		<tr>
			<td>Minimální vklad: </td>
			<td><input type="text" name="vklad" /></td>
		</tr>
		<tr>
			<td>Počet závodníků: &nbsp;&nbsp; </td>
			<td><select name="minimum">
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
				až
				<select name="pocet">
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Dotace: </td>
			<td><input type="hidden" name="dotace" value="{DOTACE2}" />
				<input type="text" name="dotace2" value="{DOTACE1} " style="border-color: #181818; color: #666; text-align: right" disabled="disabled" />
				<a href="zavody.php?action=zalozit">změnit dotaci</a></td>
		</tr>
		<tr>
			<td><img src="skin/img/star.jpg" alt="Výherní předmět" /> Výherní předmět: </td>
			<td style="padding-top: 3px; padding-bottom: 3px"><input type="hidden" name="predmet" value="{ID_P}" />{PREDMET}</td>
		</tr>
		<tr>
			<td>Cena kluzáku: </td>
			<td>{CENY}</td>
		</tr>
		<tr>
			<td>Min prestiž: </td>
			<td><input type="text" name="prestiz" /></td>
		</tr>
		<tr>
			<td>Max prestiž: </td>
			<td><input type="text" name="prestiz2" /></td>
		</tr>
		<tr>
			<td><img src="skin/img/locker.jpg" alt="Heslo" /> Heslo: </td>
			<td><input type="password" name="heslo" />
				<em>(není povinné)</em></td>
		</tr>
		<tr>
			<td>Trať: </td>
			<td>{TRATE}</td>
		</tr>
		<tr>
			<td>Datum: </td>
			<td>{DATUM}</td>
		</tr>
		<tr>
			<td>Čas: </td>
			<td><select name="cas">
					<option value="13">13:00</option>
					<option value="16">16:00</option>
					<option value="19">19:00</option>
					<option value="0" selected="selected">23:00</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Popis: </td>
			<td><textarea name="popis" cols="32" rows="4"></textarea></td>
		</tr>
	</table>
	<br />
	<br />
	<input type="button" value="Založit" onclick="jHadr('new_zavod.php','form_zavod')" />
</form>
{::EXT}

{TABLE TRATE}
<select name="trat">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE DATUM}
<select name="datum">
	{ROW}<option value="{CAS}">{DATUM}</option>{::ROW}
</select>
{::TABLE}

{TABLE CENY}
<select name="cena">
	{ROW}<option value="{ID}">{VALUE}</option>{::ROW}	
	<option value="-1">Neomezeno</option>
</select>
{::TABLE}