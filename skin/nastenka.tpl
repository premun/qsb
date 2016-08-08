{MAIN}{OBSAH}{::MAIN}

{TABLE ADMINSKA}
	{ROW}
		<div class="adminska_nastenka">
			<strong class="nadpis">{TITULEK}</strong>
			{OBSAH}
		</div>
	{::ROW}
{::TABLE}

{TABLE ONLINE}
	<div style="height: 6px; border-bottom: 1px solid #444"></div>
	{ROW}
		<a class="online_nastenka" href="showProfile.php?id={ID}">{LOGIN2}</a><a class="online_nastenka_cas" onclick="jHadr('posta.php', {id: '{LOGIN}'})">{CAS} @</a>
	{::ROW}
	<div style="clear: both"></div>
{::TABLE}

{TABLE IRC}
	<br />
	Online uživatelé na <a href="http://world.qsb.cz/clanek/65/irc_kanal" target="_blank">IRC</a>:
	<div style="height: 6px; border-bottom: 1px solid #444"></div>
	{ROW}
		<a class="online_nastenka" href="showProfile.php?login={LOGIN}">{LOGIN}</a><a class="online_nastenka_cas">&nbsp;</a>
	{::ROW}
	<div style="clear: both"></div>
{::TABLE}

{TABLE PALIVA}
	<div style="border-bottom: 1px solid #444; color: #FFFFFF">Paliva na skladě:</div>
	{ROW}
		<a class="online_nastenka" onclick="jHadr('sellPalivo.php?id={ID}', {})" style="width: 74px">{NAZEV}</a><a class="online_nastenka_cas" onclick="jHadr('sellPalivo.php?id={ID}', {})" style="width: 43px">{MNOZSTVI} {JEDNOTKA}</a>
	{::ROW}
	<div style="clear: both"></div>
	<a class="online_nastenka" href="obchod.php?action=paliva" style="width: 33px">Celkem</a><a class="online_nastenka_cas" href="obchod.php?action=paliva" style="width: 84px">{CELKEM}/{LICENCE}</a>
	<div style="clear: both"></div>
	<br />	
{::TABLE}

{TABLE PALIVA_CENY}
	<div style="border-bottom: 1px solid #444; margin-top: 8px; color: #FFFFFF">Ceny paliv:</div>
	{ROW}
		<a class="online_nastenka" onclick="jHadr('sellPalivo.php?id={ID}', {})" style="width: 74px">{NAZEV}</a><a class="online_nastenka_cas" onclick="jHadr('sellPalivo.php?id={ID}', {})" style="width: 43px"><span style="color: {BARVA} !important">{CENA}</span></a>
	{::ROW}
	<div style="clear: both"></div>
	<br />
{::TABLE}

{MISC ADMIN}<img src="./skin/img/forum_admin.jpg" alt="Admin" style="margin-top: 4px; border: none; position: absolute" />&nbsp;&nbsp;&nbsp;{::MISC}
{MISC KONZUL}<img src="./skin/img/forum_admin2.jpg" alt="Galaktický konzul" style="margin-top: 4px; border: none; position: absolute" />&nbsp;&nbsp;&nbsp;{::MISC}