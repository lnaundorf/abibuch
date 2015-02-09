<h1>Steckbriefe alphabetisch</h1>

<?
require('ValUser.php');
	
if ($rights >= 10) {

	$hide = false;
	if($_POST['hide'] == 'on') {
		$hide = true;
	}
	
	echo '<form method="POST"><input type="checkbox" name="hide"';
	if($hide) {
		echo ' checked';
	}
	
	echo '>&nbsp;Kategorien ausblenden&nbsp;<input class="btn primary" type="submit" name="Go" value="Aktualisieren"></form>';
	
	$sql3 = "SELECT id, first_name, last_name FROM users WHERE rights <= 1 AND visible = 1 ORDER BY first_name, last_name";
	$query3 = mysql_query($sql3);
	
	while($name = mysql_fetch_array($query3)) {
		
		echo '<br><br><table style="width: 60%">';
		echo '<tr>';
		if(!$hide) {
			echo '<td><label>Vorname: </label></td>';
		}
		echo '<td>'.$name['first_name'].'</td></tr><tr>';
		
		if(!$hide) {
			echo '<td><label>Nachname: </label></td>';
		}
		echo '<td>'.$name['last_name'].'</td></tr>';
		
		$sql4 = "SELECT id, name FROM steckbriefList ORDER BY type, reihenfolge";
		$query4 = mysql_query($sql4);
		
		while ($eintrag = mysql_fetch_array($query4)) {
			$sql2 = "SELECT value FROM steckbriefStat WHERE userID = ".$name['id']." AND type = ".$eintrag['id']." LIMIT 1";
			$query2 = mysql_query($sql2);
			$value = mysql_fetch_array($query2);
			
			echo '<tr>';
			if(!$hide) {
				echo "<td><label>".$eintrag['name'].": </label></td>";
			}
			echo "<td>";
			if($value['value'] == '') {
				echo '&nbsp';
			} else {
				echo $value['value'];
			}
			echo "</td></tr>";
		}
		
		echo '</table><br><br>';
	}
}
?>