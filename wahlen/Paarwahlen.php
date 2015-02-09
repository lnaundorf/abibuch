<div align="center">
<h1>Paarwahlen</h1>
<br>
</div>
<?
	require('ValUser.php');
	require('actionLog.php');
	
	$sql = "SELECT value FROM settings WHERE name = 'enable_paarwahlen' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result['value'] >= 1) {
		if ($loggedin AND $rights >= 1) {
			if ($_POST['speichern']) {
				logAction($usrid, "Paarwahl gewaehlt. ID: ".$_POST['vote']);
				$postm = mysql_real_escape_string($_POST['m']);
				$postw = mysql_real_escape_string($_POST['w']);
				$postvote = mysql_real_escape_string($_POST['vote']);
			
				$sql_m = "SELECT first_name, last_name FROM users WHERE id = ".$postm." LIMIT 1";
				$query_m = mysql_query($sql_m);
				$m = mysql_fetch_array($query_m);
				
				$sql_w = "SELECT first_name, last_name FROM users WHERE id = ".$postw." LIMIT 1";
				$query_w = mysql_query($sql_w);
				$w = mysql_fetch_array($query_w);
				
				$sql1 = "DELETE FROM paarVoteStat WHERE voting = ".$usrid." AND voteId = ".$postvote;
				$result1 = mysql_query($sql1);

				$sql3 = "INSERT INTO paarVoteStat (voteId,voting,wahl_m,wahl_w,voteString) VALUES (".$postvote.", ".$usrid.", ".$postm.", ".$postw.", '".$m['first_name']." ".$m['last_name']." & ".$w['first_name']." ".$w['last_name']."')";
				$result3 = mysql_query($sql3);
				
				if ($result3) {
					$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Deine Änderungen wurden erfolgreich gespeichert</p></div>';
				}
				else {
					$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Deine Änderungen konnten leider nicht gespeichert werden</p></div>';
				}		
				echo $meldung;
			}
				
			$sql = "SELECT id, voteString FROM paarVoteList ORDER BY voteString";
			$query = mysql_query($sql);
		
			echo '<form method="post" name="voteselect" action="?s=wahlen/Paarwahlen.php"><fieldset>';
			echo '<div class="clearfix"><label style="width: 130px">Kategorie</label><div class="input" style="margin-left: 150px"><select class="xlarge" name="vote" onchange="document.voteselect.submit()">';
		
			while ($result = mysql_fetch_array($query)) {
				echo '<option value="'.$result['id'].'" ';
				if ($_POST['vote'] == $result['id']) {
					echo 'selected="true"';
				}
				echo '>'.$result['voteString'].'</option>';
			}
		
			echo '</select></div></div></fieldset></form>';
			
			if(!$_POST['vote']) {
				$_POST['vote'] = 1;
			}

			echo '<span id="voteArea"><fieldset><form method="post" action="?s=wahlen/Paarwahlen.php">';
			$sql4 = "SELECT id, voteString, type1, type2 FROM paarVoteList WHERE id = ".$_POST['vote']." LIMIT 1";
			$query4 = mysql_query($sql4);
			$result4 = mysql_fetch_array($query4);
			echo '<br><font size="4">'.$result4['voteString'].'</font><br><br>';
			
			if($result4['type1'] == 'm' && $result4['type2'] == 'w') {
				$firstName = "Männlich";
				$secondName = "Weiblich";
			} /*elseif($result4['type1'] == $result4['type2'])*/else {
				$firstName = '1. Person';
				$secondName = '2. Person';
			}
			
			if($result4['type1'] == "m") {
				$mod1 = " AND geschlecht = 'm'";
			} elseif($result4['type1'] == "w") {
				$mod1 = " AND geschlecht = 'w'";
			} else {
				$mod1 = "";
			}
			
			if($result4['type2'] == "m") {
				$mod2 = " AND geschlecht = 'm'";
			} elseif($result4['type2'] == "w") {
				$mod2 = " AND geschlecht = 'w'";
			} else {
				$mod2 = "";
			}
			
			//Wahl 1. Person
			echo '<div class="clearfix"><label style="width: 130px">'.$firstName.'</label><div class="input" style="margin-left: 150px"><select name="m">';
			$sql2 = "SELECT id, first_name, last_name FROM users WHERE visible = 1".$mod1." AND rights <= 1 AND id <> ".$usrid." ORDER BY first_name, last_name"; 
			$query2 = mysql_query($sql2);
		
			$sql5 = "SELECT wahl_m FROM paarVoteStat WHERE voteId = ".$_POST['vote']." AND voting = ".$usrid;
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
		
			//Wahl 2. Person
			echo '<div class="clearfix"><label style="width: 130px">'.$secondName.'</label><div class="input" style="margin-left: 150px"><select name="w">';
			$sql6 = "SELECT id, first_name, last_name FROM users WHERE visible = 1".$mod2." AND rights <= 1 AND id <> ".$usrid." ORDER BY first_name, last_name"; 
			$query6 = mysql_query($sql6);
		
		
			$sql7 = "SELECT wahl_w FROM paarVoteStat WHERE voteId = ".$_POST['vote']." AND voting = ".$usrid;
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
	} elseif($result['value'] == 0) {
		echo '<br><font size="5">Die Paarwahlen sind beendet. Die Gewinner werden von uns benachrichtigt.</font>';
	} else {
		echo '<br><font size="5">Zurzeit sind die Paarwahlen deaktiviert</font>';
	}
?>
