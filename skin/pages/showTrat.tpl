{MAIN}
<script type="text/javascript">
<!--
$(function() {
	$("#vypis_tab").tabs({ fx: { opacity: 'toggle' } });
});

//-->
</script>

<br />
<br />

<table cellspacing="0" cellpadding="0" class="zavod" style="width: 99%">
    <tr class="horni">
    	<td style="padding: 3px" colspan="2"><strong>{NAZEV}</strong></td>
    </tr>
    <tr>
    	<td class="val">Autor: </td>
    	<td style="vertical-align: middle"><a href="showProfile.php?id={LOGIN}">{NICK}</a></td>
    </tr>
    <tr>
    	<td class="val">Datum vytvoření: </td>
    	<td style="vertical-align: middle">{DATUM}</td>
    </tr>  
    <tr>
    	<td class="val">Počet úseků: </td>
    	<td style="vertical-align: middle">{USEKY}</td>
    </tr>
    <tr>
    	<td class="val">Obtížnost: </td>
    	<td style="vertical-align: middle">{DIFF} %</td>
    </tr>
    <tr>
    	<td class="val">Maximální dotace: </td>
    	<td style="vertical-align: middle">{DOTACE} Is</td>
    </tr>
    <tr>
    	<td class="val">Rating: </td>
    	<td style="vertical-align: middle">{RATING} (hodnotilo {HODNOTILO})</td>
    </tr>
    <tr>
    	<td class="val">Popis: </td>
    	<td style="padding-right: 6px; vertical-align: middle">{POPIS}</td>
    </tr>
    <tr>
    	<td class="val" style="text-align: left">Závody: </td>
    	<td style="vertical-align: middle"><a href="zavody.php?action=neodjete&trat={ID}">Neodjeté</a>/<a href="zavody.php?action=odjete&trat={ID}">Odjeté</a> <span class="ultra">(vypíše závody na této trati)</span></td>
    </tr>
    <tr{KOUPIT}>
    	<td class="val">Palivo na trať:</td>
    	<td style="vertical-align: middle"><a href="buyPalivo.php?id={PALIVO}&trat={ID}">Koupit</a></td>
    </tr>
    <tr{HODNOTIT}>
   		<td class="val">Ohodnotit:</td>
	   	<td style="vertical-align: middle"><a href="hodnotitTrat.php?id={ID}&opt=1">Špatná</a>/<a href="hodnotitTrat.php?id={ID}&opt=2">Průměrná</a>/<a href="hodnotitTrat.php?id={ID}&opt=3">Dobrá</a></td>
	</tr>
    <tr>
    	<td colspan="2" class="lista"></td>
    </tr>
</table>
<br /><br /><br />
<div id="vypis_tab">
	<ul>
		<li><a href="#vypis">Výpis úseků trati</a></li>
		<li><a href="#graf">Grafický výpis</a></li>
		<li><a href="#flash">Flash 2D visualizace</a></li>
	</ul>
	<div id="vypis">
		{USEKY2}
	</div>
	<div id="graf">
		<span style="position: relative; left: -12px">Rychlostní graf:<br />
		<img src="showTratGraf.php?id={ID}&action=rychlost" alt="Rychlostní graf" style="margin-top: 6px" />
		<br />
		Nebezpečnostní graf:<br />
		<img src="showTratGraf.php?id={ID}&action=nebezpeci" alt="Nebezpečnostní graf" style="margin-top: 6px" />		
		</span>
	</div>
	<div id="flash">
		{FLASH}
	</div>
</div>
<br /><br />
{::MAIN}

{TABLE USEKY}
<table cellspacing="0" cellpadding="0" class="zavod" style="border: none; margin: auto; width: 98%">
    {ROW}
    <tr>
		<td style="padding-left: 8px; padding-top: 0px; padding-bottom: 0px">{NAZEV}</td><td style="padding-top: 0px; padding-bottom: 0px; text-align: right"><span style="color: {BARVA1}">{NEBEZPECI}</span>&nbsp;&nbsp;&nbsp;</td><td style="padding-top: 0px; padding-bottom: 0px; text-align: right"><span style="color: {BARVA2}">{RYCHLOST}</span>&nbsp;&nbsp;&nbsp;</td>
	</tr>
    {::ROW}
</table>
{::TABLE}

{TABLE USEKY2}
<table cellspacing="0" cellpadding="0" class="zavod">
    <tr class="horni">
    	<td style="padding: 3px" colspan="3"><strong>Výpis úseků trati</strong></td>
    </tr>
    {ROW}
    <tr>
		<td style="padding-left: 8px; padding-top: 0px; padding-bottom: 0px">{NAZEV}</td><td style="padding-top: 0px; padding-bottom: 0px; text-align: right"><span style="color: {BARVA1}">{NEBEZPECI}</span>&nbsp;&nbsp;&nbsp;</td><td style="padding-top: 0px; padding-bottom: 0px; text-align: right"><span style="color: {BARVA2}">{RYCHLOST}</span>&nbsp;&nbsp;&nbsp;</td>
	</tr>
    {::ROW}
    <tr>
		<td colspan="3" class="lista"></td>
	</tr>
</table>
{::TABLE}

{MISC FLASH}	
	<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="425" height="400" id="trate" align="middle" style="position: relative; left: -9px">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="true" />
		<param name="movie" value="flash/trate.swf?{PARAMS}" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#000000" />
		<embed src="flash/trate.swf?{PARAMS}" quality="high" bgcolor="#000000" width="425" height="400" name="trate" align="middle" allowScriptAccess="sameDomain" 
		allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
{::MISC}