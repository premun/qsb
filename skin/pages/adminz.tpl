{MAIN}
<!--<h3>T3h adminz section</h3>//-->
<script type="text/javascript">
<!--
function show(co) {
	$('#'+co).toggle("normal");
}
//-->
</script>

<h4 style="cursor: pointer" onclick="show('novinky')">Texties</h4>
<span id="novinky">
	<ul>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=novinka', {title: this.innerHTML})">Přidat novinku</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=posta', 	{title: this.innerHTML})">Rozeslat všem poštu</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=anketa', 	{title: this.innerHTML})">Vyhlásit novou anketu</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=nastenka',{title: this.innerHTML})">Adminská nástěnka</a></li>
	</ul>
</span>
<hr />

<h4 style="cursor: pointer" onclick="show('utility')">Utilities</h4>
<span id="utility">
	<ul>
		<li><a href="multaci.php">Mulťáci</a><br />
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=forum', {title: this.innerHTML})">Zpřístupnit mazání fóra</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=sablona', {title: this.innerHTML})">Vytvořit AI šablonu</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=add_bot', {title: this.innerHTML})">Přidat bota do závodu</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=add_bot2', {title: this.innerHTML})">Přidat autobota do závodu</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=spion', {title: this.innerHTML})">Spustit špióna</a></li>
	</ul>
</span>
<hr />

<h4 style="cursor: pointer" onclick="show('stav')">Stav hry</h4>
<span id="stav">
	<ul>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=blokace',  {title: this.innerHTML})">Blokace</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=pohar',    {title: this.innerHTML})">Pohár</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=prepocet', {title: this.innerHTML})">Spustit přepočet</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=restart_zavodu', {title: this.innerHTML})">Restartovat závod</a></li>
	</ul>
</span>
<hr />

<h4 style="cursor: pointer" onclick="show('hraci')">Hráči</h4>
<span id="hraci">
	<ul>
		<li><a class="submit" onclick="show('form_blok')">Zablokovat hráče</a>
			<form action="adminz.php?action=blok" method="post" id="form_blok" style="display: none; margin-left: 0px">
				<input type="text" name="blok_login" style="width: 150px" rel="ajaxList" />&nbsp;&nbsp;<input type="submit" value="Zablokovat" />
			</form>
		</li>
		<li><a class="submit" onclick="show('form_odblok')">Odblokovat hráče</a>
			<form action="adminz.php?action=odblok" method="post" id="form_odblok" style="display: none; margin-left: 0px">
				{ODBLOK}&nbsp;&nbsp;<input type="submit" value="Odblokovat" />
			</form>		
		</li>
		<li><a class="submit" onclick="show('form_penize')">Změnit peníze</a>
			<form action="adminz.php?action=penize" method="post" id="form_penize" style="display: none; margin-left: 0px">
				<input type="text" name="penize_login" style="width: 100px" rel="ajaxList" /> &lt; login<br />
				<input type="text" name="penize" style="width: 100px" />&nbsp;&nbsp;<input type="submit" value="Změnit" />
			</form>		
		</li>
		<!--<li><a href="adminz.php?action=konzulove">Udělit konzuly</a></li>-->
		<li><a class="submit" onclick="show('form_restart')">Restartovat hráče</a>
			<form action="adminz.php?action=restartHrace" method="post" id="form_restart" style="display: none; margin-left: 0px">
				<input type="text" name="restart_login" style="width: 100px" rel="ajaxList" /> &lt; login<br />
				{RASA}&nbsp;&nbsp;<input type="submit" value="Restartovat" />
			</form>		
		</li>
	</ul>
</span>
<hr />

<h4 style="cursor: pointer" onclick="show('s101')">00101010</h4>
<span id="s101">
	<ul>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=sqll',    {title: this.innerHTML})">SQL</a></li>
		<li><a class="submit" onclick="jHadr('adminz_forms.php?action=scriptyl',{title: this.innerHTML})">Editace scriptů</a></li>
        <li><a class="submit" onclick="jHadr('adminz_forms.php?action=scripty', {filename: 'vypisy/error_log.txt'})">Error log</a></li>
        <li><a class="submit" onclick="jHadr('adminz_forms.php?action=zalohyl', {title: this.innerHTML})">Zálohy databáze</a></li>
		<li><a href="mysqldump.php?action=adminz">Vytvořit zálohu</a></li>
	</ul>
</span>

{::MAIN}

{EXT NEJSI}
<h3>T3h adminz section</h3>
<br />
You're not a admin. Get lost!
<br />
<br />
{::EXT}

{MISC NOVINKA}
	<form action="adminz.php?action=novinka" method="post" name="form_novinka">
		Titulek:<br />
		<input type="text" name="titulek" style="width: 454px" /><br />
		Novinka:<br />
		<textarea style="width: 454px" rows="5" name="novinka"></textarea><br />
	</form>
{::MISC}

{MISC POSTA}
	<form action="adminz.php?action=posta" method="post" name="form_posta">
		Zpráva:<br />
		<textarea style="width: 454px" rows="8" name="zprava"></textarea><br />
	</form>
{::MISC}

