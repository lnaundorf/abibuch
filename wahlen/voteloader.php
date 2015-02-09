<?	
	
	
	if ($_GET['type'] AND $_GET['id']) {
		require('ValUser.php');
		
		if($_GET['type'] == 'schueler') {
			//schülervote
			$sql4 = "SELECT voteString FROM $database.voteList WHERE id = ".$_GET['id']." LIMIT 1";
			$query4 = mysql_query($sql4);
			$result4 = mysql_fetch_array($query4);
			echo '<br><font size="4">'.$result4['voteString'].'</font>';
			echo '<h3>'.$vote['voteString'].'</h3>';
			echo '<table border="0">';
		
			//Wahl männlich
			echo '<tr><td>Männlich</td><td><select name="m">';
			$sql2 = "SELECT id, first_name, last_name FROM $database.users WHERE geschlecht = 'm' and rights <= 1 and id <> ".$usrid." ORDER BY first_name ,last_name"; 
			$query2 = mysql_query($sql2);
		
			$voteid = (2 * $_POST['vote']) - 1;
		
			$sql5 = "SELECT voted FROM $database.voteStat WHERE voteid = ".$voteid." AND voting = ".$usrid;
			$query5 = mysql_query($sql5);
			$result5 = mysql_fetch_row($query5);
		
			echo '<option value="0" ';
			if ($result5[0] == 0) {
				echo 'selected="true"';
			}

			echo '>&nbsp;</option>';
			while ($name = mysql_fetch_array($query2)) {
				echo '<option value="'.$name[0].'"';
				if ($name[0] == $result5[0]) {
					echo ' selected="true"';
				}
			
				echo '>'.$name[1].' '.$name[2].'</option>';
			}
			echo '</select></td></tr>';
		
			//Wahl weiblich
			echo '<tr><td>Weiblich</td><td><select name="w">';
			$sql6 = "SELECT id, first_name, last_name FROM $database.users WHERE geschlecht = 'w' and rights <= 1 and id <> ".$usrid." ORDER BY first_name, last_name"; 
			$query6 = mysql_query($sql6);
		
			$voteid2 = (2 * $_POST['vote']);
		
			$sql7 = "SELECT voted FROM $database.voteStat WHERE voteid = ".$voteid2." AND voting = ".$usrid;
			$query7 = mysql_query($sql7);
			$result7 = mysql_fetch_row($query7);
		
			echo '<option value="0"';
			if ($result7[0] == 0) {
				echo ' selected="true"';
			}
			
			echo '>&nbsp;</option>';
			while ($name = mysql_fetch_array($query6)) {
				echo '<option value="'.$name[0].'"';
				if ($name[0] == $result7[0]) {
					echo ' selected="true"';
				}
			
				echo '>'.$name[1].' '.$name[2].'</option>';
			}
			echo '</select></td></tr>';
			echo '</table>';
			echo'<br><input name="speichern" type="submit" value="Speichern">';
			echo '</form>';
		} elseif($_GET['type'] == 'paar') {
			//paarvote
		
		
		
		} elseif($_GET['type'] == 'lehrer') {
			//lehrervote
		
		
		
		
		
		}
	}
?>