<?php

include 'library.php';

do_header('Tvorba trati', 'empty');
?>

<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="800" height="500" id="track_builder" align="middle" style="position: relative; left: -3px">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="true" />
	<param name="movie" value="flash/track_builder.swf?delka_useku=<?=$_GET['delka']?>&max_penize=<?=getPenize(UID)?>&nazev=<?=$_GET['nazev']?>" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#000000" />
	<embed src="flash/track_builder.swf?delka_useku=<?=$_GET['delka']?>&max_penize=<?=getPenize(UID)?>&nazev=<?=$_GET['nazev']?>" quality="high" bgcolor="#000000" width="800" height="500" name="track_builder" align="middle" allowScriptAccess="sameDomain" 
	allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<?php

do_file('','footer_empty');
?>