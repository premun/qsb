{MAIN}
<h3>Fórum</h3>
<ul class="forum_left">
	{FORA}
</ul>
<ul class="forum_right">
	{FORA2}
</ul>
<hr style="clear: both" />
{FORM}
<h3>{NAZEV}</h3>
{SIPKY}
<br />
{ZPRAVY}
{SIPKY}
{::MAIN}

{TABLE FORA}
<ul>
{ROW}<li><a href="forum.php?place={PLACE}">{NAZEV}</a> {POCET}</li>{::ROW}
</ul>
{::TABLE}

{TABLE SMILES}
{ROW}<img src="./skin/img/smiles/{X}.gif" class="submit" alt="[SM{X}]" onclick="vlozTagy('[SM{X}]','')" style="margin-right: 2px; margin-left: 3px" height="20" />{::ROW}
{::TABLE}

{MISC FORM}
<h3 class="submit" onclick="showForumForm(2)">Poslat příspěvek <span class="ultra">-</span> zde <span class="extra">&raquo;</span></h3>
<form action="send_forum.php?place={PLACE}" method="post" name="send" style="_display: none">
<textarea name="msg" cols="42" rows="{ROWS}"></textarea><br />	
{SMILES}
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
<input type="button" class="submit" value="Náhled" style="width: 176px" onclick="jHadr('forum.php', {action: 'nahled', msg: 'object::msg'})" />
<input type="submit" class="submit" value="Poslat" style="width: 176px" />
</form>
<hr />
{::MISC}

{TABLE ZPRAVA}
    {ROW}<table class="posta" cellspacing="0" cellpadding="0">
    <tr>
    <td class="nick"{ADD}>{ADMIN}{DELETE}<a href="showProfile.php?id={LOGIN}"{ADD}>{VLAJKA}{NICK}</a><a href="#" onclick="vlozTagy('[B][G]&gt;[/G] {NICK}:[/B] ','');" style="color: #666"> | Re</a></td>
    <td class="datum"{ADD}>{DATUM}</td>
    </tr>
    <tr>
    <td class="msg" colspan="2">{MSG}</td>
    </tr>
    <tr><td class="lista" colspan="2"></td></tr>
    </table>
    <br /><br />{::ROW}
{::TABLE}

{MISC ADMIN}<img src="./skin/img/forum_admin.jpg" alt="Admin" style="margin-right: 2px; margin-left: 3px" />&nbsp;{::MISC}
{MISC KONZUL}<img src="./skin/img/forum_admin2.jpg" alt="Galaktický konzul" style="margin-right: 2px; margin-left: 3px" />&nbsp;{::MISC}

{EXT STAJ}Nejsi členem této stáje{::EXT}

{EXT NAHLED}
<div style="width: 400px; padding: 8px; background-color: #000; border: 1px solid #444; margin-top: 3px; position: relative; left: 2px">
{TEXT}
</div>
{::EXT}