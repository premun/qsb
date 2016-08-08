{MAIN}
<h3>Stáje</h3>
{OBSAH}
{::MAIN}

{EXT COMMON_NABIDKA}
<h3>Nabídka do stáje</h3>
{::EXT}

{EXT COMMON_PRIJMOUT}
<h3>Přijmout hráče</h3>
{::EXT}

{EXT NABIDKA_EXIST}
Hledaná nabídka neexistuje. ID musí být číslo<br /><br />
{::EXT}

{EXT SMLOUVA_EXIST}
Tato smlouva nebyla nalezena
{::EXT}

{EXT STAJ_EXIST}
Hledaná stáj neexistuje
{::EXT}

{EXT VLASTNIK}
Nejsi vlastníkem této stáje<br /><br />
{::EXT}

{EXT ZALOZIT}
Opravdu si přeješ takto založit stáj {VLAJKA} {NAZEV} ({ZKRATKA})?<br />
{::EXT}

{MISC PODSEKCE}<br /><br />Vyberte prosím podsekci{::MISC}

{MISC ZADNA_STAJ}
<br />
Zatím nejsi v žádné stáji. <br />
{NABIDKY}
<br />
<hr />
<h3>Založit stáj</h3>
Založení stáje stojí {CENA_STAJE} Is a z toho {KASA} Is dostaneš do stájové kasy.
<br /><br />
<form action="zalozStaj.php?action=sure" method="post" name="form_staj">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td>Název stáje:</td><td><input type="text" maxlength="50" name="nazev" /></td>
		</tr>
		<tr>
			<td>Zkratka názvu stáje: &nbsp;&nbsp;&nbsp;</td><td><input type="text" maxlength="5" name="zkratka" /></td>
		</tr>
		<tr>
			<td>Popis: </td><td><textarea name="popis" cols="36" rows="3"></textarea></td>
		</tr>
	</table>
	<br />
	
	Vlajka: &nbsp;&nbsp; (např. <span style="font-size: 11px;"><span style="background-color: #457CBB" id="mini1">&nbsp;&nbsp;</span><span style="background-color: #FFFFFF" id="mini2">&nbsp;&nbsp;</span><span style="background-color: #6DB2FF" id="mini3">&nbsp;&nbsp;</span></span>)
	<br />
	<br />

	<input type="text" name="barva1" id="barva1" class="vlajka_barvy" value="457CBB" onclick="barva(1)" /><input type="text" name="barva2" id="barva2" class="vlajka_barvy" value="FFFFFF" onclick="barva(2)" /><input type="text" name="barva3" id="barva3" class="vlajka_barvy" value="457CBB" onclick="barva(3)" />	

	<link rel="stylesheet" href="./skin/colorpicker/css/colorpicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="./skin/colorpicker/css/layout.css" />
	<script type="text/javascript" src="./skin/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/eye.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/utils.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/layout.js?ver=1.0.2"></script>
	
	<script type="text/javascript">
	<!--
		
		$('#barva1, #barva2, #barva3').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				$('#barva'+lastClicked).css('background-color', '#'+hex);
				$('#barva'+lastClicked).css('color', '#'+hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
			onChange: function (hsb, hex, rgb) {
				$('#barva'+lastClicked).css('background-color', '#'+hex);
				$('#barva'+lastClicked).css('color', '#'+hex);
				$('#barva'+lastClicked).val(hex);
				$('#mini'+lastClicked).css('background-color', '#'+hex);
			}
		})
		
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		function updateBarvy() {
			$('#barva1').css('background-color', '#'+$('#barva1').val());
			$('#barva2').css('background-color', '#'+$('#barva2').val());
			$('#barva3').css('background-color', '#'+$('#barva3').val());
			
			$('#barva1').css('color', '#'+$('#barva1').val());
			$('#barva2').css('color', '#'+$('#barva2').val());
			$('#barva3').css('color', '#'+$('#barva3').val());
		}
		
		var lastClicked;
		
		function barva(id) {
			lastClicked = id;
		}
		
		$(document).ready(function() {
			updateBarvy();
		});
	//-->
	</script>

	<br /><br />
	<input type="button" value=" Založit stáj " onclick="jHadr('zalozStaj.php', 'form_staj')" />
</form>

{::MISC}

