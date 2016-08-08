{MAIN}
<style type="text/css">
.zavod tr td {
    border-right: 1px solid #282828;
    border-bottom: 1px solid #282828;
    padding: 4px 6px 4px 6px;
}

.zavod td.val {
    color: #CCC;
}

.zavod tr:hover td {
	background-color: #191919;
}

.oddelovac:hover td {
	background-color: #191919;
}
</style>
<script type="text/javascript">
	<!--
	$(function() {
		$('#zavody_info').tabs({ fx: { opacity: 'toggle' } });
	});
	//-->
</script>

<h3>Info k závodu {NAZEV}</h3>

<br />

{INFO}    
{::MAIN}

{EXT COMMON}
    <h3>Závod</h3>
{::EXT}

{EXT EXIST}
	Hledaný závod neexistuje
{::EXT}

{TABLE VYHRY}
<br />
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 380px; border-right-width: 0px;">
    <tr class="horni">
    	<td><strong>Nick</strong></td>
		<td style="text-align: center"><strong>Pořadí</strong></td
		><td style="text-align: right; width: 90px"><strong>Výhra</strong></td>
    </tr>
    
    {ROW}
	<tr>
		<td><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
		<td style="text-align: center">{PORADI}</td>
		<td style="text-align: right">{VYHRA} Is</td>
	</tr>
    {::ROW}
    
	<tr>
		<td colspan="3" class="lista" style="border-width: 0px 1px 0px 1px"></td>
	</tr>
	
</table>
<br />
{::TABLE}

{TABLE SAZKY}
<br />
<table cellspacing="0" cellpadding="0" class="zavod" style="width: 380px; border-right-width: 0px;">
    <tr class="horni">
		<td>Nick</td>
        <td style="text-align: center">Vsazeno</td>
        <td style="text-align: center">Na hráče</td>
        <td style="text-align: center">Pořadí</td>
        <td style="text-align: center">Výhra</td>
        <td style="text-align: right">&nbsp;</td>
	</tr>
    {ROW}
    <tr>
		<td><a href="showProfile.php?id={ID}">{LOGIN}</a></td>
        <td style="text-align: right">{SAZKA}&nbsp;Is&nbsp;&nbsp;</td>
        <td>{ZAVODNIK}</td>
        <td style="text-align: center">{MISTO}</td>
        <td style="text-align: right">{VYHRA}&nbsp;&nbsp;</td>
        <td style="text-align: center">{STAV}</td>
	</tr>
    {::ROW}
	<tr>
		<td colspan="6" class="lista" style="border-width: 0px 1px 0px 1px"></td>
	</tr>
</table>
<br />
{::TABLE}

