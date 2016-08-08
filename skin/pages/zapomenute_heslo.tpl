{MAIN}
<h3>Zapomenuté heslo</h3>
Pokud jste zapomněli heslo, vložte zde nickname svého účtu, vygeneruje se náhodné jiné heslo a odešle na váš email (na který byl hráč registrována)<br /><br />
<form action="forget2.php" method="post" name="form_forget">
Nickname: <input type="text" name="nick" /><br />
E-mail na který byl nickname registrován: <input type="text" name="mail" /><br />
<input type="button" value=" OK " onclick="jHadr('forget2.php','form_forget')" />
</form>
{::MAIN}

{EXT COMMON}<h3>Zapomenuté heslo</h3><br />{::EXT}

{EXT NO_LOGIN}Vyplňte nickname{::EXT}
{EXT LOGIN}Nickname <strong>{NICK}</strong> neexistuje{::EXT}
{EXT EMAIL}Nickname {NICK} není registrován na email <strong>{MAIL}</strong>{::EXT}
{EXT USPESNA}Na vaši adresu byl odeslán email s novým heslem k účtu <strong>{NICK}</strong>{::EXT}