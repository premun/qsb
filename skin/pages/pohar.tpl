{MAIN}
<h3>{NAZEV}</h3>
<br />
<strong>Aktuální stav poháru: </strong> {STAV}
{OBSAH}
<br />
<br />
{::MAIN}

{MISC OTEVRENY}
<br />
<br />
<strong>Přihlášení jezdci</strong><br /><br />
{JEZDCI}
<br />
<br />
Tratě, které se pojedou jsou <a href="pohar_trate.php">zde</a>
{::MISC}

{TABLE JEZDCI}
<table style="margin-left: 40px; width: 320px" cellspacing="0" cellpadding="1" class="prehledy">
	<tr class="horni">
		<td>&nbsp;Hráč</td>
		<td>Stáj</td>
	</tr>
	{ROW}
	<tr>
		<td>&nbsp;<a href="showProfile.php?id={LOGIN}">{NICK}&nbsp;&nbsp;&nbsp;</a></td>
		<td>&nbsp;<a href="showStaj.php?id={STAJ}">{NAZEV}&nbsp;&nbsp;&nbsp;</a></td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{MISC NIKDO}
<br /><br />Zatím nebyli do poháru přihlášeni žádní jezdci
<br />
<br />
Tratě, které se pojedou jsou <a href="pohar_trate.php">zde</a>
{::MISC}

{MISC BEZI}
<br />
<br />
{JEZDCI}
<br /><hr />
<h3>Tratě</h3>
Tratě, které se pojedou v poháru {NAZEV} (už v pořadí, ve kterém budou následovat v poháru)<br />
<br /><br />
{TRATE}
<hr />
<br />
Podrobnější přehled tratí je <a href="pohar_trate.php">zde</a>
<br />
<br />
{::MISC}

{TABLE JEZDCI2}
<br />
<br />
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="background-color: black"> # </td>
		<td style="background-color: black">Hráč</td>
		<td style="background-color: black">Stáj</td>
		<td style="background-color: black">Odjeté závody</td>
		<td style="background-color: black">Body</td>
	</tr>
	{ROW}
	<tr>
		<td style="background-color: black">{MISTO}.</td>
		<td style="text-align: left"><a href="showProfile.php?id={LOGIN}">{NICK}</a></td>
		<td style="text-align: left"><a href="showStaj.php?id={STAJ}">{NAZEV}</a></td>
		<td>{ZAVODY}</td>
		<td><span class="extra">{BODY}</span></td>
	</tr>
	{::ROW}
</table>
<br /><br />
Tratě, které se pojedou v QSB Poháru (už v pořadí, ve kterém budou následovat v poháru)<br />
<br /><br />
{TRATE}
{::TABLE}

{TABLE TRATE}
<table cellspacing="0" cellpadding="0">
{ROW}
	<tr>
		<td style="text-align: right"><span style="color: {BARVA1}">{PORADI}.</span> &nbsp;&nbsp;</td>
		<td> <strong><span style="color: {BARVA2}">{NAZEV}</span></strong>  </td>
		<td> &nbsp;&nbsp; <span style="color: {DIFF1}">{DIFF}%</span> </td>
		<td> &nbsp;&nbsp;<a href="showTrat.php?id={ID}"><span style="color: {BARVA1}"> (detaily)</span></a></td>
	</tr>
{::ROW}
</table>
{::TABLE}

{EXT COMMON}
<h3>{NAZEV}</h3>
<br />
{::EXT}

{EXT TRATE}
Tratě, které se pojedou v QSB Poháru (už v pořadí, ve kterém budou následovat v poháru)<br />
<br /><br />
{TRATE}
{::EXT}

{TABLE TRATE}
<table cellspacing="0" cellpadding="0" style="margin: auto">
{ROW}
	<tr>
		<td style="text-align: right"><span style="color: {BARVA1}">{PORADI}.</span> &nbsp;&nbsp;</td>
		<td> <strong>{NAZEV}</strong>  </td>
		<td>&nbsp;&nbsp; <span style="color: {DIFF1}">{DIFF2}%</span></td>
		<td>&nbsp;&nbsp; &nbsp;&nbsp;<span style="color: {DELKA1}">{DELKA2}</span>&nbsp;&nbsp; </td>
		<td>&nbsp;&nbsp;<a href="showTrat.php?id={ID}"><span class="ultra"> (detaily)</span></a></td>
	</tr>
{::ROW}
</table>
{::TABLE}

{EXT ZADNY_HRAC}Nebyl vybrán žádný hráč{::EXT}
{EXT EXIST}Hledaný hráč neexistuje{::EXT}
{EXT VLASTNIK}Nejsi vlastníkem této stáje{::EXT}
{EXT JINA_STAJ}Tento hráč není ve tvé stáji{::EXT}
{EXT ZAVODNIK}Tento hráč není stájový závodník{::EXT}
{EXT MAX}Nemůžeš do poháru přihlásit více jak {MAX} jezdce{::EXT}
{EXT UZ_JE}Tento hráč již v poháru je{::EXT}
{EXT NENI}Tento hráč není v poháru{::EXT}
{EXT UZ_BEZI}Pohár už běží{::EXT}