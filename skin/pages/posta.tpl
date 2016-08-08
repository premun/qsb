{MAIN}
<h3>Pošta</h3>
<ul>
	<li><a href="posta.php">Napsat novou poštu</a></li>
	<li {NOVA1}><a href="posta.php?action=new">Přijatá nová pošta ({NOVA2})</a></li>
	<li><a href="posta.php?action=prijata">Přijatá pošta</a></li>
	<li><a href="posta.php?action=odeslana">Odeslaná pošta</a></li>
	<li><a href="posta.php?action=konverzace">Zobrazit vzájemnou konverzaci</a></li>
</ul>
<hr />
{OBSAH}
{::MAIN}

{MISC POSLAT}
<h3>Napsat novou poštu</h3>
<br />
<form action="send_posta.php" method="post" name="posta_send">
	<input type="hidden" name="prijemci" id="prijemci" value="1" />
	<span id="prijemce_1">
		Komu: <input type="text" name="nick_1" style="width: 150px" rel="ajaxList" value="{ADD}" />
		<a class="submit" onclick="prijemce()"><strong>+</strong> <span class="common">Přidat příjemce</span></a>
	</span>
    <br />
    <textarea name="posta_msg" cols="42" rows="9"></textarea><br />
    {SMILICI}
	<br />
	<div style="float: left; margin-top: 2px">
		<input type="button" class="submit" value="tučné" onclick="vlozTagy('[B]','[/B]')" title="[B][/B]" style="font-weight: bold; color: #FFF" /> 
		<input type="button" class="submit" value="kurzíva" onclick="vlozTagy('[I]','[/I]')" title="[I][/I]" style="font-style: italic; color: #FFF" /> 
		<input type="button" class="submit" value="podtržené" onclick="vlozTagy('[U]','[/U]')" title="[U][/U]" style="text-decoration: underline; color: #FFF" />
	</div>
	<div style="float: right; margin-top: 4px; padding-right: 49px">
		<div class="forum_barva" onclick="vlozTagy('[S]','[/S]')" title="[S][/S]"><div class="forum_barva_inner" style="background-color: #666; border-color: #494949"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[O]','[/O]')" title="[O][/O]"><div class="forum_barva_inner" style="background-color: #FF9900; border-color: #FF7700"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[R]','[/R]')" title="[R][/R]"><div class="forum_barva_inner" style="background-color: #CC0000; border-color: #990000"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[G]','[/G]')" title="[G][/G]"><div class="forum_barva_inner" style="background-color: #00CC00; border-color: #009900"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[M]','[/M]')" title="[M][/M]"><div class="forum_barva_inner" style="background-color: #0000CC; border-color: #000099"></div></div>
	</div>
	<br style="clear: both" />
	<input type="button" class="submit" value="Náhled" style="width: 176px" onclick="jHadr('posta.php', {action: 'nahled', msg: 'object::posta_msg'})" />
	<input type="submit" class="submit" value="Poslat" style="width: 176px" />
</form>
<br />
<br />
{::MISC}

{EXT POSLAT_JHADR}
<br />
<form action="send_posta.php" method="post" name="posta_send">
	<div style="float: left; padding-top: 3px">
		<input type="hidden" name="prijemci" id="prijemci" value="1" />
	    Komu: <input type="text" name="nick_1" style="width: 150px" value="{NICK}" rel="ajaxList" autocomplete="off" />	
	</div>
	<div style="float: right; padding-right: 1px">
		<input type="button" class="submit" value="tučné" onclick="vlozTagy('[B]','[/B]')" title="[B][/B]" style="font-weight: bold; color: #FFF; margin-left: 8px; padding-top: 1px; padding-bottom: 1px" /> 
		<input type="button" class="submit" value="kurzíva" onclick="vlozTagy('[I]','[/I]')" title="[I][/I]" style="font-style: italic; color: #FFF; padding-top: 1px; padding-bottom: 1px" /> 
		<input type="button" class="submit" value="podtržené" onclick="vlozTagy('[U]','[/U]')" title="[U][/U]" style="text-decoration: underline; color: #FFF; padding-top: 1px; padding-bottom: 1px" />
	</div>
    <textarea name="posta_msg" style="width: 458px; clear: both" rows="9"></textarea>    
	<br />
	<div style="float: left; margin-top: 2px">
	{SMILICI}
	</div>
	<div style="float: right; margin-top: 4px; padding-right: 1px">
		<div class="forum_barva" onclick="vlozTagy('[S]','[/S]')" title="[S][/S]"><div class="forum_barva_inner" style="background-color: #666; border-color: #494949"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[O]','[/O]')" title="[O][/O]"><div class="forum_barva_inner" style="background-color: #FF9900; border-color: #FF7700"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[R]','[/R]')" title="[R][/R]"><div class="forum_barva_inner" style="background-color: #CC0000; border-color: #990000"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[G]','[/G]')" title="[G][/G]"><div class="forum_barva_inner" style="background-color: #00CC00; border-color: #009900"></div></div>
		<div class="forum_barva" onclick="vlozTagy('[M]','[/M]')" title="[M][/M]"><div class="forum_barva_inner" style="background-color: #0000CC; border-color: #000099"></div></div>
	</div>
	<br style="clear: both" />
</form>
{::EXT}