{MISC ZADNE_NABIDKY}
Zatím nemáš žádné nabídky ke vstupu do stáje
{::MISC}

{TABLE NABIDKY}
<br />
<hr />
<h3>Nabídky do stájí</h3>
<ul>
{ROW}
<li><span style="color: white">Do stáje <strong class="extra">{NAZEV}</strong> od hráče {LOGIN}&nbsp;&nbsp; - <a class="submit" onclick="jHadr('staj_process.php?action=nabidka', {id: '{ID}'})">Ukázat</a></span></li>
{::ROW}
</ul>
{::TABLE}

{MISC MENU}
<ul style="float: left; position: relative; left: 30px">
	<li><a href="staje.php?action=detaily">Zobrazit detaily</a></li>
	<li><a href="staje.php?action=clenove">Členové stáje</a></li>
	<li><a href="staje.php?action=give">Předání předmětu</a></li>
	<li><a href="staje.php?action=forum">Stájové fórum</a></li>
</ul>
<ul style="float: right; position: relative; left: -90px">
	<li><a href="staje.php?action=budovy">Budovy</a></li>
	<li><a href="staje.php?action=finance"{FINANCE}>Finance stáje</a></li>
	<li><a href="staje.php?action=sklady"{SKLADY}>Sklady paliv</a></li>
	<li><a href="staje.php?action=pohar"{POHAR}>{POHAR_NAZEV} - přihlásit jezdce</a></li>
</ul>
<hr style="clear: both" />
{OBSAH}
{::MISC}

{MISC DEFAULT}
Jsi {FUNKCE}em stáje <strong>{NAZEV}</strong>{AKCE}
<br />
Stájová kasa: <strong>{KASA} Is</strong>
{PREDAT}
{::MISC}

{MISC ZRUSIT} - <a class="submit" onclick="jHadr('staj_process.php?action=zrusitStaj&id={ID}',{})">Zrušit stáj</a>{::MISC}
{MISC ODSTOUPIT} - <a class="submit" onclick="jHadr('staj_process.php?action=odstoupit&staj={ID}',{})">Odstoupit ze stáje</a>{::MISC}
{MISC PREDAT}
<br />
<br />
<form action="staj_process.php?action=predatStaj" method="post" style="margin-left: 0px">
Předat stáj jinému hráči: {LIDI} <input type="submit" value=" Předat " class="submit" />
<input type="hidden" value="{ID}" name="staj" />
</form>
<br />
<br />
Nástěnka:<br />
<form action="staj_process.php" method="post" name="form_nastenka">
<textarea style="width: 380px" rows="9" name="obsah">{NASTENKA}</textarea>
<input type="button" style="width: 382px" value="Změnit" onclick="jHadr('staj_process.php?action=nastenka', 'form_nastenka')" />
</form>

{::MISC}

{MISC NASTENKA}
Nástěnka změněna
<script type="text/javascript">
<!-- 
	setNastenka(2);
-->
</script>
{::MISC}

{MISC BUDOVY}
<h3>Postavit budovu</h3>
<form action="staj_process.php?action=postavitBudovu" method="post" style="margin-left: 0px">
Místa na budovy:&nbsp;&nbsp;&nbsp;{OBSAZENO}/{POZEMEK}<br />
Volné ubikace:&nbsp;&nbsp;&nbsp;{UBIKACE}
<br />
Stájové peníze:&nbsp;&nbsp;&nbsp;{KASA} Is
<br /><br />
{BUDOVY}
<br />
Výdělek z budov: {VYDELEK} Is
<br />
<br />
<span{PARCELY}>
<input type="hidden" value="{OBSAZENO}" name="obsazeno" />
<input type="hidden" value="{POZEMEK}" name="pozemek" />
<input type="hidden" value="{ID}" name="staj" />
<input type="submit" class="submit" value=" Postavit vybranou budovu " onclick="this.style.display = 'none'" />
</span>
</form>
{ZBOURAT}
<br />
{PARCELA}
<br />
<br />
<br />
{::MISC}

