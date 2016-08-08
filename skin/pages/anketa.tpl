{MAIN}
<h3>Anketa</h3><br />
{ANKETY1}
{ANKETY2}
{::MAIN}

{TABLE ANKETA_DONE}
{ROW}
<strong>{OTAZKA}</strong>
<table class="anketa" cellpadding="4" cellspacing="0">
{OBSAH}
</table>
<span class="ultra">Celkem hlasovalo <strong><span style="color: white">{CELKEM}</span></strong></span>
<hr />
<br />
{::ROW}
{::TABLE}

{TABLE ANKETA_OPEN}
{ROW}
<strong>{OTAZKA}</strong>
<form action="vote.php?id={ID}" method="post" style="margin-left: 18px">
{OBSAH}
<input type="submit" value=" Hlasovat " class="submit" />
</form>
<hr />
<br />
{::ROW}
{::TABLE}

{TABLE ROW_OPEN}
{ROW}<input type="radio" name="anketa" value="{IDV}" style="vertical-align: middle"{CHECKED} /> {ANSWER}<br />{::ROW}
{::TABLE}

{TABLE ROW_DONE}
{ROW}
<tr>
	<td class="anketa_odpoved">{ANSWER}</td>
	<td class="anketa_procenta">{PROCENTA}%</td>
	<td class="anketa_pocet"><span class="ultra">{POCET}x&nbsp;</span></td>
	<td class="anketa_minibar">{MINIBAR}</td>
</tr>
{::ROW}
{::TABLE}