{MISC NEODJETO_INFO}
<div id="zavody_info" style="width: 420px; margin: auto">
    <ul>
        <li><a href="#vse">Závod</a></li>
        <li><a href="#zavodnici">Závodníci</a></li>
		{SAZKY_B}
		{EDITACE_B}
		{VSTUP_B}
		{HELP_B}
    </ul>
    
    <div id="vse">
		<br />
        <table cellspacing="0" class="zavod" style="width: 380px; border-width: 0px; border-left-width: 1px; border-top-width: 1px">
            <tr class="horni">
                <td colspan="2"><strong class="common">{NAZEV}</strong></td>
            </tr>
			
            <tr>
                <td class="val">Pořadatel: </td>
                <td><a href="showProfile.php?id={P_UID}">{PORADATEL}</a></td>
            </tr>

            <tr>
                <td class="val">Typ závodu: </td>
                <td>{TYP}</td>
            </tr>

            <tr>
                <td class="val">Dotace závodu: </td>
                <td>{DOTACE}</td>
            </tr>

            <tr>
                <td class="val">Výherní předmět: </td>
                <td>{PREDMET}</td>
            </tr>

            <tr>
                <td class="val">Minimální vklad: </td>
                <td>{VKLAD}</td>
            </tr>

            <tr>
                <td class="val">Cenová&nbsp;kategorie:&nbsp;</td>
                <td><span style="color: {BARVA}">{CENY}</span></td>
            </tr>

            <tr>
                <td class="val">Omezení prestiží: </td>
                <td>{PRESTIZ}</td>
            </tr>

            <tr>
                <td class="val">Vsazeno na závod: </td>
                <td>{SAZKY}</td>
            </tr>

            <tr>
                <td class="val">Trať: </td>
                <td><a href="showTrat.php?id={TRAT_ID}">{TRAT_NAZEV}</a></td>
            </tr>

            <tr>
                <td class="val">Čas odjetí: </td>
                <td>{CAS}</td>
            </tr>

            <tr>
                <td class="val">Datum odjetí: </td>
                <td>{DATUM}</td>
            </tr>

            <tr>
                <td class="val">Počet závodníků: </td>
                <td>{POCET2}/{POCET} <span class="ultra">(minimum na odjetí {MINIMUM})</span></td>
            </tr>

            <tr>
                <td class="val" style="vertical-align: top">Popis: </td>
                <td>{POPIS}</td>
            </tr>
            
			<tr>
				<td colspan="2" class="lista" style="border-width: 0px 1px 1px 1px"></td>
			</tr>			
        </table>
		<br />
    </div>

    <div id="zavodnici">
        {ZAVODNICI}
    </div>

    <div id="sazky">
		{VSADIT}
    </div>

    <div id="editace">
		{EDITACE}
    </div>

    <div id="vstup">
		{VSTUP}
    </div>
	
	{HELP}

</div>
{::MISC}

{TABLE ZAVODNICI}
<script type="text/javascript">
<!--
var shown = {SHOWN};

function hracInfo(id) {
	if(shown) {
		$('tr[name=tr_'+id+']').hide();
		shown = false;
	} else {
		$('tr[name=tr_'+id+']').show();
		shown = true;
	}
}
//-->
</script>
<br />
<table cellspacing="0" class="zavod" style="width: 380px; border-width: 0px; border-left-width: 1px; border-top-width: 1px">
{ROW}<tr onclick="hracInfo('{ID}')" class="submit">
    	<td class="val" style="background-color: #191919" colspan="2">
			<strong class="common">{NICK} <span class="ultra">&raquo;</span></strong>
		</td>
	 </tr>
        {KLUZAK}
	{::ROW}
            
	<tr>
		<td colspan="2" class="lista" style="border-width: 0px 1px 1px 1px"></td>
	</tr>
</table>
<br />
{::TABLE}

{TABLE KLUZAK}
{ROW}<tr name="tr_{ID}"{VICE_INFO}>
	<td class="val"><div style="width: 90px">{NAZEV}:</div></td>
    <td style="width: 290px">{VAL}</td>
</tr>{::ROW}
{::TABLE}

