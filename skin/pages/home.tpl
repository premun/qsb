{MAIN}
<style type="text/css">
.zavody tr:hover td {
  background-color: #191919;
}

.oddelovac:hover td {
  background-color: #191919;
}

#box {
	display: none;
	width: 145px;
	height: auto;
	background-color: #000000;
	border: 1px solid #FF9900;
	position: fixed;
	margin-top: 80px;
	z-index: 10;
	padding: 4px;
	overflow: hidden;
	text-align: left;
}

#box span {
	color: #585858;
}

#box strong span {
	color: #FF9900;
}

#box table {
	text-align: left;
	margin: 0px;
	width: 100%;
}

#box td {
	vertical-align: top;
}
</style>
<div style="float: left">
	<br />
	<br />
	 <strong>Poslední přepočet - <span class="extra">{PREPOCET}</span></strong>
	<ul><strong>Přepočty</strong>
		<li><span style="color: white">{C13}</span></li>
		<li><span style="color: white">{C16}</span></li>
		<li><span style="color: white">{C19}</span></li>
		<li><span style="color: white">{C23}</span></li>
	</ul><hr />
	<h4>Statistiky ze dne {RESTART}</h4>
	{START}
	<br /><br />
	{SIPKY}
	<br /> 
	<strong>Odjeté závody</strong><br /><br /> 
	{ODJETE}
	<br /> <strong>Sázky</strong><br /><br />
	{SAZKY}
	<br /> <a href="prehledy.php?action=finance" style="font-weight: bold; color: #FFFFFF">Finance</a><br /><br />
	{FINANCE}
	<br /><br />
	{SIPKY}
</div>
{SEZONA}
<br style="clear: both" />
{::MAIN}

{TABLE ZAVODY}
<table cellspacing="0" cellpadding="1" class="zavody" style="width: 370px">
    <tr class="horni">
        <td class="info" style="text-align: center; width: 22px">ID</td>
        <td class="nick">Název</td>
        <td class="info" style="text-align: center; width: 35px">Čas</td>
        <td class="info" style="text-align: center; width: 42px">Pořadí</td>
        <td class="info" style="text-align: center; width: 62px">Výhra</td>
    </tr>
{ROW}    <tr>
        <td class="info" style="text-align: right">{ID}</td>
        <td class="nick"><a href="showRace.php?id={ID}">{NAZEV}</a></td>
        <td class="info" style="text-align: center">{CAS}</td>
        <td class="info" style="text-align: center">{PORADI}</td>
        <td class="info" style="text-align: right">{VYHRA}&nbsp;</td>
    </tr>{::ROW}
    <tr>
    	<td colspan="5" class="lista"></td>
    </tr>
</table>
{::TABLE}

{TABLE SAZKY}
<table cellspacing="0" cellpadding="1" class="zavody" style="width: 370px">
    <tr class="horni">
        <td class="info" style="text-align: center; width: 22px">ID</td>
        <td class="nick">Závod</td>
        <td class="info" style="text-align: center; width: 22px">Čas</td>
        <td class="info" style="text-align: center; width: 22px">Sázka</td>
        <td class="info" style="text-align: center; width: 22px">Výhra</td>
    </tr>
{ROW}    <tr>
        <td class="info" style="text-align: center; width: 22px">{ID}</td>
        <td class="nick"><a href="showRace.php?id={ZID}#sazky">{NAZEV}</a></td>
        <td class="info" style="text-align: center; width: 22px">{CAS}</td>
        <td class="info" style="text-align: right">{SAZKA}&nbsp;</td>
        <td class="info" style="text-align: right">{VYHRA}&nbsp;</td>
    </tr>{::ROW}
    <tr>
    	<td colspan="5" class="lista"></td>
    </tr>
</table>
{::TABLE}

{TABLE FINANCE}
<table cellspacing="0" cellpadding="1" class="zavody" style="width: 370px">
    <tr class="horni">
        <td class="info" style="text-align: center">Čas</td>
        <td class="info">Akce</td>
        <td class="info" style="text-align: center">Peníze</td>
    </tr>
{ROW}<tr>
        <td class="info" style="width: 3px">{CAS}</td>
        <td class="info">{AKCE}</td>
        <td class="info" style="width: 3px; font-weight: bold; color: {BARVA}; text-align: right;">{PENIZE}</td>
    </tr>{::ROW}
    <tr>
    	<td colspan="5" class="lista"></td>
    </tr>
</table>
{::TABLE}

{TABLE SEZONA}
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('td.normal').parent().toggle();
});
//-->
</script>
<div style="float: right; width: 60px; text-align: center; padding-top: 35px">
<strong class="extra" style="cursor: pointer" onclick="$('td.normal').parent().toggle()">Přehled<br />sezóny:</strong><br />
<strong class="ultra" style="cursor: pointer" onclick="$('td.normal').parent().toggle()">[click]</strong>
<br /><br />
<table cellspacing="0" class="sezona">
	{ROW}
		<tr><td onmousemove="showBox('{BOX}',event)" onmouseout="hideBox()" onclick="$('td.normal').parent().toggle();" class="{CLASS}">{DATUM}</td></tr>
	{::ROW}
</table>
</div>
<div id="box"></div>
{::TABLE}