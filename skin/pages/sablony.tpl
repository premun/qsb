{MAIN}{OBSAH}{::MAIN}

{MISC OBCHOD}
<h3>Přednastavené šablony kluzáků</h3>
<ul>
	<li><a class="submit" onclick="jHadr('sablony.php', {action: 'nova'})">Vytvořit novou šablonu</a></li>
</ul>
{SABLONY}
{::MISC}

{MISC ZADNE_SABLONY}
<br /><br />Zatím nemáš žádnou vytvořenou šablonu
{::MISC}

{MISC JHADR_NOVA}
Chceš použít aktuální <strong>konfiguraci kluzáku</strong> (tak, jak ho máš teď nastavený v depu) nebo chceš <strong>vytvořit úplně novou šablonu</strong> kluzáku?
{::MISC}

{TABLE NOVA}
<h3>Tvorba nové šablony</h3>
<br />
<form action="sablony.php" method="post" style="margin-left: 0px" name="nova_sablona">
<input type="hidden" name="action" value="pridat" />
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="text-align: left">Název šablony:</td><td><input type="text" name="nazev" style="width: 165px" /></td>
	</tr>
	{ROW}
	<tr>
		<td style="text-align: left">{NAZEV}:</td><td>{SELECT}</td>
	</tr>
	{::ROW}
	<tr>
		<td colspan="2" style="background-color: #000000; padding-left: 0px; padding-right: 0px"><input type="button" value="Vytvořit šablonu" style="width: 100%" onclick="jHadr('sablony.php', 'nova_sablona')" /></td>
	</tr>
</table>
</form>
{::TABLE}

{TABLE NOVA_PREDMETY}
<select name="sablona_{NAZEV2}" style="width: 165px">
	{ROW}<option value="{ID}"{SELECTED}>{NAZEV}{TYP}</option>{::ROW}
</select>
{::TABLE}

{TABLE SABLONY}
<h4>Šablony</h4>
<table cellspacing="3" cellpadding="6" class="budovy">
	{ROW}
	<tr>
		<td style="text-align: left"><a href="sablony.php?action=zobrazit&id={ID}"><span class="extra">{NAZEV}</span></a></td><td>
		<a href="sablony.php?action=zobrazit&id={ID}">Zobrazit</a>
		<span class="ultra">&frasl;</span>
		<a class="submit" onclick="jHadr('sablony.php', {action: 'pouzit', id: '{ID}'})">Použít</a>
		<span class="ultra">&frasl;</span>
		<a class="submit" onclick="jHadr('sablony.php', {action: 'smazat', id: '{ID}'})">Smazat</a></td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{MISC ZOBRAZIT}
<h3>Detail šablony {NAZEV}</h3>
{VLASTNOSTI}
<br />
<a href="obchod.php?action=sablony">Zpět</a>
<hr />
<h3>Upravit šablonu</h3>
{UPRAVIT}
{::MISC}

{EXT UPRAVA_NADPIS}
<h3>Detail šablony</h3>
<br />
{::EXT}

{EXT NENALEZENA}Šablona nebyla nalezena{::EXT}
{EXT TVOJE}Šablona není tvoje{::EXT}

{TABLE UPRAVIT}
<br />
<form action="sablony.php?action=upravit&id={ID}" method="post" style="margin-left: 0px" name="uprava_sablony">
	<input type="hidden" name="sub" value="upravit" />
	<table cellspacing="3" cellpadding="6" class="budovy">
		<tr>
			<td style="text-align: left">Název šablony:</td><td><input type="text" name="nazev" style="width: 165px" value="{NAZEV}" onfocus="$('#ulozit_button').show('normal')" /></td>
		</tr>
		{ROW}
		<tr>
			<td style="text-align: left">{NAZEV}:</td><td>{SELECT}</td>
		</tr>
		{::ROW}
		<tr>
			<td colspan="2" style="background-color: #000000; padding-left: 0px; padding-right: 0px"><input id="ulozit_button" type="submit" value="Uložit změny" style="width: 100%; display: none" /></td>
		</tr>
	</table>
</form>
<br />
<a href="obchod.php?action=sablony">Zpět</a>
{::TABLE}

{TABLE UPRAVIT_PREDMETY}
<select name="sablona_{NAZEV2}" style="width: 165px" onchange="$('#ulozit_button').show('normal')">
	{ROW}<option value="{ID}"{SELECTED}>{NAZEV}{TYP}</option>{::ROW}
</select>
{::TABLE}

{TABLE VLASTNOSTI}
<table class="zavod" style="margin-left: 30px; width: 350px" cellspacing="1" cellpadding="1">
	<tr class="horni"><td colspan="2"><strong>Info</strong></td></tr>
	{ROW}<tr><td>{TITLE}</td><td>{VALUE}</td></tr>{::ROW}
	<tr><td colspan="2" class="lista"></td></tr>
</table>
{::TABLE}