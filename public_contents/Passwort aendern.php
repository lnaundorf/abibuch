<div align="center">
<h1>Passwort ändern</h1>
<br>
</div>
<?
	require('ValUser.php');
	require('actionLog.php');

	if ($loggedin) {
		if ($_POST) {
			$sql = "SELECT password FROM users WHERE id = ".$usrid." LIMIT 1";
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);
			
			$feld_pw_alt = mysql_real_escape_string($_POST['feld_pw_alt']);
			$neu_pw_1 = mysql_real_escape_string($_POST['neu_pw_1']);
			$neu_pw_2 = mysql_real_escape_string($_POST['neu_pw_2']);
			
			$error = false;
			
			if (sha1($feld_pw_alt) != $result['password']) {
				$error = true;
				echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Dein altes Passwort stimmt nicht überein</p></div>';
			}
			if ($neu_pw_1 != $neu_pw_2) {
				$error = true;
				echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Die eingegebenen neuen Passwörter stimmen nicht überein</p></div>';
			} else {
				if (strlen($neu_pw_1) < 5) {
					$error = true;
					echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Dein neues Passwort muss mindestens 5 Zeichen enthalten</p></div>';
				} else if ($neu_pw_1 == $user) {
					$error = true;
					echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Dein neues Passwort darf nicht dein Benutzername sein</p></div>';
				}
			}
			
			if (!$error) {
				logAction($usrid, "Passwort geaendert");
				
				$sql2 = "UPDATE  users SET password = '".sha1($neu_pw_1)."' WHERE id = ".$usrid." LIMIT 1";
				$result2 = mysql_query($sql2);
				if ($result2) {
					$_SESSION['password'] = sha1($neu_pw_1);
					echo '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Dein Passwort wurde erfolgreich geändert</p></div>';
				} else {
					echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Es ist ein Fehler aufgetreten. Dein Passwort wurde nicht geändert</p></div>';
				}
			}
		}
	}
?>

<form method="post" action="?s=public_contents/Passwort aendern.php"><fieldset>
	<div class="clearfix"><label>Altes Passwort:</label><div class="input"><input class="xlarge" name="feld_pw_alt" type="password"></div></div>
	<div class="clearfix"><label>Neues Passwort:</label><div class="input"><input class="xlarge" name="neu_pw_1" type="password"></div></div>
	<div class="clearfix"><label>Neues Passwort wiederholen:</label><div class="input"><input class="xlarge" name="neu_pw_2" type="password"></div></div>
	<div class="actions"><input class="btn primary" name="sumbit" type="submit" value="Passwort ändern"></div></fieldset>
</form>
