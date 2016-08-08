<script type="text/javascript">
<!--
runtimeVersion = "3.5.30729";
checkClient = false;
directLink = "QSB_client.application";


function Initialize() {
	if (HasRuntimeVersion(runtimeVersion, false) || (checkClient && HasRuntimeVersion(runtimeVersion, checkClient))) {
		InstallButton.href = directLink;
		BootstrapperSection.style.display = "none";
	}
}

function HasRuntimeVersion(v, c) {
	var va = GetVersion(v);
	var i;
	var a = navigator.userAgent.match(/\.NET CLR [0-9.]+/g);
	
	if (c)
		a = navigator.userAgent.match(/\.NET Client [0-9.]+/g);
		
	if (a != null)
		for (i = 0; i < a.length; ++i)
			if (CompareVersions(va, GetVersion(a[i])) <= 0)
				return true;
				
	return false;
}

function GetVersion(v) {
	var a = v.match(/([0-9]+)\.([0-9]+)\.([0-9]+)/i);
	return a.slice(1);
}

function CompareVersions(v1, v2) {
	for (i = 0; i < v1.length; ++i)	{
		var n1 = new Number(v1[i]);
		var n2 = new Number(v2[i]);
		if (n1 < n2)
			return -1;
		if (n1 > n2)
			return 1;
	}
	return 0;
}

-->
</script>
<h3>QSB client&nbsp;&nbsp;<span class="ultra" style="font-size: 12px; font-style: normal; font-weight: normal">v{VERZE}</span></h3>
<br />
QSB client je externí aplikace pro hru Quadra Speed Boosters. Jedná se o klienta umožňujícího příjem a odesílání pošty bez potřeby přihlašovat se do hry přes internetový prohlížeč. Program můžete nechat běžet na pozadí a on vás bude informovat o dění ve hře a upozorňovat formou výstrah. Na dalších funkcích jako sledování oprav/smluv a dalších se momentálně pracuje a projekt je ve fázi vývoje.
<br />
<br />
<a href="./images/client_posta.jpg" target="_blank"><img src="./images/client_posta.jpg" alt="Přijatá pošta" style="float: left; border: none" class="submit" width="220" /></a>
<a href="./images/client_settings.jpg" target="_blank"><img src="./images/client_settings.jpg" alt="Nastavení klienta" style="float: right; border: none" class="submit" width="220" /></a>
<br style="clear: both" />
<br />
<br />
<div style="text-align: center">
	<button class="submit" onclick="location='client_data/setup.exe'">Stáhnout aktuální verzi ({VERZE})</button>
</div>
<br />
<h4>Systémové požadavky</h4>
<ul>
	<li><a href="http://www.microsoft.com/">Operační systém Windows <span class="ultra">(XP, Vista, 7)</span></a></li>
	<li><a href="http://www.microsoft.com/NET/">.NET Framework 3.5+</a></li>
	<li><span style="color: #FFFFFF">Windows Installer 3.1</span></li>
	<li><span style="color: #FFFFFF">Pevné nervy</span></li>	
</ul>
<h4>Changelog</h4>
<br />
<strong class="extra">v0.2 build 1</strong>
<ul style="margin-top: 2px">
	<li><span style="color: #FFF">Opraven bug - pošta ve hře nebyla mazána</span></li>
	<li><span style="color: #FFF">Chystá se fix přepisování konfigu updatem</span></li>
</ul>
<strong class="extra">v0.03 build 7</strong>
<ul style="margin-top: 2px">
	<li><span style="color: #FFF">Možnost "Odpovědět"</span></li>
	<li><span style="color: #FFF">Možnost vymazání pošty (i ze hry)</span></li>
	<li><span style="color: #FFF">Interní úpravy (HTTP...)</span></li>
</ul>
<strong class="extra">v0.03 build 3</strong>
<ul style="margin-top: 2px">
	<li><span style="color: #FFF">Zabezpečena aktualizace</span></li>
</ul>
<strong class="extra">v0.03 build 2</strong>
<ul style="margin-top: 2px">
	<li><span style="color: #FFF">Bugfix + stabilita</span></li>
	<li><span style="color: #FFF">Klikání na notify okno</span></li>
</ul>
<strong class="extra">v0.02 build 8</strong>
<ul style="margin-top: 2px">
	<li><span style="color: #FFF">První funkční verze</span></li>
	<li><span style="color: #FFF">Obsahuje příjem a odesílání pošty</span></li>
</ul>
<script type="text/javascript">
<!--
Initialize();
//-->
</script>
