{MAIN}
{NADPIS}
<br />
{INFO}
{CASTI}
{::MAIN}

{MISC NADPIS1}
<h3>Depo</h3>
<ul>
<li><a href="obchod.php?action=sklad">Můj sklad</a></li>
</ul>
<hr />
{::MISC}

{MISC NADPIS2}
<h3 style="cursor: pointer" onclick="location='showProfile.php?id={ID}'">Kluzák hráče {LOGIN}</h3>
{::MISC}

{TABLE INFO}
<table class="zavod" style="margin-left: 30px; width: 350px" cellspacing="1" cellpadding="1">
	<tr class="horni"><td colspan="2"><strong>Info</strong></td></tr>
	{ROW}<tr><td>{TITLE}</td><td>{VALUE}</td></tr>{::ROW}
	<tr><td colspan="2" class="lista"></td></tr>
</table>
<br />
<hr />
<br />
<br />
{::TABLE}

{TABLE CASTI}
{ROW}<table class="zavod" style="margin-left: 30px; width: 350px" cellspacing="1" cellpadding="1">
	<tr class="horni">
    	<td colspan="2"><strong><a href="items.php?typ={TYP}">{NAZEV}</a></strong></td>
    </tr>
    {INFO}  
	<tr>
    	<td colspan="6" class="lista"></td>
    </tr>  
</table>
<br /><br />{::ROW}
{::TABLE}