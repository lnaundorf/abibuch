<div align="center">
<h1>Lehrerwahlen</h1>
</div>
<br>
<?
	require('ValUser.php');
	require('actionLog.php');
	
	$sql = "SELECT value FROM settings WHERE name = 'enable_lehrerwahlen' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result['value'] >= 1) {
		if ($loggedin AND $rights >= 1) {
				if ($_POST['speichern']) {
					$voteID = mysql_real_escape_string($_POST['vote']);
					
					logAction($usrid, "Lehrerwahl gewaehlt. VoteID: ".$voteID);
					
					$votetransform_m = $voteID * 2 - 1;
					$votetransform_w = $voteID * 2;
					
					$lehrerchoice_m = mysql_real_escape_string($_POST['lehrerchoice_m']);
					$lehrerchoice_w = mysql_real_escape_string($_POST['lehrerchoice_w']);
					
					$aktualisiert = false;
					$fehler = false;
					
					//Männlich einfügen
					$sql3 = "SELECT lehrer FROM lehrerVoteStat WHERE von = ".$usrid." AND voteId = ".$votetransform_m." LIMIT 1";
					$query3 = mysql_query($sql3);
					
					$vote = mysql_fetch_array($query3);
					
					if ($vote['lehrer'] != $lehrerchoice_m) {	
						$sql = "UPDATE lehrerVoteStat SET lehrer = ".$lehrerchoice_m." WHERE von = ".$usrid." AND voteId = ".$votetransform_m." LIMIT 1";
						$query = mysql_query($sql);
					
						if (mysql_affected_rows() == 1) {
							$aktualisiert = true;
						} else if (mysql_affected_rows() == 0) {
							$sql2 = "INSERT INTO lehrerVoteStat (voteId, von, lehrer) VALUES ('".$votetransform_m."', '".$usrid."', '".$lehrerchoice_m."')";
							$result = mysql_query($sql2);
							if ($result) {
								$aktualisiert = true;
							} else {
								$fehler = true;
							}
						} else {
							$fehler = true;
						}
					}
					
					//weiblich einfügen
					$sql3 = "SELECT lehrer FROM lehrerVoteStat WHERE von = ".$usrid." AND voteId = ".$votetransform_w." LIMIT 1";
					$query3 = mysql_query($sql3);
					
					$vote = mysql_fetch_array($query3);
					
					if ($vote['lehrer'] != $lehrerchoice_w) {
						$sql = "UPDATE lehrerVoteStat SET lehrer = ".$lehrerchoice_w." WHERE von = ".$usrid." AND voteId = ".$votetransform_w." LIMIT 1";
						$query = mysql_query($sql);
					
						if (mysql_affected_rows() == 1) {
							$aktualisiert = true;
						} elseif (mysql_affected_rows() == 0) {
							$sql2 = "INSERT INTO lehrerVoteStat (voteId, von, lehrer) VALUES ('".$votetransform_w."', '".$usrid."', '".$lehrerchoice_w."')";
							$result = mysql_query($sql2);
							if ($result) {
								$aktualisiert = true;
							} else {
								$fehler = true;
							}
						} else {
							$fehler = true;
						}
					}
					
					if ($aktualisiert AND !$fehler) {
						echo '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Deine Wahl wurde erfolgreich aktualisiert</p></div>';
					} elseif (!$fehler) {
						echo '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Du hast an deiner Wahl nichts geändert</p></div>';
					} else {
						echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Es ist ein Fehler aufgetreten</p></div>';
					}
				}
				
				$sql = "SELECT id, voteString FROM lehrerVoteList ORDER BY voteString";
				$query = mysql_query($sql);
			
				echo '<form method="post" name="voteselect" action="?s=wahlen/Lehrerwahlen.php"><fieldset>';
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

			echo '<form method="post" action="?s=wahlen/Lehrerwahlen.php"><span id="voteArea"><fieldset>';
		
			$votetransform_m = $_POST['vote'] * 2 - 1;
			$votetransform_w = $_POST['vote'] * 2;
			
			$sql4 = "SELECT voteString FROM lehrerVoteList WHERE id = ".$_POST['vote']." LIMIT 1";
			$query4 = mysql_query($sql4);
			$result4 = mysql_fetch_array($query4);
			echo '<br><font size="4">'.$result4['voteString'].'</font><br><br>';
			
			//wahl männlich
			echo '<div class="clearfix"><label style="width: 130px">Männlich </label><div class="input" style="margin-left: 150px"><select name="lehrerchoice_m">';
			$sql2 = "SELECT id, name FROM lehrer WHERE geschlecht = 'm' ORDER BY name"; 
			$query2 = mysql_query($sql2);
				
			$sql5 = "SELECT lehrer FROM lehrerVoteStat WHERE voteid = ".$votetransform_m." AND von = ".$usrid." LIMIT 1";
			$query5 = mysql_query($sql5);
			$result5 = mysql_fetch_array($query5);
			
			echo '<option value="0" ';
			if ($result5['lehrer'] == 0) {
				echo 'selected="true"';
			}

			echo '>&nbsp;</option>';
			while ($name = mysql_fetch_array($query2)) {
				echo '<option value="'.$name['id'].'"';
				if ($name['id'] == $result5['lehrer']) {
					echo ' selected="true"';
				}
			
				echo '>';
				echo 'Herr '.$name['name'].'</option>';
			}
			echo '</select></div></div>';
			
			//wahl weiblich
			echo '<div class="clearfix"><label style="width: 130px">Weiblich </label><div class="input" style="margin-left: 150px"><select name="lehrerchoice_w">';
			$sql2 = "SELECT id, name FROM lehrer WHERE geschlecht = 'w' ORDER BY name"; 
			$query2 = mysql_query($sql2);
				
			$sql5 = "SELECT lehrer FROM lehrerVoteStat WHERE voteid = ".$votetransform_w." AND von = ".$usrid." LIMIT 1";
			$query5 = mysql_query($sql5);
			$result5 = mysql_fetch_array($query5);
			
			echo '<option value="0" ';
			if ($result5['lehrer'] == 0) {
				echo 'selected="true"';
			}

			echo '>&nbsp;</option>';
			while ($name = mysql_fetch_array($query2)) {
				echo '<option value="'.$name['id'].'"';
				if ($name['id'] == $result5['lehrer']) {
					echo ' selected="true"';
				}
			
				echo '>';
				echo 'Frau '.$name['name'].'</option>';
			}
			echo '</select></div></div>';
			echo '<input type="hidden" name="vote" value='.$_POST['vote'].'>';
			echo'<div class="actions"><input class="btn primary" name="speichern" type="submit" value="Speichern"></div>';
			echo '</fieldset></span></form>';
		}
	} elseif ($result['value'] == 0) {
		echo '<br><font size="5">Die Lehrerwahlen sind beendet</font>';
	} else {
		echo '<br><font size="5">Zurzeit sind die Lehrerwahlen deaktiviert</font>';
	}
?>