{MISC ANKETA}
	<form action="adminz.php?action=anketa" method="post" name="form_anketa">
		Otázka:<br />
		<input type="text" name="otazka" style="width: 454px" /><br />
		Odpovědi:<br />
		<textarea style="width: 454px" rows="4" name="odpovedi"></textarea><br />
	</form>
{::MISC}

{MISC SPION}
	<form action="adminz.php?action=spion" method="post" name="form_spion">
		ID:&nbsp;&nbsp;&nbsp;<input type="text" name="ids" /><br />
		Login:&nbsp;&nbsp;&nbsp;<input type="text" name="login" rel="ajaxList" autocomplete="off" /><br />
	</form>
{::MISC}

{MISC RESTART_ZAVODU}
	<form action="adminz.php?action=restart_zavodu" method="post" name="form_restart_zavodu">
		ID:&nbsp;&nbsp;&nbsp;<input type="text" name="zavod" /><br />
	</form>
{::MISC}

{MISC SQLL}
	<form action="adminz_forms.php?action=sql" method="post" name="form_sqll">
		Heslo:&nbsp;&nbsp;&nbsp;<input type="password" name="heslo" /><br />
		<input type="hidden" name="title" value="SQL console" />
	</form>
{::MISC}

{MISC SQL}
	<form action="adminz_forms.php?action=sql" method="post" name="form_sql">
		SQL dotaz:<br />
		<textarea style="width: 454px" rows="6" name="dotaz"></textarea><br />
	</form>
{::MISC}

{MISC SCRIPTYL}
	<form action="adminz_forms.php?action=scripty" method="post" name="form_scriptyl">
		Heslo:&nbsp;&nbsp;&nbsp;<input type="password" name="heslo" /><br />
		<input type="hidden" name="title" value="OK" />
	</form>
{::MISC}

{MISC SCRIPTY}
	<form action="adminz_forms.php?action=scripty" method="post" name="form_scripty">
		Soubor:&nbsp;&nbsp;&nbsp;<input type="text" name="filename" style="width: 450px" /><br />
		<input type="hidden" name="title" value="Editace scriptu" />
	</form>
{::MISC}

{EXT EDITACE_SCRIPTU}
	<form action="adminz_forms.php?action=edit_script" method="post" name="form_script">
		<textarea style="width: 650px; height: 700px; font-family: monospace" name="obsah">{OBSAH}</textarea>
		<input type="hidden" name="filename" value="{FILENAME}" />
	</form>
{::EXT}

{MISC ZALOHYL}
	<form action="adminz_forms.php?action=zalohy" method="post" name="form_zalohyl">
		Heslo:&nbsp;&nbsp;&nbsp;<input type="password" name="heslo" /><br />
		<input type="hidden" name="title" value="OK" />
	</form>
{::MISC}

{TABLE ZALOHY}
	<table cellspacing="3" style="margin: auto">
		{ROW}
			<tr name="{NAZEV2}">
				<td><a href="./vypisy/db/{NAZEV}">{DATUM}</a></td>
				<td>{VELIKOST} MB</td>
				<td style="width: 170px; border-bottom: 1px solid #444"></td>
				<td><a href="adminz_process.php?action=zaloha&file={NAZEV}"><img src="./skin/img/save.png" height="14" alt="Uložit zálohu" style="border: none" /></a></td>
				<td><a class="submit" onclick="vymazZalohu('{NAZEV2}')"><img src="./skin/img/delete.jpg" alt="Vymazat zálohu" style="border: none" /></a></td>
			</tr>
		{::ROW}
	</table>
{::TABLE}

{TABLE ODBLOK}
<select name="odblok_login">
	{ROW}<option value="{ID}">{LOGIN}</option>{::ROW}
</select>
{::TABLE}

{TABLE RASA}
<select name="rasa">
	<option value="same">stejná</option>
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{MISC NASTENKA}
	<form action="adminz.php?action=nastenka" method="post" name="form_nastenka">
		Titulek:<br />
		<input type="text" name="titulek" style="width: 454px" /><br />
		Obsah:<br />
		<textarea style="width: 454px" rows="4" name="obsah"></textarea><br />
	</form>
{::MISC}

{EXT SABLONA}
	<form action="adminz_process.php?action=sablona" method="post" name="form_sablona">
	<table cellspacing="4">
		<tr>
			<td>Šablona:<td></td>{SABLONY}</td>
		</tr>
	</table>
	</form>
{::EXT}

{TABLE SABLONY}
<select name="sablona">
	{ROW}<option value="{ID}">{LOGIN} - {NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE SABLONY2}
<select name="sablona[]" multiple size="20">
	{ROW}<option value="{ID}">{LOGIN} - {NAZEV}</option>{::ROW}
</select>
{::TABLE}

