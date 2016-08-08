{MAIN}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="shortcut icon" href="{SKINDIR}img/favicon.ico" />
	<title>Quadra Speed Boosters {TITLE}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="{SKINDIR}base2.css" />
	<link rel="stylesheet" type="text/css" href="{SKINDIR}jquery.css" />
	<script type="text/javascript" src="{SKINDIR}jquery1.js"></script>
	<script type="text/javascript" src="{SKINDIR}jquery2.js"></script>
	<script type="text/javascript" src="{SKINDIR}main.js"></script>
	<script type="text/javascript" src="{SKINDIR}json.js"></script>
	<script type="text/javascript" src="{SKINDIR}jhadr.js"></script>
</head>
<body>

<div id="dialog"></div>

<br />

<div class="main" style="background-image: none">
	<div class="banner">
		<img src="{SKINDIR}img/logo{LOGO}.jpg" alt="Quadra Speed Boosters" />
	</div>
	<div class="menu_space">
	
		<form action="prihlas.php" method="post" style="margin-left: 15px; font-size: 12px; color: #838383">
			<input type="text" name="login" maxlength="20" size="15" /><br />
			<input type="password" name="heslo" maxlength="20" size="15" /><br />
			<input type="submit" class="submit" value="Přihlásit" /><br />
			<input type="checkbox" name="autologin" id="autologin" /> <label for="autologin">Auto-přihlášení</label>
		</form>
	
		<div class="odrazka"></div>
		<div class="container">
			<a href="http://qsb.cz/">Úvod</a>
			<br />
			<a href="registrace">Registrace</a>
			<a href="zapomenute-heslo">Zapom. heslo</a>
			<a href="obrazky-ze-hry">Obrázky ze hry</a>
			<br />
			<a href="tutorial?1">Rychlý tutoriál</a>
			<br />
			<a href="http://help.qsb.cz/">Help</a>
			<a href="about">About</a>
			<a href="podpora">Podpora</a>
			<a href="stats">Statistiky</a>	
			<br />
			<a href="http://world.qsb.cz/">QSB World</a>		
			<a href="client">QSB Client</a>
		</div>
		<div class="odrazka"></div>

		<br />

	    <a href="podpora.php" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="{SKINDIR}img/miniban.gif" width="88" height="31" alt="Quadra Speed Boosters" /></a><br />
	  	<a href="http://www.zvav.cz" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="{SKINDIR}img/zvav.gif" width="88" height="31" class="submit" alt="Život, Vesmír a Vůbec - onlinová strategie" /></a><br />
	  	<a href="http://www.iw.cz" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="http://www.iw.cz/img/ico.gif" width="88" height="31" class="submit" alt="Insect World - Online hra" /></a><br />		
	  	<a href="http://www.nadacearise.com/" title="Strategická webová hra Nadace a říše pro vás zdarma" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="http://www.nadacearise.com/sites/default/files/banners/ikona_nar_whoa.gif" width="88" height="31" class="submit" alt="On-line strategická webová hra Nadace a říše" /></a><br />
		
	  	<a href="http://www.rimske-imperium.sk/" title="Online hra - Rimske Imperium" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="http://www.rimske-imperium.sk/grafika/obrazke/ikona.gif" width="88" height="31" class="submit" alt="Online hra - Rimske Imperium" /></a><br />
		
	  	<a href="http://www.on-game.cz/" target="_blank"><img style="border-style:none; margin-bottom: 4px" src="http://www.on-game.cz/images/ikonky/ikona3_88x31.gif" width="88" height="31" class="submit" alt="On-game - svět online her" /></a>
		<a href="http://pretel.cz">PřeTel.cz</a>
		
		
		
		<br />
		<br />

	</div>
	<div class="obsah_space">
		<div class="odrazka">&nbsp;</div>
		<div class="obsah">
		<div class="error">{ERROR}</div>
		
{::MAIN}