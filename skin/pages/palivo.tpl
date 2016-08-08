{MAIN}
<h3>Palivo - {NAZEV}</h3>
<br />
<br />

<table cellspacing="0" cellpadding="0" class="zavod">
	<tr class="horni">
		<td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
	</tr>
	
	<tr>
		<td class="val">Cena za {JEDNOTKA}: </td>
		<td>{CENA}</td>
	</tr>
	
	<tr>
		<td class="val">Průměrná cena: </td>
		<td>{STALA}</td>
	</tr>
	
	<tr>
		<td class="val">Máš paliva: </td>
		<td>{MAS} {JEDNOTKA}</td>
	</tr>
	
	<tr>
		<td class="val">Typ paliva: </td>
		<td>{TYP}</td>
	</tr>
	
	<tr>
		<td class="val">Popis: </td>
		<td style="padding: 5px; padding-left: 0px">{POPIS}</td>
	</tr>
	
	<tr>
		<td colspan="2" class="lista"></td>
	</tr>
</table>
<br />
{SPOTREBA}
<hr /><h3>Nákup</h3>
<script language="JavaScript">
function orly() {
	var penize = {PENIZE};
	var cena = {CENA2};
	var kolik = document.form2.kolik.value;
	if(kolik*cena > penize) { 
		alert("Nemáš dost peněz na tolik paliva");
		return 0;
	}
	if(confirm("Opravdu nakoupit palivo? Bude tě to stát "+Math.ceil(kolik*cena)+" Is. Zbyde ti "+Math.ceil(penize-kolik*cena)+" Is.")) {
		document.form2.ok2.click();
	}
}
</script>
<form action="buyP.php?id={ID}" method="post" name="form2">
Množství {JEDNOTKA} : <input type="text" name="kolik" />
<input type="submit" value=" Koupit " style="display: none" name="ok2" />
<input type="button" value=" Koupit " onclick="orly()" /><br />
Zatím máš {MAS} {JEDNOTKA} paliva<br />
<br />
Můžes koupit max {MAX} {JEDNOTKA} <br />
<span class="error">Při úschově paliva nad {VELIKOST} {JEDNOTKA} platíš každý přepočet poplatky za údržbu!</span>
</form>
{STAJ}
{PRODEJ}
{PRODEJ_STAJ}
<hr />
<br />
{::MAIN}

{TABLE SPOTREBA}
<hr />
<h3>Spotřeba</h3>
<form action="buyPalivo.php?id={ID}" method="post" name="form1">
	Vypočtení spotřeby paliva na určitou trať: 
	<select name="trat" onchange="javascript: document.form1.tlacitko.click()">
		{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
	</select>
	<input type="submit" value=" OK " style="display: none" name="tlacitko" />
	<br />
</form>
Spotřeba paliva na tuto trať je {SPOTREBA2} {JEDNOTKA} a bude stát {CENA_NA_TRAT} Is
<br /><br />
<form action="buyP.php?id={ID}" method="post">
	<input type="hidden" name="kolik" value="{SPOTREBA2}" />
	<input type="submit" value="Koupit palivo na tento závod" /> - koupit množství paliva potřebného na tento závod ({SPOTREBA2} {JEDNOTKA})
</form>
<form action="buyP.php?id={ID}" method="post"{ZBYTEK2}>
	<input type="hidden" name="kolik" value="{ZBYTEK}" />
	<input type="submit" value="Dokoupit palivo na tento závod" /> - dokoupit množství paliva k palivu, které už máš ({MAS} {JEDNOTKA}), takže při závodu spotřebuješ veškeré palivo
</form>
{::TABLE}

{MISC STAJ}
<br />
<hr />
<h3>Nákup do stájového skladu</h3>
<form action="buyPS.php?id={ID}" method="post">
	Stájová kasa: <strong>{KASA} Is</strong><br />  
	Množství {JEDNOTKA} : <input type="text" name="kolik" />
	<input type="submit" value=" Koupit " /><br />
	Zatím na skladu <strong>{STAJ_MA} {JEDNOTKA}</strong> tohoto paliva<br />
	Celkem na skladu <strong>{STAJ_OBSAZENO}/{STAJ_SKLAD}</strong> paliva<br /> 
	Můžeš koupit max. <span class="extra"><strong>{STAJ_KOUPIT} {JEDNOTKA}</strong></span>
</form>
{::MISC}

{MISC PRODEJ}
<br />
<hr />
<h3>Prodej</h3>
Na skladu máš {MAS} {JEDNOTKA}. Kolik prodat? (formát desetinných čísel: 100.42)<br /><br />
<form action="sellPalivo.php" method="get" name="form_prodej">
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="action" value="sure" />
	<input type="text" name="kolik" /><br />
	<input type="button" value=" Prodat " onclick="jHadr('sellPalivo.php', 'form_prodej')" />
</form>
(5% peněz za palivo bude strženo za převoz paliva prodejci)
<br /><br />
{::MISC}

{MISC PRODEJ_STAJ}
<br />
<hr />
<h3>Prodej ze stáje</h3>
Ve stáji skladu je {STAJ_MA} {JEDNOTKA}. Kolik prodat? (formát desetinných čísel: 100.42)<br /><br />
<form action="sellPalivoStaj.php" method="post" name="form_prodejs">
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="action" value="sure" />
	<input type="text" name="kolik" /><br />
	<input type="button" value=" Prodat " onclick="jHadr('sellPalivoStaj.php', 'form_prodejs')" />
</form>
(5% peněz za palivo bude strženo za převoz paliva prodejci)
<br /><br />
{::MISC}

{EXT SELLPALIVO}
Na skladu máš {MNOZSTVI} {JEDNOTKA}. Kolik prodat?<br /><br />
<form action="sellPalivo.php" method="get" name="form_palivo">
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="action" value="sure" />
	Množství: <input type="text" name="kolik" value="{MNOZSTVI}" /> {JEDNOTKA}
</form>
<br /><br />
(5% peněz za palivo bude strženo za převoz paliva prodejci)
{::EXT}

{EXT SELLPALIVOSTAJ}
Na stájovém skladu je {MNOZSTVI} {JEDNOTKA}. Kolik prodat?<br /><br />
<form action="sellPalivoStaj.php" method="post" name="form_palivos">
	<input type="hidden" name="id" value="{ID}" />
	<input type="hidden" name="action" value="sure" />
	Množství: <input type="text" name="kolik" value="{MNOZSTVI}" /> {JEDNOTKA}
</form>
<br /><br />
(5% peněz za palivo bude strženo za převoz paliva prodejci)
{::EXT}