{TABLE ODESLANA}
{HEADER}
{ROW}
<table class="posta" cellspacing="0" cellpadding="0" style="margin-bottom: 25px" name="posta_{ID}">
    <tr>
        <td class="nick">Pro: {VLAJKA}<a href="showProfile.php?id={KOMU}">{KOMU2}</a></td>
        <td class="datum">{DATUM}</td>
    </tr>
    <tr>
   	 <td class="msg" colspan="2">{ZPRAVA}</td>
    </tr>
    <tr>
    	<td class="smazat" colspan="2"><a href="posta.php?action=konverzace&login={KOMU}">konverzace</a> <span class="ultra">|</span> <a class="submit" onclick="deletePosta('odeslane','{ID}', '{DELETE_START}', '')">smazat</a></td>
    </tr>
    <tr>
    	<td class="lista" colspan="2"></td>
    </tr>
</table>
{::ROW}
<span id="lastPosta"></span>
{::TABLE}

{MISC PRIJATA_HEADER}
<h3>Přijatá pošta</h3>
<br />
<input type="checkbox" name="sys"{CHECKED} onchange="location='posta.php?action=prijata&start={START}&sys='+this.checked" /> <label for="moje">Skrýt systémovou poštu</label>
<br />
<br />
{::MISC}


{MISC ODESLANA_HEADER}
<h3>Odeslaná pošta</h3>
<br />
{::MISC}

{TABLE PRIJATA}
{HEADER}
{ROW}
<table class="posta" cellspacing="0" cellpadding="0" style="margin-bottom: 25px" name="posta_{ID}">
    <tr>
        <td class="nick">Od: {VLAJKA}<a href="showProfile.php?id={KDO}">{KDO2}</a></td>
        <td class="datum">{DATUM}</td>
    </tr>
    <tr>
   		<td class="msg" colspan="2">{ZPRAVA}</td>
    </tr>
    <tr>
    	<td class="smazat" colspan="2"><span{ODPOVEDET}><a class="submit" onclick="jHadr('posta.php', {id: '{KDO}'})">odpovědět</a> <span class="ultra">|</span> </span><a href="posta.php?action=konverzace&login={KDO}">konverzace</a> <span class="ultra">|</span> <a class="submit" onclick="deletePosta('{DELETE_ACTION}','{ID}', '{DELETE_START}', '{SYS}')">smazat</a></td>
    </tr>
    <tr>
    	<td class="lista" colspan="2"></td>
    </tr>
</table>
{::ROW}
<span id="lastPosta"></span>
{::TABLE}

{TABLE SMILICI}
{ROW}<img src="./skin/img/smiles/{X}.gif" class="submit" alt="[SM{X}]" onclick="vlozTagy('[SM{X}]','')" style="margin-right: 2px; margin-left: 3px" height="20" />{::ROW}
{::TABLE}

{TABLE SMILICI_POPUP}
{ROW}<img src="./skin/img/smiles/{X}.gif" class="submit" alt="[SM{X}]" onclick="vlozTagy('[SM{X}]','')" style="margin-right: 0px; margin-left: 3px" height="20" />{::ROW}
{::TABLE}

{MISC ODESLANA}
{ZPRAVY}
{SIPKY}
{::MISC}

{MISC KONVERZACE}
<h3>Vzájemná konverzace</h3>
<form action="posta.php" name="konverzace" method="get" style="position: relative; left: -25px">
	<input type="hidden" name="action" value="konverzace" />
	<div style="float: left">{HRACI}</div>
	<div style="float: right">
		<select name="order" onchange="document.konverzace.submit()">
			<option value="desc">Od nejnovějších</option>
			<option value="asc"{ORDER}>Od nejstarších</option>
		</select>
	</div>
	<br style="clear: both" />
	<br />
	{KONVERZACE}
</form>
{::MISC}

{TABLE KONVERZACE_HRACI}
<select name="login" onchange="document.konverzace.submit()">
	<option value=""></option>
	{ROW}<option value="{LOGIN}"{SELECTED}>{NICK}</option>
	{::ROW}
</select>
{::TABLE}

{EXT ZADNA_ODESLANA}
<br /><br />Žádná odeslaná pošta
{::EXT}

{EXT ZADNA_PRIJATA}
<h3>Přijatá pošta</h3>
<br />
<input type="checkbox" name="sys"{CHECKED} onchange="location='posta.php?action=prijata&start={START}&sys='+this.checked" /> <label for="moje">Skrýt systémovou poštu</label><br />
<br />
<br /><br />Žádná přijatá pošta
{::EXT}

{EXT NAHLED}
<div style="width: 400px; padding: 8px; background-color: #000; border: 1px solid #444; margin-top: 3px; position: relative; left: 2px">
{TEXT}
</div>
{::EXT}

{EXT NO_SEND}
Použijte prosím formulář vlevo
<script type="text/javascript">
<!--
	$("input[name=nick_1]").val('{NICK}');
//-->
</script>
{::EXT}

{TABLE KONVERZACE}
<a class="submit" onclick="jHadr('posta.php', {id: '{LOGIN}'})">odpovědět na vlákno</a>
<br />
<br />
{ROW}
<table class="posta" cellspacing="0" cellpadding="0" name="posta_{ID}" style="float: {FLOAT}; width: 350px">
    <tr>
        <td class="nick">Od: {VLAJKA}<a href="showProfile.php?id={KDO}">{KDO2}</a></td>
        <td class="datum">{DATUM}</td>
    </tr>
    <tr>
   		<td class="msg" colspan="2">{ZPRAVA}</td>
    </tr>
    <tr>
    	<td class="lista" colspan="2"></td>
    </tr>
</table>
<br style="clear: both" />
<br />
{::ROW}
{::TABLE}