{TABLE BUDOVY}
<table cellspacing="3" cellpadding="6" class="budovy">
	<tr>
		<td style="background-color: black"> </td>
		<td>Budova</td>
		<td>Cena</td>
		<td>Potřebné místo</td>
		<td>Prestiž</td>
		<td>Výdělek</td>
		<td>Doba stavění</td>
		<td>Máš</td>
	</tr>
	{ROW}
	<tr{BARVA3}>
		<td{BLACK}>{KOUPIT}</td>
		<td>{NAZEV}</td>
		<td>{CENA}</td>
		<td>{MISTO}</td>
		<td>{PRESTIZ}</td>
		<td><span style="color: {BARVA}">{PENIZE}</span></td>
		<td>{STAVENI}</td>
		<td><span style="color: {BARVA2}">{POCET}{POCET2}</span></td>
	</tr>
	{::ROW}
</table>
{::TABLE}

{TABLE BOURANI}
<br />
<form action="staj_process.php?action=zboritBudovu" method="post" style="margin-left: 0px">
Zbourat budovu: <select name="budova">
{ROW}<option value="{VALUE}">{NAZEV}</option>{::ROW}
</select> 
<input type="submit" class="submit" value=" Zbourat " /><br />
<span class="ultra">(zbourání stojí {ZBOURANI} Is)</span>
<input type="hidden" value="{ID}" name="staj" />
</form>
{::TABLE}

{MISC PARCELA1}
<script language="JavaScript">
<!--
function parcela() {
	if(window.confirm("Opravdu zakoupit volné místo na budovu? Stojí {PARCELA_CENA} Is")) location="staj_process.php?action=parcela&id={ID}";
}
//-->
</script>
Další parcela stojí {PARCELA_CENA} Is - <input type="button" class="submit" value=" Koupit parcelu " onclick="parcela()" />
{::MISC}
{MISC PARCELA2}Další parcela stojí {PARCELA_CENA} Is{::MISC}

{MISC CLENOVE}
<h3>Členové stáje</h3>
{SEZNAM}
<br />
<span class="ultra">Smlouva je možná změnit jednou za 3 dny</span><br />
Celkem stáj na mzdách vyplácí <strong class="extra">{MZDY} Is</strong>
<hr />
<h3>Nabídnuté smlouvy</h3>
{SMLOUVY}
{PRIJMOUT}
{::MISC}

{TABLE CLENOVE1}
<br />
<table style="margin-left: 40px; width: 350px" cellspacing="0" cellpadding="1" class="prehledy">
	<tr class="horni">
		<td style="padding-left: 6px">Nick</td>
		<td>Funkce</td>
		<td>Mzda</td>
	</tr>
	{ROW}
	<tr>
		<td style="padding-right: 10px; padding-left: 6px"><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
		<td>{STAV}</td>
		<td>{PENIZE}</td>
	</tr>
	{::ROW}
	<tr>
		<td colspan="3" class="lista"></td>
	</tr>
</table>
{::TABLE}

{TABLE CLENOVE2}
<br />
<table style="margin-left: 40px; width: 400px" cellspacing="0" cellpadding="1" class="prehledy">
	<tr class="horni">
		<td style="padding-left: 6px">Nick</td>
		<td>Funkce</td>
		<td>Poměr</td>
		<td>Mzda</td>
		<td> </td>
		<td> </td>
	</tr>
	{ROW}	
	<tr>
		<td style="padding-right: 10px; padding-left: 6px"><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
		<td>{STAV}</td>
		<td style="text-align: center">{POMER}%</td>
		<td>{PENIZE}</td>
		{ZMENA}
	</tr>
	{::ROW}
	<tr>
		<td colspan="6" class="lista"></td>
	</tr>
</table>
{::TABLE}

{TABLE NABIDKY2}
<br />
<table style="margin-left: 40px; width: 360px" cellspacing="0" cellpadding="1" class="prehledy">
	<tr class="horni">
		<td style="padding-left: 6px">Nick</td>
		<td>Funkce</td>
		<td>Poměr</td>
		<td>Mzda</td>
		<td> </td>
	</tr>
	{ROW}
	<tr>
		<td style="padding-right: 10px; padding-left: 6px"><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
		<td>{STAV}</td>
		<td style="text-align: center">{POMER}%</td>
		<td>{PENIZE}</td>
		<td style="text-align: right; padding-right: 6px;">{ZRUSIT}</td>
	</tr>
	{::ROW}
	<tr>
		<td colspan="5" class="lista"></td>
	</tr>
