{MAIN}
<h3>Centrální Banka</h3>
<ul>
<li><a href="banky.php">Stav celkem</a></li>
<li><a href="banky.php?action=vklady">Vklady</a></li>
<li><a href="banky.php?action=pujcky">Půjčky</a></li>
</ul>
<hr />
{::MAIN}

{EXT NIC}
<h4>Tvůj bankovní stav</h4><br />
{VKLADY}
<br />
{PUJCKY}
{::EXT}

{MISC VKLADY1}
Tvoje vklady: <strong><span class="extra">{VKLAD} Is</span></strong> (úroková sazba {SAZBA1}% / hlavní přepočet)<br />
{::MISC}

{MISC VKLADY2}
V bance nemáš žádný vklad<br />
{::MISC}

{MISC PUJCKY1}
Tvoje půjčky: <strong><span class="extra">{PUJCKA} Is</span></strong> <br />
Na splacení zbývá <strong><span class="extra">{SPLATNOST}</span></strong> dní <em>(hlavních přepočtů)</em>
{::MISC}

{MISC PUJCKY2}
U banky nemáš žádnou půjčku<br />
{::MISC}

{EXT VKLADY}
<h4>Vklady</h4>
<br />
{VKLADY}
<br />
<form action="banky_process.php?action=vlozit" method="post">
<input type="hidden" name="hrac" value="{UID}" />
<input type="hidden" name="banka" value="{BANKA}" />
Uložit:&nbsp; <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Uložit částku " onclick="this.style.display = 'none'" />
</form>
<span class="ultra">(úroková sazba na přijaté vklady je <span class="common">{SAZBA}%</span> / hlavní přepočet)</span>
{::EXT}

{MISC VKLADY3}
Máš v bance vklad ve výši <strong class="extra">{VYSE}</strong> Is (úroková sazba {SAZBA}% / hlavní přepočet)<br />
<br />
<form action="banky_process.php?action=vybrat" method="post">
<input type="hidden" name="hrac" value="{UID}" />
<input type="hidden" name="vklad" value="{VYSE2}" />
<input type="hidden" name="banka" value="{BANKA}" />
Vybrat: <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Vybrat vklad " onclick="this.style.display = 'none'" />
</form>
{::MISC}

{EXT PUJCKY}
<h4>Půjčky</h4>
<br />
{PUJCKA}
{::EXT}

{MISC PUJCKY3}
Máš u banky půjčku ve výši <strong class="extra">{VYSE}</strong> Is<br />
Musíš ji splatit do <strong class="extra">{SPLATNOST}</strong> dní (hlavních přepočtů)<br />
Úroková sazba na poskytnuté úvěry: <strong class="extra">{SAZBA}%</strong> / hlavní přepočet<br />
<br /><br />
<form action="banky_process.php?action=splatit" method="post">
<input type="hidden" name="banka" value="{BANKA}" />
Půjčka: <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Splatit půjčku " onclick="this.style.display = 'none'" />
</form>
{::MISC}

{MISC PUJCKY4}
U banky nemáš žádnou půjčku<br />
<br />
Banka nabízí tyto druhy půjček:<br />

<form action="banky_process.php?action=pujcit" method="post">
<input type="hidden" name="banka" value="{BANKA}" /><br />
<input type="hidden" name="ir" value="6" />
<input type="hidden" name="spl" value="3" />
úrok 6%, splatnost 3 dni: <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Zažádat " onclick="this.style.display = 'none'" /><br />
<em>(maximálně si můžeš půjčit </em><strong>{MOVITOST} Is</strong><em>)</em>
</form>

<form action="banky_process.php?action=pujcit" method="post">
<input type="hidden" name="banka" value="{BANKA}" /><br />
<input type="hidden" name="ir" value="8" />
<input type="hidden" name="spl" value="7" />
úrok 8%, splatnost 7 dní: <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Zažádat " onclick="this.style.display = 'none'" /><br />
<em>(maximálně si můžeš půjčit </em><strong>{MOVITOST} Is</strong><em>)</em>
</form>

<form action="banky_process.php?action=pujcit" method="post">
<input type="hidden" name="banka" value="{BANKA}" /><br />
<input type="hidden" name="ir" value="10" />
<input type="hidden" name="spl" value="10" />
úrok 10%, splatnost 10 dní: <input type="text" name="kolik" />
<input type="submit" class="submit" value=" Zažádat " onclick="this.style.display = 'none'" /><br />
<em>(maximálně si můžeš půjčit </em><strong>{MOVITOST} Is</strong><em>)</em>
</form>
{::MISC}