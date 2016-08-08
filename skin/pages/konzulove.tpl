{MAIN}
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
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=novinka', {title: this.innerHTML})">Přidat novinku</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=posta', 	{title: this.innerHTML})">Rozeslat všem poštu</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=anketa', 	{title: this.innerHTML})">Vyhlásit novou anketu</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=nastenka',{title: this.innerHTML})">Adminská nástěnka</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=index',{title: this.innerHTML})">Upravit úvodní stránku</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=blokace_hrace', {title: this.innerHTML})">Zablokovat hráče</a></li>
	</ul>
</span>
<hr />

<h4 style="cursor: pointer" onclick="show('utility')">Utilities</h4>
<span id="utility">
	<ul>
		<li><a href="multaci.php">Mulťáci</a><br />
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=forum', {title: this.innerHTML})">Zpřístupnit mazání fóra</a></li>
<!--		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=add_bot', {title: this.innerHTML})">Přidat bota do závodu</a></li>
		<li><a class="submit" onclick="jHadr('konzulove_forms.php?action=add_bot2', {title: this.innerHTML})">Přidat autobota do závodu</a></li>-->
	</ul>
</span>
{::MAIN}

{EXT NEJSI}
<h3>Konzulové</h3>
<br />
Nejsi konzul. Asi tak.
<br />
<br />
{::EXT}

{MISC NOVINKA}
	<form action="konzulove.php?action=novinka" method="post" name="form_novinka">
		Titulek:<br />
		<input type="text" name="titulek" style="width: 454px" /><br />
		Novinka:<br />
		<textarea style="width: 454px" rows="5" name="novinka"></textarea><br />
	</form>
{::MISC}

{MISC POSTA}
	<form action="konzulove.php?action=posta" method="post" name="form_posta">
		Zpráva:<br />
		<textarea style="width: 454px" rows="8" name="zprava"></textarea><br />
	</form>
{::MISC}

{MISC ANKETA}
	<form action="konzulove.php?action=anketa" method="post" name="form_anketa">
		Otázka:<br />
		<input type="text" name="otazka" style="width: 454px" /><br />
		Odpovědi:<br />
		<textarea style="width: 454px" rows="4" name="odpovedi"></textarea><br />
	</form>
{::MISC}

{EXT EDITACE_SCRIPTU}
	<form action="konzulove_forms.php?action=edit_script" method="post" name="form_script">
		<textarea style="width: 650px; height: 700px; font-family: monospace" name="obsah">{OBSAH}</textarea>
		<input type="hidden" name="filename" value="{FILENAME}" />
	</form>
{::EXT}

{MISC ZALOHYL}
	<form action="konzulove_forms.php?action=zalohy" method="post" name="form_zalohyl">
		Heslo:&nbsp;&nbsp;&nbsp;<input type="password" name="heslo" /><br />
		<input type="hidden" name="title" value="OK" />
	</form>
{::MISC}

{MISC NASTENKA}
	<form action="konzulove.php?action=nastenka" method="post" name="form_nastenka">
		Titulek:<br />
		<input type="text" name="titulek" style="width: 454px" /><br />
		Obsah:<br />
		<textarea style="width: 454px" rows="4" name="obsah"></textarea><br />
	</form>
{::MISC}

{MISC BLOKACE_HRACE}
	<form action="konzulove.php?action=blokace_hrace" method="post" name="form_blokace_hrace" style="margin-top: 30px; margin-left: 130px">
		Login: <input type="text" name="login" style="width: 150px" rel="ajaxList" />
	</form>
{::MISC}

{EXT SABLONA}
	<form action="konzulove_process.php?action=sablona" method="post" name="form_sablona">
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
<form action="konzulove_process.php?action=add_bot" method="post" style="margin-left: 20px" name="form_add_bot">
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
<form action="konzulove_process.php?action=add_bot2" method="post" style="margin-left: 20px" name="form_add_bot">
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