</table>
<br />
{::TABLE}

{MISC PRIJMOUT}
<hr />
<h3>Přijmout nového hráče</h3>
<br />
<form action="invite.php" method="post">
Nabídnout smlouvu hráči: <input type="text" name="login" size="20" rel="ajaxList" /> 
<input type="hidden" value="{ID}" name="staj" />
<input type="submit" class="submit" value=" OK " />
</form>
<br />
{::MISC}

{MISC ZADNE_SMLOUVY}<br />Žádné nabídnuté smlouvy hráčům<br />{::MISC}

{MISC INVITATION}
<h3>Přijmout hráče</h3>
<form action="invite.php?action=confirm" method="post">
	<table>
		<tr>
			<td>Hráč: </td>
			<td>{LOGIN}</td>
		</tr>
		<tr>
			<td>Funkce ve stáji: </td>
			<td>{STAVY}</td>
		</tr>
		<tr>
			<td>Poměr peněz: </td>
			<td><input type="text" size="2" name="pomer" value="50" /> %</td>
		</tr>
		<tr>
			<td>Denní mzda: </td>
			<td><input type="text" size="5" name="penize" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value=" Nabídnout smlouvu " class="submit" /></td>
		</tr>
	</table>
	<br />
Poměr peněz je číslo od 10 do 90 a udává, kolik procent výhry ze závodu hráč odvede do stáje.
</form>
<br /><br />
{::MISC}

{TABLE STAVY}
<select name="stav">
	{ROW}<option value="{ID}">{STAV}</option>{::ROW}
</select>
{::TABLE}

{EXT INVITE}
<strong>Obsah smlouvy:</strong><br />
Budeš přijat jako <strong class="extra">{FUNKCE}</strong> s denní mzdou <strong class="extra">{PENIZE} Is</strong>. Smlouva také obsahuje, že z každé výhry v závodě musíš odvést <strong class="extra">{POMER}%</strong> do stájové kasy. Jako poplatek pro vstup musíš složit <strong class="extra">{VSTUP} Is</strong> do stájové pokladny.
{::EXT}

{EXT INVITE_ODJETO}<strong class="error">Zatím nemáš odjeto 5 závodů</strong>{::EXT}
{EXT INVITE_PENIZE}<strong class="error">Zatím nemáš {VSTUP} Is v hotovosti a tak nemůžeš smlouvu podepsat</strong>{::EXT}

{MISC DETAILY}
<h3>Detaily stáje</h3>
<table cellspacing="0" cellpadding="0" class="zavod">
  <tr class="horni">
  <td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
  </tr>

  <tr>
  <td class="val">Vlajka: </td>
  <td>{VLAJKA}</td>
  </tr>
  
  <tr>
  <td class="val">Zkratka: </td>
  <td>{ZKRATKA}</td>
  </tr>

  <tr>
  <td class="val">Vlastník: </td>
  <td>{VLASTNIK}</td>
  </tr>
  
  <tr>
  <td class="val">Prestiž: </td>
  <td>{PRESTIZ}</td>
  </tr>

  <tr>
  <td class="val" style="vertical-align: top">Hráči: </td>
  <td>{HRACI}</td>
  </tr>  

  <tr>
  <td class="val" style="vertical-align: top">Popis: </td>
  <td>{POPIS}</td>
  </tr>
  
  <tr>
  <td class="val">Budovy: </td>
  <td>{OBSAZENO}/{POZEMEK}<br /></td>
  </tr>

  <tr>
  <td class="val">Stájová kasa: </td>
  <td>{KASA}</td>
  </tr>
  
  <tr>
  <td class="val">Budovy: </td>
  <td>{BUDOVY}</td>
  </tr>
  
  <tr>
  <td colspan="2" class="lista"></td>
  </tr>
</table>
<br /><br />
{ZMENA}
{::MISC}

{TABLE HRACI}
	{ROW}<a href="showProfile.php?id={LOGIN}">{NICK}</a> ({STAV})<br />{::ROW}
{::TABLE}

