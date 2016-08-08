{MAIN}
<h3>Tratě</h3>
<ul>
<li><a href="trate.php?action=all">Přehled tratí</a></li>
<li><a href="newTrack.php">Vytvořit trať</a></li>
</ul>
<hr />
<h3>Přehled tratí</h3>
<br />
<form action="trate.php" method="get" style="margin-left: 15px" name="form_dotace">
<input type="hidden" name="action" value="all" />
Pro určitou dotaci závodu: {DOTACE_SELECT}&nbsp;&nbsp;až&nbsp;&nbsp;{DOTACE_SELECT2}
</form>
<br />
<br />
{TRATE}
{SIPKY}
<br />
<br />
{::MAIN}

{MISC ZADNE}Nebyly nalezeny žádné tratě{::MISC}

{TABLE TRATE}
<table cellspacing="0" cellpadding="1" class="trate">
    <tr class="horni">
        <!--<td class="nazev" style="width: 3px"><a href="trate.php?by=id&dotace={DOTACE}&dotace2={DOTACE2}&order={SCID}&action=all"{SNAZEV}>ID</a></td>-->
        <td class="nazev"><a href="trate.php?by=nazev&dotace={DOTACE}&dotace2={DOTACE2}&order={SCNAZEV}&action=all"{SNAZEV}>Název</a></td>
        <td class="autor"><a href="trate.php?by=diff&dotace={DOTACE}&dotace2={DOTACE2}&order={SCDIFF}&action=all"{SDIFF}>Obtížnost</td>
        <td class="autor"><a href="trate.php?by=rating&dotace={DOTACE}&dotace2={DOTACE2}&order={SCRATING}&action=all"{SRATING}>Rating</td>
        <td class="autor"><a href="trate.php?by=delka&dotace={DOTACE}&dotace2={DOTACE2}&order={SCDELKA}&action=all"{SDELKA}>Úseků</td>
        <!--<td class="autor"><a href="trate.php?by=dotace&dotace={DOTACE}&dotace2={DOTACE2}&order={SCDOTACE}&action=all"{SDOTACE}>Dotace</td>-->
        <td class="autor"><a href="trate.php?by=login&dotace={DOTACE}&dotace2={DOTACE2}&order={SCLOGIN}&action=all"{SLOGIN}>Autor</a></td>
    </tr>
	{ROW}
    <tr>
        <!--<td class="nazev" style="text-align: right; width: 3px"><a href="showTrat.php?id={ID}">{ID}</a></td>-->
        <td class="nazev" style="text-align: left"><a href="showTrat.php?id={ID}">{NAZEV}</a></td>
        <td class="autor" style="text-align: right">{DIFF}%</td>
        <td class="autor" style="text-align: right">{RATING}%</td>
        <td class="autor" style="text-align: right">{DELKA}</td>
        <!--<td class="autor" style="text-align: right">{DOTACE}</td>-->
        <td class="autor" style="background-color: #000"><a href="showProfile.php?id={UID}">{LOGIN}</a></td>
    </tr>    
    {::ROW}	
<tr><td class="lista" colspan="6"></td></tr>
</table><br />
{::TABLE}

{TABLE DOTACE_SELECT}
<select name="dotace" onchange="document.form_dotace.submit()">
	<option value="0">Neurčeno</option>
	{ROW}<option value="{VALUE}"{SELECTED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}

{TABLE DOTACE_SELECT2}
<select name="dotace2" onchange="document.form_dotace.submit()">
	<option value="0">Neurčeno</option>
	{ROW}<option value="{VALUE}"{SELECTED}>{NAZEV}</option>{::ROW}
</select>
{::TABLE}