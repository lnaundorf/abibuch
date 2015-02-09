<h1>Steckbrief</h1>

<?
require('ValUser.php');
	
if ($rights >= 10) {
	
	echo 'Steckbrief von ';
	
	$sql = "SELECT first_name, last_name, id FROM users WHERE visible = 1 AND rights <= 1 ORDER BY first_name, last_name";
	$query = mysql_query($sql);
	
	echo '<form method="post" action="?s=admin_contents/Steckbrief.php">';
	echo '<select name="id">';
	while ($user = mysql_fetch_array($query)) {
		echo '<option value="'.$user['id'].'"';
		if ($user['id'] == $_POST['id']) {
			echo 'selected="true"';
		}
		echo '>';
		echo $user['first_name'].' '.$user['last_name'];
		echo '</option>';
	}
	echo '</select>';
	echo '<input class="btn primary" name="submit" type="submit" value="anzeigen">';
	echo '</form>';
	
	
	if ($_POST) {
	
		echo '<br><br><table>';
	
		$sql = "SELECT first_name, last_name FROM users WHERE id = ".$_POST['id']." LIMIT 1";
		$query = mysql_query($sql);
		$name = mysql_fetch_array($query);
		echo '<tr><td><label>Vorname: </label></td><td>'.$name['first_name'].'</td></tr>';
		echo '<tr><td><label>Nachname: </label></td><td>'.$name['last_name'].'</td></tr>';
		
		$sql = "SELECT id, name FROM steckbriefList ORDER BY type, reihenfolge";
		$query = mysql_query($sql);
		
		while ($eintrag = mysql_fetch_array($query)) {
			$sql2 = "SELECT value FROM steckbriefStat WHERE userID = ".$_POST['id']." AND type = ".$eintrag['id']." LIMIT 1";
			$query2 = mysql_query($sql2);
			$value = mysql_fetch_array($query2);
			
			echo "<tr><td><label>".$eintrag['name'].": </label></td><td>".$value['value']."</td></tr>";
		}
		
		echo '</table><br><br>';
		echo '<h2>Bilder</h2>';
		
		if (haspic(1, $_POST['id'])) {
			echo 'Babybild:<br>';
			echo '<a href="imageloader.php?type=1&id='.$_POST['id'].'&action=download&first='.$name['first_name'].'&last='.$name['last_name'].'" target="_blank"><img src=imageloader.php?type=1&id='.$_POST['id'].'&size=small width=400></a><br><br>';
		} else {
			echo '<br><br><font color="red" size="4">Noch kein Babybild</font><br><br>';
		}
		
		if (haspic(2, $_POST['id'])) {
			echo 'Aktuelles Bild:<br>';
			echo '<a href="imageloader.php?type=2&id='.$_POST['id'].'&action=download&first='.$name['first_name'].'&last='.$name['last_name'].'" target="_blank"><img src=imageloader.php?type=2&id='.$_POST['id'].'&size=small width=400></a><br><br>';
		} else {
			echo '<br><br><font color="red" size="4">Noch kein aktuelles Bild</font><br><br>';
		}
	}
}

function haspic($type, $id) {
	if($type == 1) {
		$field = "babybild_status";
	} elseif($type == 2) {
		$field = "jetztbild_status";
	} else {
		return false;
	}
	
	$sql = "SELECT ".$field." FROM users WHERE id = ".$id." LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result[$field] >= 1) {
		return true;
	} else {
		return false;
	}
}
?>
