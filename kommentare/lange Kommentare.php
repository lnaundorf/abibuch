<div align="center">
<h1>lange Kommentare</h1>
</div>

<?php
	require ('ValUser.php');
	require('actionLog.php');

	$sql = "SELECT value FROM settings WHERE name = 'enable_longcomments' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result['value'] >= 1) {
		if ($loggedin AND $rights >= 1) {	
			echo '<div style="font-size: 14pt; line-height: 125%">Hier könnt ihr lange Kommentare an die einzelnen Leuten schreiben. Diese dürfen beliebig lang sein. 
			Falls mehrere Leute zu einer Person einen langen Kommentar gemeinsam schreiben wollen, schickt einer den Kommentar hier ab und trägt in 
			das "Kommentar von"-Feld die vollständigen Namen der anderen mitschreibenden Personen ein. Falls Leute, die nicht in der Stufe sind, 
			lange Kommentare schreiben wollen, sollen sie bitte das Abibuch Komitee <a href="javascript:loadContent(\'Kontakt.php\')">kontaktieren</a>.
			<br><br>Wir empfehlen, dass ihr am besten die Kommentare auf eurem Computer schreibt (Word, etc.) und dann hier reinkopiert.</div><br>';
			
			
			$sql = "SELECT value FROM settings WHERE name = 'longcomments_show_bottom' LIMIT 1";
			$value = mysql_fetch_array(mysql_query($sql));
			
			if($value['value'] != 0) {
				echo '<h4>Wir bitten insbesondere noch um lange Kommentare an:</h4>';
				
				//$sql = "SELECT DISTINCT nach, count(nach) AS count_nach FROM $database.longcomments GROUP BY nach ORDER BY count_nach LIMIT ".$value['value'];
				$sql = "SELECT A.id, A.count_nach FROM (SELECT U.id, IFNULL(C.count_nach, 0) AS count_nach FROM users as U LEFT JOIN (SELECT DISTINCT nach, count(nach) AS count_nach FROM longcomments GROUP BY nach) AS C ON U.id = C.nach WHERE (U.rights <= 1 AND U.visible = 1) ORDER BY C.count_nach LIMIT ".$value['value'].") AS A ORDER BY RAND()";
				$query = mysql_query($sql);
				
				while ($result = mysql_fetch_array($query)) {
					$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$result['id']." LIMIT 1";
					$query2 = mysql_query($sql2);
					$user = mysql_fetch_array($query2);
					echo $user['first_name']."&nbsp;".$user['last_name'].", ";
				}
				
				echo '<br><br>';
			}
				
			 if ($_POST['sent'] == 1) {
				
				$message = mysql_real_escape_string($_POST['message']);
				
				if ($message == ''){
					//BÖSE
					$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar darf nicht leer sein</p></div>';
				} else {
					 if ($_POST['befehl'] == "create"){
						logAction($usrid, "langer Kommentar geschrieben an: ".$_POST['id']);
						
						$id = mysql_real_escape_string($_POST['id']);
						$vonName = mysql_real_escape_string($_POST['vonName']);
						
						 $sql="INSERT INTO longcomments (vonID, nach, vonName, text) VALUES (".$usrid.", ".$id.", '".$vonName."', '".$message."')";
						 $result = mysql_query($sql);
						 if (!$result) {
							$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht gespeichert werden</p></div>';
						 } else {
							$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde gespeichert</p></div>';
						 }
					 } elseif ($_POST['befehl'] == "alter"){
						logAction($usrid, "langer Kommentar bearbeitet an: ".$_POST['komID']);
						
						$vonName = mysql_real_escape_string($_POST['vonName']);
						$komID = mysql_real_escape_string($_POST['komID']);
						
						 $sql="UPDATE longcomments SET text='".$message."', vonName = '".$vonName."' WHERE nach = ".$komID.' AND vonID = '.$usrid." LIMIT 1";
						 $result = mysql_query($sql);
						 if (!$result) {
							$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht geändert werden</p></div>';
						 } else {
							$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde geändert</p></div>';
						 }
					 } elseif ($_POST['befehl'] == "delete"){
					 
						$komID = mysql_real_escape_string($_POST['komID']);
						
						logAction($usrid, "langer Kommentar geloescht an: ".$komID);
						
						 $sql="DELETE FROM longcomments WHERE nach = ".$komID.' AND vonID = '.$usrid.' LIMIT 1';
						 $result = mysql_query($sql);
						 if (!$result) {
								 $meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht gelöscht werden</p></div>';
						 } else {
								 $meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde gelöscht</p></div>';
						 }
					 }
				}
				echo $meldung;
			}
			if ($_POST['edit']){
				echo "<h2>Einen langen Kommentar verändern</h2>\n";
				echo "<form name=\"comment\" action=\"?s=kommentare/lange Kommentare.php\" method=\"post\"><fieldset>\n";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"komID\" value=\"".$_POST['id']."\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"alter\">\n";
				$sql_user = "SELECT vonName, nach, text FROM longcomments WHERE nach = ".$_POST['id']." AND vonID = ".$usrid." LIMIT 1";
				$query_user = mysql_query($sql_user);
				$result = mysql_fetch_array($query_user);
				echo '<div class="clearfix"><label style="width: 130px">Kommentar An:</label><div class="input" style="margin-left: 150px"><span class="uneditable-input">';
				$sql = "SELECT first_name, last_name FROM users WHERE id = ".$_POST['id'];
				$query = mysql_query($sql);
				$userdata = mysql_fetch_array($query);
				echo $userdata['first_name']." ".$userdata['last_name']."</span></div></div>\n";
				echo '<div class="clearfix"><label style="width: 130px">Kommentar von:</label><div class="input" style="margin-left: 150px"><input type="text" name="vonName" value="'.$result['vonName'].'" maxlength="80"></div></div>';
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea class="xxlarge" name="message" rows="20">'.$result['text']."</textarea></div></div>\n";
				echo '<div class="actions" style="padding-left: 150px"><input class="btn primary" type="submit" value="Speichern">';
				echo "</fieldset></form>\n";
			} elseif ($_POST['delete']){
				echo "<h2>Einen langen Kommentar löschen</h2>\n";
				echo '<font color="red" size="3">Klicke unten auf "Löschen", wenn du diesen  langen Kommentar wirklich löschen willst.</font><br><br>';
				echo "<form action=\"?s=kommentare/lange Kommentare.php\" method=\"post\"><fieldset>\n";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"komID\" value=\"".$_POST['id']."\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"delete\">\n";
				$sql = "SELECT vonName, text FROM longcomments WHERE nach = ".$_POST['id']." AND vonID = ".$usrid." LIMIT 1";
				$query = mysql_query($sql);
				$result = mysql_fetch_row($query);
				echo '<div class="clearfix"><label style="width: 130px">Kommentar zu:</label><div class="input" style="margin-left: 150px"><span class="uneditable-input">';
				$sql2 = "SELECT first_name, last_name FROM users WHERE id=".$_POST['id']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$userdata = mysql_fetch_array($query2);
				echo $userdata['first_name']." ".$userdata['last_name']."</span></div></div>\n";
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea name="message" class="xxlarge" rows="20" readonly>'.$result[1].'</textarea></div></div>';
				echo '<div class="actions" style="padding-left: 150px"><input class="btn danger" type="submit" value="Löschen"></div>';
				echo "</fieldset></form>\n";
				unset ($userdata);
			} else {
				$sql = "SELECT first_name, last_name FROM users WHERE id = ".$usrid." LIMIT 1";
				$query = mysql_query($sql);
				$user = mysql_fetch_array($query);
			
				echo "<h2>Einen neuen langen Kommentar verfassen</h2>\n";
				echo "<form name=\"comment\" action=\"?s=kommentare/lange Kommentare.php\" method=\"post\"><fieldset>";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"create\">\n";
				echo '<div class="clearfix"><label style="width: 130px">Kommentar An:</label><div class="input" style="margin-left: 150px"><select name="id">';
				$sql = 'SELECT id, first_name, last_name FROM users WHERE id <> '.$usrid.' AND visible = 1 AND rights <= 1 ORDER BY first_name, last_name';
				$query = mysql_query($sql);

				while($result = mysql_fetch_array($query)) {
					$id = $result['id'];

					$sql2 = "SELECT text FROM longcomments WHERE nach = ".$id." AND vonID = ".$usrid." LIMIT 1";
					$query2 = mysql_query($sql2);
					$text = mysql_fetch_array($query2);

					if ($text['text'] == '') {
						echo "\n<option value=\"".$result['id']."\">";
						echo $result['first_name']." ".$result['last_name'];
						echo "</option>";
					}
				}
				echo "\n</select></div></div><br>\n";
				echo '<div class="clearfix"><label style="width: 130px">Kommentar von:</label><div class="input" style="margin-left: 150px"><input type="text" name="vonName" value="'.$user['first_name'].' '.$user['last_name'].'" maxlength="80"></div></div>';
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea class="xxlarge" name="message" rows="20" onkeyup="check()"></textarea></div></div>';
				echo '<div class="actions" style="padding-left: 150px"><input class="btn primary" type="submit" value="Speichern">';
				echo "</fieldset></form>\n";
			}
		}
	} elseif ($result['value'] == 0) {
		echo '<br><br><font size="5" color="red">Es ist leider nicht mehr möglich lange Kommentare zu schreiben und zu verändern.</font>';
	} else {
		echo '<br><font size="5">Zurzeit sind die langen Kommentare deaktiviert</font>';
	}
	
	if($loggedin AND $rights >= 1) {
		$sql = "SELECT vonName, nach, text FROM longcomments WHERE vonID = ".$usrid;
		$query = mysql_query($sql);
		
		if (mysql_num_rows($query) != 0) {
			echo "<h2>Geschriebene Kommentare</h2>\n";
			
			while($result = mysql_fetch_array($query)) {
			
				echo 'Kommentar von: '.$result['vonName'].'<br>';
				echo "Kommentar An: ";
				$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$result['nach']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$userdata = mysql_fetch_array($query2);
				echo $userdata['first_name']." ".$userdata['last_name']."<br>\n";
				echo '<textarea name="message" class="xlarge"  rows="10" readonly>'.$result['text'].'</textarea><br>';
				echo "<form action=\"?s=kommentare/lange Kommentare.php\" method=\"post\">\n";
				echo '<input type="hidden" name="id" value = '.$result['nach'].'>';
				echo '<input class="btn info" type="submit" name="edit" value="bearbeiten">';
				echo '<input class="btn danger" style="margin-left: 15px" type="submit" name="delete" value="löschen">';

				echo "</form>";
			}
		}
	}
?>