{MISC ZMENA_DETAILU}
<hr />
<h3>Upravit detaily</h3>
<strong>Popis: </strong><br />
<form action="staj_process.php?action=editPopis&staj={ID}" method="post">
<textarea rows="7" cols="45" name="popis" style="vertical-align: top">{POPIS2}</textarea>
<br /><input type="submit" value=" Změnit popis " class="submit" />
</form>
<br />
<span style="font-size: 11px;"><span style="background-color: #{BARVA1}" id="mini1">&nbsp;&nbsp;</span><span style="background-color: #{BARVA2}" id="mini2">&nbsp;&nbsp;</span><span style="background-color: #{BARVA3}" id="mini3">&nbsp;&nbsp;</span></span> <strong>Vlajka:</strong> 
<span class="ultra">
(Změna vlajky stojí {PENIZE_VLAJKA} Is)</span>
	
	<br />
	<br />
<div style="text-align: center">
<form action="staj_process.php?action=editVlajka&staj={ID}" method="post">
	<input type="text" name="barva1" id="barva1" class="vlajka_barvy" value="{BARVA1}" onclick="barva(1)" /><input type="text" name="barva2" id="barva2" class="vlajka_barvy" value="{BARVA2}" onclick="barva(2)" /><input type="text" name="barva3" id="barva3" class="vlajka_barvy" value="{BARVA3}" onclick="barva(3)" />	

	<link rel="stylesheet" href="./skin/colorpicker/css/colorpicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="./skin/colorpicker/css/layout.css" />
	<script type="text/javascript" src="./skin/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/eye.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/utils.js"></script>
    <script type="text/javascript" src="./skin/colorpicker/js/layout.js?ver=1.0.2"></script>
	
	<script type="text/javascript">
	<!--
		
		$('#barva1, #barva2, #barva3').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				$('#barva'+lastClicked).css('background-color', '#'+hex);
				$('#barva'+lastClicked).css('color', '#'+hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
			onChange: function (hsb, hex, rgb) {
				$('#barva'+lastClicked).css('background-color', '#'+hex);
				$('#barva'+lastClicked).css('color', '#'+hex);
				$('#barva'+lastClicked).val(hex);
				$('#mini'+lastClicked).css('background-color', '#'+hex);
			}
		})
		
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		function updateBarvy() {
			$('#barva1').css('background-color', '#'+$('#barva1').val());
			$('#barva2').css('background-color', '#'+$('#barva2').val());
			$('#barva3').css('background-color', '#'+$('#barva3').val());
			
			$('#barva1').css('color', '#'+$('#barva1').val());
			$('#barva2').css('color', '#'+$('#barva2').val());
			$('#barva3').css('color', '#'+$('#barva3').val());
		}
		
		var lastClicked;
		
		function barva(id) {
			lastClicked = id;
		}
		
		$(document).ready(function() {
			updateBarvy();
		});
	//-->
	</script>
<br />
</div>
<input type="submit" value=" Změnit vlajku " class="submit" />
</form>
{::MISC}

{MISC CHANGE_SMLOUVA}
Měníš smlouvu hráči <strong>{NICK}</strong>. Tento hráč je zaměstnán jako <strong>{STAV}</strong> a platíš mu <strong>{PENIZE} Is</strong>
<br /><br />
<form action="staj_process.php?action=smlouva" method="post" style="margin-left: 0px" name="form_smlouva">
<input type="hidden" name="staj" value="{STAJ}" />
<input type="hidden" name="id" value="{ID}" />
<table cellpadding="2" cellspacing="4">
<tr><td>Změnit plat: </td><td><input type="text" name="penize" size="5" value="{PENIZE}" /></td></tr>
<tr><td>Změnit poměr peněz: </td><td><input type="text" name="pomer" size="5" value="{POMER}" /></td></tr>
<tr><td>Změnit stav: </td><td>
<select name="stav">
<option value="2">Závodník</option>
<option value="3"{CHECKED}>Obchodník</option>
</select></td></tr>
</table>
</form>
<br />
Maximální plat, který si můžeš dovolit je<strong class="extra"> {MAX} Is</strong>
<br />
<br />
Poměr např. 60% znamená, že při výhře závodu jde 60% výhry do stájové kasy<br />
{::MISC}

{MISC ZADNY_SKLAD}<h3>Sklady paliv</h3>Nemáš postaven žádný sklad{::MISC}

{MISC SKLADY2}
<h3>Sklady paliv</h3>
<br />
Máš postaveno:
{SKLADY2}
<br />
{SKLADY_PALIVO}
<br />
<br />
{::MISC}