{MISC STYL_JIZDY}
	<script type="text/javascript">
	<!--
		$(function() {
			$("#agresivita").slider({
				animate: true,
				min: -100,
				max: 100,
				step: 1,
				value: {AGRESIVITA},
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
				value: {OPATRNOST},
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
		
		$(document).ready(function() {
			slajd({AGRESIVITA});
		});
	//-->
	</script>

	<form action="#" method="post" style="margin-left: 12px" name="form_zmenStyl">
		<span class="extra">Opatrnost:</span> <span id="opatrnost_value">{OPATRNOST}%</span>
		<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
			<tr>
				<td style="text-align: left; width: 33%">Nebezpečný / rychlý</td>
				<td style="text-align: center; width: 33%">Normální</td>
				<td style="text-align: right; width: 33%">pomalý / Opatrný</td>
			</tr>
		</table>
		<div id="opatrnost" style="margin-top: 4px; width: 360px"></div>

		<br />
		<input type="hidden" name="opatrnost" value="{OPATRNOST}" />
		
		<span class="extra">Agresivita:</span> <span id="agresivita_value">{AGRESIVITA}%</span>
		<table style="width: 362px; font-size: 10px; color: #999; margin-top: 4px" cellpadding="0" cellspacing="0">
			<tr>
				<td style="text-align: left; width: 33%">Defenzivní</td>
				<td style="text-align: center; width: 33%">Neutrální</td>
				<td style="text-align: right; width: 33%">Agresivní</td>
			</tr>
		</table>
		<div id="agresivita" style="margin-top: 4px; width: 360px"></div>

		<br />
		<input type="hidden" name="agresivita" value="{AGRESIVITA}" />
		
		<span class="extra">Postoj:</span> <span id="postoj_nazev">Neutrální</span><br />
		<span id="def" style="display: none">
			{POSTOJ1}
		</span>
		
		<span id="of" style="display: none">
			{POSTOJ2}
		</span>
		
		{OBET}
		
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
		{ULOZIT}
	</form>
{::MISC}

{TABLE POSTOJ1}
<select name="postoj1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE POSTOJ2}
<select name="postoj2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV} ({NAZEV2})</option>{::ROW}
</select>
{::TABLE}

{TABLE OBET}
<span id="obet">
	<br />
	<span class="extra" id="preferovany_cil">Preferovaný cíl:</span><br />
	<select name="obet" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
		<option value="0">žádný preferovaný cíl</option>
		{ROW}<option value="{ID}"{CHECKED}>{LOGIN}</option>{::ROW}
	</select>
</span>
{::TABLE}

{TABLE TAKTIKA1}
<select name="taktika1" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE TAKTIKA2}
<select name="taktika2" style="margin-top: 6px; width: 360px; text-align: center; margin-bottom: 7px">
	{ROW}<option value="{ID}"{CHECKED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{MISC ODJETO_INFO}
<div id="zavody_info" style="width: 420px; margin: auto">
    <ul>
        <li><a href="#vse">Závod</a></li>
        <li><a href="#prubeh">Průběh</a></li>
        <li><a href="#zavodnici">Závodníci</a></li>
        <li><a href="#vyhry">Výhry a pořadí</a></li>
        <li><a href="#sazky">Sázky</a></li>
    </ul>
    
    <div id="vse">
        <br />
		<table cellspacing="0" class="zavod" style="width: 380px; border-width: 0px; border-left-width: 1px; border-top-width: 1px">
            <tr class="horni">
                <td colspan="2"><strong class="common">{NAZEV}</strong></td>
            </tr>
			
            <tr>
                <td class="val">Pořadatel: </td>
                <td><a href="showProfile.php?id={P_UID}">{PORADATEL}</a></td>
            </tr>

            <tr>
                <td class="val">Typ závodu: </td>
                <td>{TYP}</td>
            </tr>

            <tr>
                <td class="val">Dotace závodu: </td>
                <td>{DOTACE}</td>
            </tr>

<!--            <tr>
                <td class="val">Minimální vklad: </td>
                <td>{VKLAD}</td>
            </tr>-->

            <tr>
                <td class="val">Výherní předmět: </td>
                <td>{PREDMET}</td>
            </tr>

            <tr>
                <td class="val">Cenová&nbsp;kategorie:&nbsp;</td>
                <td><span style="color: {BARVA}">{CENY}</span></td>
            </tr>

            <tr>
                <td class="val">Vsazeno na závod: </td>
                <td>{SAZKY}</td>
            </tr>

            <tr>
                <td class="val">Trať: </td>
                <td><a href="showTrat.php?id={TRAT_ID}">{TRAT_NAZEV}</a></td>
            </tr>

            <tr>
                <td class="val">Odjeto: </td>
                <td>{CAS} {DATUM}</td>
            </tr>

            <tr>
                <td class="val">Diváků: </td>
                <td>{DIVACI}</td>
            </tr>

            <tr>
                <td class="val">Počet závodníků: </td>
                <td>{POCET2}/{POCET}</td>
            </tr>

            <tr>
                <td class="val" style="vertical-align: top">Popis: </td>
                <td>{POPIS}</td>
            </tr>
            
			<tr>
				<td colspan="2" class="lista" style="border-width: 0px 1px 1px 1px"></td>
			</tr>
			            
        </table>
		<br />
    </div>

    <div id="prubeh">
		<br />
		<table class="zavod" cellspacing="0" style="width: 340px; border-right-width: 0px">
			<tr>
				<td colspan="2" class="lista" style="border-width: 0px 1px 1px 1px"></td>
			</tr>
			<tr class="submit" onclick="location='showRaceInfo.php?id={ID}'">
				<td class="val" style="border-right-width: 0px"><img src="skin/img/komentar.png" alt="Komentář závodu" /></td>
				<td>Komentář závodu</td>
			</tr>
			<tr class="submit" onclick="location='showRaceFight.php?id={ID}'">
				<td class="val" style="border-right-width: 0px"><img src="skin/img/souboje.png" alt="Přehled soubojů a srážek" /></td>
				<td>Přehled soubojů a srážek</td>
			</tr>
			<tr class="submit" onclick="location='showRaceGraph.php?id={ID}'">
				<td class="val" style="border-right-width: 0px"><img src="skin/img/grafy.png" alt="Rychlostní grafy" /></td>
				<td>Rychlostní grafy</td>
			</tr>            
			<tr>
				<td colspan="2" class="lista" style="border-width: 0px 1px 0px 1px"></td>
			</tr>
		</table>
		<br />
    </div>

    <div id="zavodnici">
        {ZAVODNICI}
    </div>

    <div id="vyhry">
		{VYHRY}
    </div>

    <div id="sazky">
		{SAZKY2}
    </div>

</div>
{::MISC}

{MISC HELP_B}
<li><a href="#napoveda"><img src="skin/img/help_icon.png" alt="Nápověda k jízdním stylům" style="border: none" /></a></li>
{::MISC}

{MISC HELP}
    <div id="napoveda">
		Pro vysvětlení tabulek najeď na ikony<br />
		<table class="jizdni_styly" cellpadding="0" cellspacing="0">
			<br />
			{STYLY1}
		</table>
		<br />
		<table class="jizdni_styly" cellpadding="0" cellspacing="0">
			{STYLY2}
		</table>
		<br />
		<br />

		<strong class="extra">Ofenzivní styly</strong>
		<ul>
			<li style="color: #666"><span class="extra">Silný úder</span> (Tad'hor)<span class="common"> - budete útočit jedním silným a pomalejším nárazem a pokusem o vyřazení jednoho předmětu (úder bude koncentrován na jedno místo). Tento útok způsobuje nejvíce škod, ale nejméně zpomaluje protivníka</span></li>
			<li style="color: #666"><span class="extra">Vrážení</span> (Yel hata)<span class="common"> - zasypete napadeného salvou slabších úderů a poškodíte mu kluzák na mnoha místech. Poškozen může být různý počet předmětů, avšak rovnoměrně. Výše škod a zpomalení oběti jsou střední.</span></li>
			<li style="color: #666"><span class="extra">Vytlačování</span> (Wakamo-su)<span class="common"> - zapřete se do nepřitele a budete ho drtit o trať neustálým tlačením. Protivník je velmi zpomalen, ale obdrží jen malé škody</span></li>
		</ul>
		
		<br />

		<strong class="extra">Defenzivní styly</strong>
		<ul>
			<li style="color: #666"><span class="extra">Unikání</span> (Ghan'khar)<span class="common"> - skvělá obrana proti vytlačování, kdy vhodným přejezdem napříč tratí navedete protvníka (který se vás snaží vytlačit) do skalky nebo jiné překážky</span></li>
			<li style="color: #666"><span class="extra">Pirueta</span> (Avi-pah)<span class="common"> - provedete jeden dlouhý a rázný úhybný manévr a změníte nepřátelský silný úder v sebevraždu</span></li>
			<li style="color: #666"><span class="extra">Kličkování</span> (Whirlee)<span class="common"> - rychlé změny směru vás ochrání před vrážením</span></li>
		</ul>
    </div>
{::MISC}