{EXT ADD_BOT}
<script type="text/javascript">
<!--
	$(function() {
		$("#agresivita").slider({
			animate: true,
			min: -100,
			max: 100,
			step: 1,
			value: 0,
			width: 200,
			change: function(event, ui) {
				slajd(ui.value);
			},
			slide: function(event, ui) {
				slajd(ui.value);
			}
		});
	});
	
	$(function() {
		$("#opatrnost").slider({
			animate: true,
			min: 15,
			max: 85,
			step: 1,
			value: 50,
			width: 200,
			change: function(event, ui) {
				$("#opatrnost_value").html(ui.value+'%');
				$("input[name=opatrnost]:first").val(ui.value);
			},
			slide: function(event, ui) {
				$("#opatrnost_value").html(ui.value+'%');
				$("input[name=opatrnost]:first").val(ui.value);
			}
		});
	});
	
	$(function() {
		$("#control_tab").tabs({ fx: { opacity: 'toggle' } });
	});
	
	var last = 0;
	
	function slajd(p) {
		if(p < 0 && last >= 0) {
			$("#of").hide();
			$("#def").show();
			$("#ne").hide();
			$("#obet").show();
			$("#taktika").show();
			$("select[name=taktika1]").show();
			$("select[name=taktika2]").hide();
			$("#postoj_nazev").html('Defenzivní');
			$("#preferovany_cil").html('Očekávaný útočník:');
		}
		
		if(p > 0 && last <= 0) {
			$("#def").hide();
			$("#of").show();
			$("#ne").hide();
			$("#obet").show();
			$("#taktika").show();
			$("select[name=taktika1]").hide();
			$("select[name=taktika2]").show();
			$("#postoj_nazev").html('Ofenzivní');
			$("#preferovany_cil").html('Preferovaný cíl:');
		}
		
		if(p == 0 && last != 0) {
			$("#obet").hide();
			$("#def").hide();
			$("#of").hide();
			$("#ne").show();
			$("#taktika").hide();
			$("#postoj_nazev").html('Neutrální');
		}
		
		last = p;
		
		$("#agresivita_value").html(p+'%');
		$("input[name=agresivita]:first").val(p);
	}
//-->
</script>
<form action="adminz_process.php?action=add_bot" method="post" style="margin-left: 20px" name="form_add_bot">
	<input type="hidden" name="action" value="add_bot" />
	
	<span class="extra">Rasa:</span><br />
	<select name="rasa" style="width: 360px">
		{RASY}
	</select>
	<br />
	<br />	
	<span class="extra">Kluzák:</span><br />
	<select name="sablona" style="width: 360px">
		{SABLONY}
	</select>
	<br />
	<br />
	<span class="extra">Závod:</span><br />
	<select name="zavod" style="width: 360px">
		{ZAVODY}
	</select>
	<br />
	<br />
	<span class="extra">Opatrnost:</span> <span id="opatrnost_value">50%</span>
	<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="text-align: left; width: 33%">Nebezpečný / rychlý</td>
			<td style="text-align: center; width: 33%">Normální</td>
			<td style="text-align: right; width: 33%">pomalý / Opatrný</td>
		</tr>
	</table>
	<div id="opatrnost" style="margin-top: 4px; width: 360px"></div>

	<br />
	<input type="hidden" name="opatrnost" value="50" />
	
	<span class="extra">Agresivita:</span> <span id="agresivita_value">0%</span>
	<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
		<tr>
			<td style="text-align: left; width: 33%">Defenzivní</td>
			<td style="text-align: center; width: 33%">Neutrální</td>
			<td style="text-align: right; width: 33%">Agresivní</td>
		</tr>
	</table>
	<div id="agresivita" style="margin-top: 4px; width: 360px"></div>

	<br />
	<input type="hidden" name="agresivita" value="0" />
	
	<span class="extra">Postoj:</span> <span id="postoj_nazev">Neutrální</span><br />
	<span id="def" style="display: none">
		{POSTOJ1}
	</span>
	
	<span id="of" style="display: none">
		{POSTOJ2}
	</span>
	
	<div id="ne" style="margin-top: 2px">
		Styl jízdy se bude odvíjet od agresivity rasy tvojí postavy.
	</div>

	<span id="taktika" style="display: none">
		<br />
		<span class="extra">Taktika:</span><br />
		{TAKTIKA1}
		{TAKTIKA2}
	</span>
	
	<br />
</form>
{::EXT}

{EXT ADD_BOT2}
<form action="adminz_process.php?action=add_bot2" method="post" style="margin-left: 20px" name="form_add_bot">
	<input type="hidden" name="action" value="add_bot" />
	
	<span class="extra">Rasa:</span><br />
	<select name="rasa" style="width: 360px">
		{RASY}
	</select>
	<br />
	<br />	
	<span class="extra">Kluzák:</span><br />
	<select name="sablona" style="width: 360px">
		{SABLONY}
	</select>
	<br />
	<br />
	<span class="extra">Závod:</span><br />
	<select name="zavod" style="width: 360px">
		{ZAVODY}
	</select>	
	<br />
</form>
{::EXT}

{TABLE SELECT}
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE POSTOJ1}
<select name="postoj1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE POSTOJ2}
<select name="postoj2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE TAKTIKA1}
<select name="taktika1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE TAKTIKA2}
<select name="taktika2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}">{NAZEV}</option>{::ROW}
</select>
{::TABLE}