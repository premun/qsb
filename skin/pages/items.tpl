{MAIN}
<h3>Seznam předmětů - {KATEGORIE}</h3>
<hr />
<br />
{PREDMETY}
{::MAIN}

{TABLE KATEGORIE}
<form action="items.php" method="get" style="margin: 0px; display: inline" name="items">
<select name="typ" onchange="document.items.submit()">
{ROW}<option value="{ID}"{SELECTED}>{NAZEV}</option>{::ROW}
	<option value="motory">Motory detailně</a></li>
</select>
{::TABLE}

{TABLE PREDMETY}
<table cellspacing="0" cellpadding="1" class="zavod" style="width: 350px">
	<tr class="horni">
		<td colspan="4"><strong class="common">{NAME}</strong></td>
	</tr>
	{ROW}<tr>
    	<td class="val" style="{ODDELOVAC}"><a href="showItem.php?id={ID}&typ={TYP}"{EXTRA}>{NAZEV}</a>&nbsp;&nbsp;&nbsp;</td>
		<td class="ultra" style="text-align: center; {ODDELOVAC}">{TYPN}</td>
		<td style="text-align: right; {ODDELOVAC}">{DATUM}&nbsp;&nbsp;</td>
		<td style="text-align: right; {ODDELOVAC}">{CENA} Is</td>
    </tr>{::ROW}
            
	<tr>
		<td colspan="4" class="lista"></td>
	</tr>	
</table>
{::TABLE}

{TABLE MOTORY}
<table cellspacing="0" cellpadding="1" class="prehledy" style="margin-left: -5px">
    <tr class="horni">
        <!--<td class="id" style="width: 3px;"><a href="items.php?action=motory&sc={SC}&by=id">&nbsp;ID&nbsp;</a></td>-->
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=nazev">Název</a></td>
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=rychlost">Km/h</a></td>
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=zrychleni">Zrychl.</a></td>
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=vaha">Váha</a></td>
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=chlazeni">Chlazení</a></td>
        <!--<td class="nick"><a href="items.php?action=motory&sc={SC}&by=vydrz">Výdrž</a></td>-->
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=ovladatelnost">Ovladat.</a></td>
        <!--<td class="nick"><a href="items.php?action=motory&sc={SC}&by=spotreba">Spotřeba</a></td>-->
        <td class="nick"><a href="items.php?action=motory&sc={SC}&by=podvozek">Podvozek</a></td>
    </tr>
	{ROW}
    <tr>
        <!--<td class="id">{ID}</td>-->
        <td class="nick"><a href="showItem.php?id={ID}&typ={TYP}">{NAZEV}</a></td>
        <td class="nick" style="text-align: right; padding-right: 12px">{RYCHLOST}</td>
        <td class="nick" style="text-align: center">{ZRYCHLENI}%</td>
        <td class="nick" style="text-align: center">{VAHA}&nbsp;kg</td>
        <td class="nick" style="text-align: center">{CHLAZENI}&nbsp;MW</td>
        <!--<td class="nick" style="text-align: center">{VYDRZ}%</td>-->
        <td class="nick" style="text-align: center">{OVLADATELNOST}%</td>
        <!--<td class="nick" style="text-align: center">{SPOTREBA}</td>-->
        <td class="nick" style="text-align: center">{PODVOZEK}</td>
    </tr>    
    {::ROW}
    <tr>
    	<td class="lista" colspan="11"></td>
    </tr>
</table>
<br />
<br />
{::TABLE}