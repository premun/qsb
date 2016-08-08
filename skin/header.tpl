<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<link rel="shortcut icon" href="{SKINDIR}img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="{SKINDIR}base.css" />
	<title>Quadra Speed Boosters {TITLE}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="{SKINDIR}jquery.css" />
	<script type="text/javascript" src="{SKINDIR}jquery1.js"></script>
	<script type="text/javascript" src="{SKINDIR}jquery2.js"></script>
	<script type="text/javascript" src="{SKINDIR}main.js"></script>
	<script type="text/javascript" src="{SKINDIR}json.js"></script>
	<script type="text/javascript" src="{SKINDIR}jhadr.js"></script>
	<script type="text/javascript">
	<!--
		var timestamp = {TIMESTAMP};
	//-->
	</script>
</head>
<body>
<br />

<div id="dialog"></div>

<div class="main">

	<div class="infobox">
		{POSTA}
		<a href="showProfile.php?id={I_HRAC}" class="nick">{HRAC}</a>
		<div class="odrazka"></div>
		<img src="{SKINDIR}img/rasa.jpg" alt="Rasa" /> {RASA}<br />
		<img src="{SKINDIR}img/dolar.jpg" alt="Peníze" /> {PENIZE} Is<br />
		<img src="{SKINDIR}img/prestiz.jpg" alt="Prestiž" /> {PRESTIZ}<br />
		<img src="{SKINDIR}img/tip.jpg" alt="Zobrazit tip" /> <a class="submit" onclick="jHadr('tip.php', {sekce: '{TIP_SEKCE}'})"> Zobrazit tip</a><br />
		<div class="odrazka"></div>
	</div>

	<div class="banner">
		<img src="{SKINDIR}img/logo{LOGO}.jpg" alt="Quadra Speed Boosters" />
	</div>

	<div class="banner_space"></div>
	
	<div class="row">
		
		<div class="menu_row">
			<div class="odrazka" style="text-align: center" onmouseover="prehod()" onmouseout="prehod()">
				<span class="gray" style="font-size: 11px; position: relative; top: 2px; left: -2px" id="cas" title="Po uběhnutí tohoto času dojde k auto-odhlášení">{CAS}</span>
			</div>
			<div class="container">
			  {MENU}
			</div>
			<div class="odrazka" style="height: 10px"></div>
	
		</div>
		
		<div class="right_row">
			<div class="obsah_row">
				<div class="odrazka">
					<div style="float: left">{SEKCE} <span class="gray" style="font-size: 11px; font-family: Arial, Helvetica, sans-serif">&gt;&gt;</span>&nbsp;&nbsp;</div>
					<div style="float: right">
						<div class="error">{ERROR}</div>						
					</div>
				</div>
				<div class="obsah">