{TABLE SKLADY2}
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 260px">
	<tr class="horni">
		<td>&nbsp;&nbsp;<strong>Budova</strong></td><td>&nbsp;&nbsp;<strong>Kapacita</strong></td>
	</tr>
	{ROW}
	<tr>
		<td>&nbsp;&nbsp;{NAZEV}</td>
		<td>&nbsp;&nbsp;{KAPACITA}</td>
	</tr>
	{::ROW}
	<tr><td style="border-top: 1px solid #666666">&nbsp;&nbsp;Celkem</td><td style="border-top: 1px solid #666666">&nbsp;&nbsp;{KAPACITA_CELKEM}</td></tr>
	<tr><td colspan="2" class="lista"></td></tr>
</table>
{::TABLE}

{TABLE SKLADY_PALIVO}
Paliva na skladech:
<br />
<br />
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 260px">
	<tr class="horni">
		<td>&nbsp;&nbsp;<strong>Palivo</strong></td><td colspan="2">&nbsp;&nbsp;<strong>Množství</strong></td>
	</tr>
	{ROW}
	<tr>
		<td>&nbsp;&nbsp;<a href="buyPalivo.php?id={ID}">{NAZEV}</a></td>
		<td>&nbsp;&nbsp;{MNOZSTVI} {JEDNOTKA}</td>
		<td>&nbsp;&nbsp;{PRODAT}</td>
	</tr>	
	{::ROW}
	<tr><td style="border-top: 1px solid #666666">&nbsp;&nbsp;Celkem</td><td colspan="2" style="border-top: 1px solid #666666">&nbsp;&nbsp;{OBSAZENO}</td></tr>
	<tr><td colspan="3" class="lista"></td></tr>
</table>
<br />
Obsazeno: <strong>{OBSAZENO}/{KAPACITA_CELKEM}</strong>
{::TABLE}

{MISC FINANCE2}
<h3>Finance</h3>
<br />
Stájová kasa: <strong>{KASA} Is</strong>
<br />
<br />
<form action="staj_process.php?action=sendMoney" method="post" style="margin-left: 0px">
Poslat peníze do stáje: <input type="text" name="penize" size="5" /> Is <input type="submit" value=" Poslat " class="submit" />
<input type="hidden" value="{ID}" name="staj" />
</form>
{VLASTNIK}
{::MISC}

{MISC ZAVODNIK}Nejsi ani vlastník ani obchodník stáje{::MISC}

{MISC POSLAT_VLASTNIKOVI}
<br />
<form action="staj_process.php?action=sendMoney2&action2=login" method="post" style="margin-left: 0px">
Poslat peníze hráči: {LIDI} <input type="text" name="penize" size="5" /> Is <input type="submit" value=" Poslat " class="submit" />
<input type="hidden" value="{ID}" name="staj" />
</form>
<br />
<!--Vybrat můžeš nejvíce <strong class="extra">{PULKA} Is</strong><br />
Vybírat můžeš jen jednou denně!
<br />//-->
<br />
{::MISC}

{MISC PREDANI}
<h3>Předání předmětu</h3>
<br />
<form action="staj_process.php?action=predat_predmet" method="post">
Dát 
{PREDMETY}&nbsp;&nbsp;
{KOMU}ovi
<br />
<br />
<input type="hidden" name="staj" value="{ID}" />
<input value=" Předat předmět " type="submit" class="submit" />&nbsp;&nbsp;
<em>(poslání předmětu stojí </em> &nbsp;{POSLANI} Is<em>)</em>
<br />
<br />
Pokud předáš předmět, který byl součástí některé šablony kluzáku, šablona bude smazána. Číslo v závorce za názvem předmětu obsahuje počet šablon, které ho obsahují.
</form>
{::MISC}

{MISC NEMAS_PREDMET}
<h3>Předání předmětu</h3>
Nemáš žádný předmět, který bys někomu mohl dát<br />
<em>(předmět nesmí být součástí kluzáku)</em>
{::MISC}

{MISC NEMAS_NIKOHO}
<h3>Předání předmětu</h3>
Nemáš žádného spolustájovníka, komu bys předmět dal<br />
{::MISC}

