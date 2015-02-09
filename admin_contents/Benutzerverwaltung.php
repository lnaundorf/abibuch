<div align="center">
<h1>Benutzerverwaltung</h1>
</div>
<br>
<?
	require ('ValUser.php');
	require('actionLog.php');
	
	if ($rights >= 10) {
	
		if ($_POST['id']) {
			if($_POST['resetPassword']) {
				$sql = "SELECT username, first_name, last_name FROM users WHERE id = ".$_POST['id']." LIMIT 1";
				$user = mysql_fetch_array(mysql_query($sql));
				echo '<span style="font-size: 13pt">Das Passwort von '.$user['first_name'].' '.$user['last_name'].' wird auf das Initialpasswort 
				zurückgesetzt:<br><br>Benutzername: '.$user['username'].'<br>Passwort: '.$user['username'].
				'<br><br>Soll das Passwort wirklich zurückgesetzt werden?</span>';
				echo '<form method="POST" action="'.$PHP_SELF.'"><fieldset>';
				echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
				echo '<div  class="actions"><input class="btn primary" type="submit" name="reallyReset" value="Passwort zurücksetzen">';
				echo '<input class="btn" type="submit" name="zurück" value="zurück" style="margin-left: 20px"></div></fieldset></form>';
			
			} else {
				if ($_POST['savechanges']) {
					//check if updated username is not unique
					$sql = "SELECT id FROM users WHERE username = '".$_POST['feld_username']."' AND id <> ".$_POST['id'];
					if (mysql_num_rows(mysql_query($sql)) >= 1) {
						echo '<font color="red" size="4">Diesen Benutzernamen gibt es schon</font>';
					} else {
						//save the changes
						$sql = "UPDATE users SET username = '".$_POST['feld_username']."', first_name = '".$_POST['feld_firstname']."', last_name = '".$_POST['feld_lastname']."' WHERE id = ".$_POST['id']." LIMIT 1";
						if (mysql_query($sql)) {
							echo '<font color="green" size="4">Die Daten wurden erfolgreich aktualisiert</font>';
						} else {
							echo '<font color="red" size="4">Die Änderungen konnten leider nicht gespeichert werden.</font>';
						}
					}
				} elseif($_POST['reallyReset'] && $_POST['id']) {
					$sql = "UPDATE users SET password = sha1(username) WHERE id = ".$_POST['id']." LIMIT 1";
					$result = mysql_query($sql);
					if($result && mysql_affected_rows() == 1) {
						echo '<font color="green" size="4">Das Passwort wurde erolgreich zurückgesetzt</font>';
					} else {
						echo '<font color="red" size="4">Es ist ein Fehler aufgetreten. Das Passwort konnte nicht zurückgesetzt werden.<br>
							Eventuell ist das Passwort bereits zurückgesetzt.</font>';
					}
					
					logAction($usrid, "Passwort zurücksetzen von ".$_POST['id']);
				}
				
				$sql = "SELECT username, first_name, last_name FROM users WHERE id = ".$_POST['id']." LIMIT 1";
				$user = mysql_fetch_array(mysql_query($sql));
			
				echo '<h2>Benutzer bearbeiten</h2>';
				echo '<br>';
				echo '<form method="post" action="'.$PHP_SELF.'" accept-charset="utf-8">';
				echo '<table border="0">';
				echo '<tr><td><label>Benutzername: </label></td><td><input name="feld_username" id="feld_username" value="'.$user['username'].'" type="text"></td></tr>';
				echo '<tr><td><label>Vorname: </label></td><td><input name="feld_firstname" id="feld_firstname" value="'.$user['first_name'].'" type="text"></td></tr>';
				echo '<tr><td><label>Nachname: </label></td><td><input name="feld_lastname" id="feld_lastname" value="'.$user['last_name'].'" type="text"></td></tr>';
				echo '<tr><td></td><td><input class="btn info" name="resetPassword" type="submit" value="Passwort zurücksetzen"></td></tr>';
				echo '</table>';
				echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
				echo '<input class="btn primary" name="savechanges" type="submit" value="Änderungen Speichern">';
				echo '</form>';
				echo '<form method="post" action="'.$PHP_SELF.'">';
				echo '<input class="btn info" name="back" type="submit" value="zurück">';
				echo '</form>';
			}
		} else {
			if($rights <= 10) {
				$additional = " AND visible = 1";
			} else {
				$additional = "";
			}
			$sql = "SELECT id, username, first_name, last_name, rights, lastonline FROM users WHERE rights <= 1".$additional." ORDER BY first_name, last_name";
			$query = mysql_query($sql);
			
			echo '<table border="1">';
			echo '<thead><tr><th>id</th><th>Benutzername</th><th>Vorname</th><th>Nachname</th><th>zuletzt online</th><th>Aktion</th></tr></thead><tdata>';
			
			while ($user = mysql_fetch_array($query)) {
				$lod = substr($user['lastonline'],8,2).'.'.substr($user['lastonline'],5,2).'.'.substr($user['lastonline'],0,4).'; '.substr($user['lastonline'],11,2).':'.substr($user['lastonline'],14,2).':'.substr($user['lastonline'],17,2).' Uhr';
				echo'<form method="post" action="'.$PHP_SELF.'">';
				echo '<tr><td>'.$user['id'].'</td><td>'.$user['username'].'</td><td>'.$user['first_name'].'</td>';
				echo '<td>'.$user['last_name'].'</td><td>'.$lod.'</td>';
				echo '<input type="hidden" name="id" value="'.$user['id'].'">';
				echo '<td><input class="btn info" name="'.$user['id'].'" type="submit" value="bearbeiten"></td><tr></form>';
			}
			echo '</tdata></table>';
		}
	}	
?>
