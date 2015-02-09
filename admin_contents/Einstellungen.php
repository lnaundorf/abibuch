<h1>Einstellungen</h1>

<?
	require('ValUser.php');
	
	if($loggedin AND $rights >= 10) {
	
		if($_POST['save']) {
			
			$correct = true;
			$alter = false;
		
			foreach ($_POST as $postname => $postvar) {
				if ($postname != 'save') {
					$sql = "UPDATE settings SET value = ".$postvar." WHERE name = '".$postname."' LIMIT 1";
					$result = mysql_query($sql);
					
					if(!$result) {
						$correct = false;
					} else if (mysql_affected_rows() == 1) {
						$alter = true;
					}
				}
			}
			
			if ($correct) {
				if ($alter) {
					echo '<font color="green" size="4">Die Einstellungen wurden erfolgreich aktualisiert.</font>';
				} else {
					echo '<font color="green" size="4">An den Einstellungen hat sich nichts geändert</font>';
				}
			} else {
				echo '<font color="red" size="4">Die Einstellungen konnten leider nicht aktualisiert werden</font>';
			}
			
			echo '<br><br>';
		}
		
		$sql = "SELECT name, value, description FROM settings";
		$query = mysql_query($sql);
		echo '<form method="post" action="'.$PHP_SELF.'">';
		echo '<table><thead><tr><th>Name</th><th>Wert</th><th>Beschreibung</th></tr></thead><tbody>';
		
		while($settings = mysql_fetch_array($query)) {
			echo '<tr><td>'.$settings['name'].'</td><td><input class="small" type="text" name="'.$settings['name'].'" value="'.$settings['value'].'"></td><td>'.nl2br($settings['description']).'</td></tr>';
		}
		
		echo '</tbody></table><br>';
		echo '<input class="btn primary" type="submit" name="save" value="Einstellungen speichern">';
		echo '</form>';
	}
?>