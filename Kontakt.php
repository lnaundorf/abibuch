<div align="center">
<h1>Kontakt</h1>
</div>
<?
	require ('ValUser.php');
	
	echo '<h2>Das Komitee</h2>';
	echo '<table border="0" style="font-size: 13pt; width: 65%">
	<tr><td class="table-plain">XXX</td><td class="table-plain">XXX</td><td class="table-plain">XXX</td></tr>
	<tr><td class="table-plain">XXX</td><td class="table-plain">XXX</td><td class="table-plain">XXX</td></tr>
	<tr><td class="table-plain">XXX</td><td class="table-plain">XXX</td><td class="table-plain">XXX</td></tr>
	</table><br><br>';
	
	echo '<h2>Kontaktformular</h2>';

	if ($_POST['abschicken']) {
		
		$error = false;
		if ($_POST['name'] == '') {
			echo '<div id="tt1" class="alert-message error"><a class="close" href="javascript:removett(\'tt1\')">&times;</a><p><strong>Fehler:</strong> Bitte gebe einen Namen ein.</p></div>';
			$error = true;
		}
		if ($_POST['email'] == '') {
			echo '<div id="tt2" class="alert-message error"><a class="close" href="javascript:removett(\'tt2\')">&times;</a><p><strong>Fehler:</strong> Bitte gebe eine Absenderadresse ein.</p></div>';
			$error = true;
		}
		if ($_POST['message'] == '') {
			echo '<div id="tt3" class="alert-message error"><a class="close" href="javascript:removett(\'tt3\')">&times;</a><p><strong>Fehler:</strong> Bitte gebe eine Nachricht ein.</p></div>';
			$error = true;
		}
		
		if (!$error) {
			$betreff = 'Frage von: '.$_POST['name'].', Benutzername: '.$user;
			$absender = $_POST['email'];
			$text = $_POST['message'];
			$empfaenger = "user@domain.tld";
		
			if(mail($empfaenger, $betreff, $text, "from:".$absender."\r\nContent-Type: text/plain; charset=utf-8")) {
				echo '<div id="tt4" class="alert-message success"><a class="close" href="javascript:removett(\'tt4\')">&times;</a><p>Deine Nachricht wurder erfolgreich verschickt.</p></div>';
			} else {
				echo '<div id="tt5" class="alert-message error"><a class="close" href="javascript:removett(\'tt5\')">&times;</a><p><strong>Fehler:</strong> Beim Verschicken deiner Nachricht ist ein Fehler aufgetreten.</p></div>';
			}
		}
	}
	
	if($loggedin) {
		$sql = "SELECT first_name, last_name FROM users WHERE id = ".$usrid." LIMIT 1";
		$query = mysql_query($sql);
		$name = mysql_fetch_array($query);
	}
?>
<form method="post" action="?s=Kontakt.php" accept-charset="utf-8"><fieldset>
<div class="clearfix"><label>Dein Name:</label><div class="input"><input type=text name="name" value="<?if($loggedin) echo $name['first_name']." ".$name['last_name']?>"></div></div>
<div class="clearfix"><label>Deine E-mail:</label><div class="input"><input type=text name="email"></div></div>
<div class="clearfix"><label>Text:</label><div class="input"><textarea name="message" class="xxlarge" rows="5" cols="35"></textarea></div></div>
<div class="actions"><input class="btn primary" type="submit" name="abschicken" value="abschicken"></div>
</fieldset></form>