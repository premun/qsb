{MAIN}
<h3>Události závodu {NAZEV}</h3>
<a href="showRace.php?id={ID}#prubeh">&laquo; zpět</a>
<br />
{MOJE}
{OVERALL}
<a class="submit" onclick="$('table.udalost_info').show()">Zobrazit všechny detaily</a><br />
<a class="submit" onclick="$('table.udalost_info').hide()">Skrýt všechny detaily</a>
<br />
<br />
{UDALOSTI}
{::MAIN}

{MISC MOJE}
<input type="checkbox" name="moje"{CHECKED} onchange="location='showRaceFight.php?id={ID}&moje='+this.checked" /> <label for="moje">Jen mé akce</label>
<br />
<br />
{::MISC}

{TABLE OVERALL}
<table cellpadding="4" cellspacing="0" class="zavody" style="width: 400px">
	<tr class="horni">
		<td>Celkový přehled</td>
		<td style="text-align: center">Nárazy</td>
		<td style="text-align: center">Dmg</td>
		<td style="text-align: center">Škody</td>
		<td style="text-align: center">Souboje</td>
	</tr>
	{ROW}
	<tr>
		<td style="width: 120px; font-weight: bold"><a href="showProfile.php?id={UID}">{LOGIN}</a></td>
		<td style="text-align: right; padding-right: 26px">{NARAZY}</td>	
		<td style="text-align: right; padding-right: 20px">{DMG}</td>	
		<td style="text-align: right; padding-right: 20px">{SKODY}</td>		
		<td style="text-align: center">{VYVOLANE}/{NEVYVOLANE}</td>		
	</tr>
	{::ROW}
	<tr class="lista">
		<td colspan="5" style="border-top: 1px solid #444"></td>
	</tr>
</table>
<br />
<hr />
<br />
{::TABLE}

{TABLE UDALOSTI}
{ROW}
<table cellspacing="0" cellpadding="0" class="udalost_zahlavi">
	<tr onclick="$('#udalost_{ID}').toggle()">
		<td class="udalost_imgs" style="width: {IMGS_WIDTH}px">{IMGS}</td>
		<td class="udalost_nazev">{NAZEV}</td>
		<td class="udalost_cas">{CAS}</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" class="udalost_info" id="udalost_{ID}">
	{INFO}
</table>
<br />
{::ROW}
{::TABLE}

{TABLE INFO}
{ROW}
	<tr>
		<td class="udalost_info_nazev">{NAZEV}:</td>	
		<td>{VALUE}</td>
	</tr>
{::ROW}
	<tr>
		<td class="udalost_info_nazev">Popis:</td>	
		<td>{POPIS}</td>
	</tr>
{::TABLE}