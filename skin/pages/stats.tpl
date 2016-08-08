{MAIN}
<h3>Statistiky</h3>
<div style="margin-left: 35px">
Hráčů celkem: <strong>{CELKEM}</strong><br />
Aktivních hráčů: <strong>{ACTIVE}</strong><br />
Hráčů dnes: <strong>{DNES}</strong><br />
Hráčů online: <strong>{ONLINE}</strong><br />
</div>
<br />
{RASY2}
<br />
<br />
{::MAIN}

{TABLE RASY}
<table style="margin-left: 35px; width: 240px" cellpadding="0" cellspacing="0" class="zavody">
	<tr class="horni"><td colspan="2" style="padding-left: 2px"><strong>Rasy ve hře</strong></td></tr>
	{ROW}<tr><td style="padding-left: 4px">{NAZEV}</td><td style="padding-right: 6px">{POCET}</td></tr>{::ROW}
	<tr><td colspan="2" class="lista"></td></tr>
</table>
{::TABLE}