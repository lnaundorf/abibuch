<h1>Bilder freischalten</h1>

<?
	require('ValUser.php');
	require('actionLog.php');
	
	if ($loggedin AND $rights >= 10) {
		if($_POST['type'] == 1) {
			$activated_field = "baby_activated_by";
			$field = "babybild_status";
			$name = "Babybild";
			$otherfield = "jetztbild_status";
		} elseif($_POST['type'] == 2) {
			$activated_field = "jetzt_activated_by";
			$field = "jetztbild_status";
			$name = "aktuelle Bild";
			$otherfield = "babybild_status";
		}

		if ($_POST['approve'] == 'freischalten') {
			logAction($usrid, $name." freischalten von ".$_POST['id']);
			
			$sql = "UPDATE users SET ".$field." = 3, ".$activated_field." = ".$usrid." WHERE id = ".$_POST['id']." LIMIT 1";
			$result = mysql_query($sql);
			
			if($result) {
				echo 'Das '.$name.' des Benutzers mit der ID '.$_POST['id'].' wurde freigeschaltet<br>';
			} else {
				echo 'Fehler<br>';
			}
			
			if ($result) {
				$sql = "SELECT ".$otherfield." FROM users WHERE id = ".$_POST['id']." LIMIT 1";
				$query = mysql_query($sql);
				$user = mysql_fetch_array($query);
				
				if($user[$otherfield] == 3) {
					//set rights to 1
					$sql = "UPDATE users SET rights = 1 WHERE id = ".$_POST['id']." LIMIT 1";
					$result2 = mysql_query($sql);
					
					if($result2) {
						echo 'Benutzer mit ID '.$_POST['id'].' wurde erfolgereich für alle Bereiche freigeschaltet<br>';
					} else {
						echo 'Fehler beim Freischalten<br>';
					}
				}
			}
			
			getNextPicture();
		} elseif($_POST['block']) {
			echo 'wirklich das '.$name.' von '.$_POST['id'].' blocken?<br><br>';
			echo '<img src="imageloader.php?type='.$_POST['type'].'&id='.$_POST['id'].'&size=small">';
			echo '<form method="post">';
			echo '<input type="hidden" value="'.$_POST['id'].'" name="id">';
			echo '<input type="hidden" value="'.$_POST['type'].'" name="type">';
			echo '<input class="btn danger" type="submit" name="reallyblock" value="wirklich blocken"></form>';
		} elseif($_POST['reallyblock']) {
			
			echo 'blocken: '.$_POST['id'].'<br>';
			
			logAction($usrid, "blocken von ".$_POST['id']);
			
			$sql = "UPDATE users SET ".$field." = 2 WHERE id = ".$_POST['id']." LIMIT 1";
			$result = mysql_query($sql);
			
			if ($result) {
				echo 'erfolgreich gesperrt';
			} else {
				echo 'Fehler beim Sperren';
			}
			
			getNextPicture();
		} else {
			getNextPicture();
		}
	}

	function getNextPicture() {
		if(!getNextPic(1)) {
			if(!getNextPic(2)) {
				echo 'kein Bild zum Freischalten';
			}
		}
	}	


	function getNextPic($type) {
		if($type == 1) {
			$field = "babybild_status";
			$name = "Babybild";
			$field2 = "baby_activated_by";
		} elseif($type == 2) {
			$field = "jetztbild_status";
			$name = "Aktuelles Bild";
			$field2 = "jetzt_activated_by";
		} else {
			return false;
		}
		
		echo '<br><br>';
		
		$sql = "SELECT id, first_name, last_name FROM users WHERE $field2 = 0 AND ".$field." = 1 ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql);
		$user = mysql_fetch_array($query);
		if (mysql_num_rows($query) == 1) {
			echo '<br>'.$name.' von '.$user['first_name'].' '.$user['last_name'];
			if ($rights >= 11) {
				echo ': id:'.$user['id'].', typ: '.$type;
			}
			echo '<br><br>';
			echo '<img src="imageloader.php?type='.$type.'&id='.$user['id'].'&size=small">';
			echo '<form method="post">';
			echo '<input class="btn primary" name="approve" type="submit" value="freischalten">';
			echo '<input style="margin-left: 10px" class="btn danger" name="block" type="submit" value="NICHT FREISCHALTEN">';
			echo '<input type="hidden" value="'.$user['id'].'" name="id">';
			echo '<input type="hidden" value="'.$type.'" name="type">';
			echo '</form>';

			return true;
		} else {
			return false;
		}
	}
?>
