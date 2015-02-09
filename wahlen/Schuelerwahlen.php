<div align="center">
<h1>Schülerwahlen</h1>
</div>
<br>
<?
	require ('ValUser.php');
	require('actionLog.php');

	$sql = "SELECT value FROM settings WHERE name = 'enable_schuelerwahlen' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result['value'] >= 1) {
		if($loggedin AND $rights >= 1) {
		
			if ($_POST['speichern']) {
				logAction($usrid, "Schuelerwahl gewaehlt. ID: ".$_POST['vote']);
			
				$votetransform_m = $_POST['vote'] * 2 - 1;
				$votetransform_w = $_POST['vote'] * 2;
				
				$sql1 = "DELETE FROM $database.voteStat WHERE voting = ".$usrid." AND voteid = ".$votetransform_m;
				$result1 = mysql_query($sql1);
				$sql2 = "DELETE FROM $database.voteStat WHERE voting = ".$usrid." AND voteid = ".$votetransform_w;
				$result2 = mysql_query($sql2);

				$sql3 = "INSERT INTO $database.voteStat (voteid,voting,voted) VALUES (".$votetransform_m.", ".$usrid.", ".$_POST['m'].' )';
				$result3 = mysql_query($sql3);
				$sql4 = "INSERT INTO $database.voteStat (voteid,voting,voted) VALUES (".$votetransform_w.", ".$usrid.", ".$_POST['w'].' )';
				$result4 = mysql_query($sql4);
				
				if ($result3 AND $result4) {
					$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Deine Änderungen wurden erfolgreich gespeichert</p></div>';
				}
				else {
					$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Deine Änderungen konnten leider nicht gespeichert werden</p></div>';
				}		
				echo $meldung;
			}
			
			$sql = "SELECT id, voteString FROM $database.voteList ORDER BY voteString";
			$query = mysql_query($sql);
			
			echo '<form method="post" name="voteselect" action="?s=wahlen/Schuelerwahlen.php"><fieldset>';
			echo '<div class="clearfix"><label style="width: 130px">Kategorie</label><div class="input" style="margin-left: 150px"><select class="xxlarge" id="vote" name="vote" onchange="document.voteselect.submit()"></div></div>';
			
			while ($result = mysql_fetch_array($query)) {
				echo '<option value="'.$result['id'].'" ';
				if ($_POST['vote'] == $result['id']) {
					echo 'selected="true"';
				}
				echo '>'.$result['voteString'].'</option>';
			}
			
			echo '</select></fieldset></form>';
			
			if(!$_POST['vote']) {
				$_POST['vote'] = 61;
			}

			echo '<span id="voteArea"><fieldset><form method="post" id="vote" action="?s=wahlen/Schuelerwahlen.php">';
			$sql4 = "SELECT voteString FROM voteList WHERE id = ".$_POST['vote']." LIMIT 1";
			$query4 = mysql_query($sql4);
			$result4 = mysql_fetch_array($query4);
			echo '<br><font size="4">'.$result4['voteString'].'</font><br><br>';
		
			//Wahl männlich
			echo '<div class="clearfix"><label style="width: 130px">Männlich</label><div class="input" style="margin-left: 150px"><select name="m">';
			$sql2 = "SELECT id, first_name, last_name FROM users WHERE geschlecht = 'm' AND visible = 1 AND rights <= 1 AND id <> ".$usrid." ORDER BY first_name ,last_name"; 
			$query2 = mysql_query($sql2);
			$voteid = (2 * $_POST['vote']) - 1;
		
			$sql5 = "SELECT voted FROM voteStat WHERE voteid = ".$voteid." AND voting = ".$usrid;
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
			echo '</select></div></div>';
		
			//Wahl weiblich
			echo '<div class="clearfix"><label style="width: 130px">Weiblich</label><div class="input" style="margin-left: 150px"><select name="w">';
			$sql6 = "SELECT id, first_name, last_name FROM $database.users WHERE geschlecht = 'w' AND visible = 1 AND rights <= 1 AND id <> ".$usrid." ORDER BY first_name, last_name"; 
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
			echo '</select></div></div>';
			echo '<input type="hidden" name="vote" value='.$_POST['vote'].'>';
			echo'<div class="actions"><input class="btn primary" name="speichern" type="submit" value="Speichern"></div>';
			echo '</form>';
			echo '</fieldset></span>';
		}
	} elseif ($result['value'] == 0){
		echo '<br><font size="5">Die Schülerwahlen sind beendet. Die Gewinner werden von uns benachrichtigt.</font>';
	} else {
		echo '<br><font size="5">Zurzeit sind die Schülerwahlen deaktiviert</font>';
	}
?>	