{TABLE PREDMETY}
<select name="predmet">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE KOMU}
<select name="login">
	{ROW}<option value="{ID}">{NICK}</option>{::ROW}
</select>
{::TABLE}

{MISC POHAR}
<h3>{POHAR_NAZEV}</h3>
&nbsp;&nbsp;&nbsp;- přihlašování jezdců<br />
<br />
{HRACI}
{PRIHLASENI}
{::MISC}

{TABLE POHAR_HRACI}
<form action="pohar.php?action=sign" method="post">
Přihlásit: &nbsp;<select name="login">
{ROW}<option value="{LOGIN}">{NICK}</option>{::ROW}
</select>&nbsp;&nbsp;
<input type="hidden" value="{ID}" name="staj" />
<input type="submit" value="Přihlásit" class="submit" />
</form>
{::TABLE}

{MISC POHAR_NIKDO}Nemáš koho přihlásit (přihlásit lze jen závodníka){::MISC}

{TABLE POHAR_PRIHLASENI}
<br />
<br />
<strong>Přihlášení jezdci</strong><br /><br />
<table style="margin-left: 40px; width: 240px" cellspacing="0" cellpadding="1" class="prehledy">
	<tr class="horni">
		<td>&nbsp;&nbsp;Hráč</td>
		<td></td>
	</tr>
	{ROW}
	<tr>
		<td><a href="showProfile.php?id={LOGIN}">&nbsp;&nbsp;{NICK}&nbsp;&nbsp;&nbsp;</a></td>
		<td><a href="pohar.php?action=kick&login={LOGIN}&staj={ID}">Odhlásit</a></td>
	</tr>
	{::ROW}
	<tr><td colspan="3" class="lista"></td></tr>	
</table>
{::TABLE}

{MISC NEMAS_STAJ}Nejsi členem źádné stáje{::MISC}

{MISC FORUM}
<h3 class="submit" onclick="showForumForm(2)">Poslat příspěvek</h3>
<form action="send_forum.php?place=s{ID}" method="post" name="send">
<input type="hidden" name="action" value="staj" />
<textarea name="msg" cols="42" rows="5"></textarea><br />	
{SMILES}
<br />
<input type="button" class="submit" value="[B][/B]" onclick="vlozTagy('[B]','[/B]');" title="tučné" /> 
<input type="button" class="submit" value="[I][/I]" onclick="vlozTagy('[I]','[/I]');" title="kurzíva" /> 
<input type="button" class="submit" value="[U][/U]" onclick="vlozTagy('[U]','[/U]');" title="podtržené" />
<input type="button" class="submit" value="[O][/O]" onclick="vlozTagy('[O]','[/O]');" title="oranžové" style="color: #FF9900" /> 
<input type="button" class="submit" value="[S][/S]" onclick="vlozTagy('[S]','[/S]');" title="šedé" /> 
<br />
<input type="submit" class="submit" value="Poslat" />
</form>
<hr />
<br />

{SIPKY}
<br />
<br />

{ZPRAVY}

{SIPKY}
{::MISC}

{TABLE ZPRAVA}
    {ROW}<table class="posta" cellspacing="0" cellpadding="0">
    <tr>
    <td class="nick"{ADD}>{ADMIN}{DELETE}<a href="showProfile.php?id={LOGIN}"{ADD}>{NICK}</a><a href="#" onclick="vlozTagy('[O]&gt;[/O] {NICK}: ','');" style="color: #666"> | Re</a></td>
    <td class="datum"{ADD}>{DATUM}</td>
    </tr>
    <tr>
    <td class="msg" colspan="2">{MSG}</td>
    </tr>
    <tr><td class="lista" colspan="2"></td></tr>
    </table>
    <br /><br />{::ROW}
{::TABLE}

{TABLE SMILES}
{ROW}<img src="./skin/img/smiles/{X}.gif" class="submit" alt="[SM{X}]" onclick="vlozTagy('[SM{X}]','');"  />{::ROW}
{::TABLE}

{MISC ADMIN}<img src="./skin/img/forum_admin.jpg" alt="Admin" style="margin-right: 2px; margin-left: 3px" />&nbsp;{::MISC}
{MISC KONZUL}<img src="./skin/img/forum_admin2.jpg" alt="Galaktický konzul" style="margin-right: 2px; margin-left: 3px" />&nbsp;{::MISC}