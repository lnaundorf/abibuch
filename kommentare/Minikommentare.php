<div align="center">
<h1>Minikommentare</h1>
</div>

<?php
	require('ValUser.php');
	require('actionLog.php');

	$sql = "SELECT value FROM settings WHERE name = 'enable_shortcomments' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if($result['value'] >= 1) {	
	
		if ($loggedin AND $rights >= 1) {		
			echo '<div style="font-size: 14pt">Hier könnt ihr Minikommentare zu den einzelnen Leuten schreiben, die unten auf deren Seite stehen. Diese dürfen die Länge von 140 Zeichen nicht überschreiten.<br><br>';
			echo '<font color="red">Schreibt bitte nur nette Kommentare. Fiese Kommentare werden von uns gelöscht</font></div><br><br>';
			
			
			$sql = "SELECT value FROM settings WHERE name = 'minicomments_show_bottom' LIMIT 1";
			$value = mysql_fetch_array(mysql_query($sql));
			
			if ($value['value'] != 0) {
				echo '<h4>Wir bitten insbesondere noch um Minikommentare zu:</h4>';
				//$sql = "SELECT DISTINCT nach, count(nach) AS count_nach FROM $database.comments GROUP BY nach ORDER BY count_nach LIMIT ".$value['value'];
				//$sql = "SELECT U.id, IFNULL(C.count_nach, 0) AS count_nach FROM $database.users as U LEFT JOIN (SELECT DISTINCT nach, count(nach) AS count_nach FROM $database.comments GROUP BY nach) AS C ON U.id = C.nach WHERE U.rights <= 1 ORDER BY C.count_nach LIMIT ".$value['value'];
				//$sql = "SELECT A.id, A.count_nach FROM (SELECT U.id, IFNULL(C.count_nach, 0) AS count_nach FROM $database.users as U LEFT JOIN (SELECT DISTINCT nach, count(nach) AS count_nach FROM $database.comments GROUP BY nach) AS C ON U.id = C.nach WHERE (U.rights <= 1 AND U.visible = 1) ORDER BY C.count_nach LIMIT ".$value['value'].") AS A ORDER BY RAND()";
				$sql = "SELECT A.id, A.count_nach, U.first_name, U.last_name FROM (SELECT U.id AS id, IFNULL(C.count_nach, 0) AS count_nach FROM users as U LEFT JOIN (SELECT DISTINCT nach, count(nach) AS count_nach FROM comments GROUP BY nach) AS C ON U.id = C.nach WHERE (U.rights <= 1 AND U.visible = 1) ORDER BY C.count_nach LIMIT ".$value['value'].") AS A LEFT JOIN users AS U ON U.id = A.id ORDER BY first_name, last_name";
				
				//$sql = "SELECT count(DISTINCT(nach)) AS count_nach, nach FROM $database.comments GROUP BY nach ORDER by count_nach LIMIT ".$value['value'];
				$query = mysql_query($sql);
				
				while ($result = mysql_fetch_array($query)) {
					echo $result['first_name']."&nbsp;".$result['last_name'].", ";
				}
				
				echo '<br><br>';
			}
				
			 if ($_POST['sent'] == 1){
			 
				$message = mysql_real_escape_string($_POST['message']);
				
				if ($message == ''){
					//BÖSE
					$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar darf nicht leer sein</p></div>';
				} else {
					 if ($_POST['befehl'] == "create"){
						logAction($usrid, "Minikommentar geschrieben an: ".$_POST['id']);
						 $sql="INSERT INTO comments (von, nach, text) VALUES (";
						 $sql.=$usrid.", ";
						 $sql.= $_POST['id'].", ";
						 $sql.= "'".$message."'".")";
						 $result = mysql_query($sql);
						 if (!$result) {
							$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht gespeichert werden</p></div>';
						 } else {
							$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde gespeichert</p></div>';
						 }
					 } elseif ($_POST['befehl'] == "alter"){
						logAction($usrid, "Minikommentar bearbeitet an: ".$_POST['komID']);
						
						 $sql="UPDATE $database.comments SET text='".$message."', fies = 0, nett = 0 WHERE nach = ".$_POST['komID'].' AND von = '.$usrid.' LIMIT 1';
						 $result = mysql_query($sql);
						 if (!$result) {
							$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht geändert werden</p></div>';
						 } else {
							$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde geändert</p></div>';
						 }
					 } elseif ($_POST['befehl'] == "delete"){
						 $sql = "DELETE FROM comments WHERE nach = ".$_POST['komID'].' AND von = '.$usrid." LIMIT 1";
						 $result = mysql_query($sql);
						 if (!$result) {
							$meldung = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Der Kommentar konnte nicht gelöscht werden</p></div>';
						 } else {
							$meldung = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Der Kommentar wurde gelöscht</p></div>';
							logAction($usrid, "Minikommentar gelöscht an: ".$_POST['komID']);
						 }
					 }
				}
				echo $meldung;
			}
			if ($_POST['edit']){
				echo "<h2>Einen Kommentar bearbeiten</h2>\n";
				echo "<form name=\"comment\" action=\"?s=kommentare/Minikommentare.php\" method=\"post\" onsubmit=\"return checkCommentSubmit()\"><fieldset>";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"komID\" value=\"".$_POST['id']."\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"alter\">\n";
				$sql_user = "SELECT nach, text FROM comments WHERE nach = ".$_POST['id']." AND von = ".$usrid." LIMIT 1";
				$query_user = mysql_query($sql_user);
				$result = mysql_fetch_array($query_user);
				echo '<div class="clearfix"><label style="width: 130px">Kommentar zu:</label><div class="input" style="margin-left: 150px"><span class="uneditable-input">';
				$sql = "SELECT first_name, last_name FROM users WHERE id = ".$_POST['id']." LIMIT 1";
				$query = mysql_query($sql);
				$userdata = mysql_fetch_row($query);
				echo $userdata[0]." ".$userdata[1].'</span></div></div>';
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea name="message" cols="35"  rows="5" onkeyup="check()">'.$result['text'].'</textarea><span class="help-block" id="counter"><strong>';
				$textlength = 140 - strlen(utf8_decode($result['text']));
				if ($textlength <= 20) echo "<font color=\"red\">";
				echo "Zeichen verbleibend: ".$textlength;
				if ($textlength <= 20) echo "</font>";
				echo '</strong></span></div></div><div class="actions" style="padding-left: 150px"><input class="btn primary" type="submit" value="Speichern"></div>';
				echo "</fieldset></form>\n";
				unset ($userdata);
			} elseif ($_POST['delete']){
				echo "<h2>Eine Kommentar löschen</h2>\n";
				echo '<font color="red" size="3">Klicke unten auf "Löschen", wenn du diesen  Minikommentar wirklich löschen willst.</font><br><br>';
				echo "<form action=\"?s=kommentare/Minikommentare.php\" method=\"post\"><fieldset>\n";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"komID\" value=\"".$_POST['id']."\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"delete\">\n";
				$sql = "SELECT nach, text FROM comments WHERE nach=".$_POST['id']." AND von = ".$usrid;
				$query = mysql_query($sql);
				$result = mysql_fetch_row($query);
				echo '<div class="clearfix"><label style="width: 130px">Kommentar zu:</label><div class="input" style="margin-left: 150px"><span class="uneditable-input">';
				$sql2 = "SELECT first_name, last_name FROM $database.users WHERE id=".$_POST['id']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$userdata = mysql_fetch_array($query2);
				echo $userdata['first_name']." ".$userdata['last_name']."</span></div></div>\n";
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea name="message" cols="30"  rows="4" readonly>'.$result[1].'</textarea></div></div>';
				echo '<div class="actions" style="padding-left: 150px"><input class="btn danger" type="submit" value="Löschen"></div>';
				echo "</fieldset></form>\n";
				unset ($userdata);
			} else {
				echo "<h2>Einen neuen Kommentar verfassen</h2>\n";
				echo "<form name=\"comment\" action=\"?s=kommentare/Minikommentare.php\" method=\"post\" onsubmit=\"return checkCommentSubmit()\"><fieldset>\n";
				echo "<input type=\"hidden\" name=\"sent\" value=\"1\">\n";
				echo "<input type=\"hidden\" name=\"befehl\" value=\"create\">\n";
				echo '<div class="clearfix"><label style="width: 130px">Kommentar zu:</label><div class="input" style="margin-left: 150px"><select name="id">';
				$sql = 'SELECT id, first_name, last_name FROM users WHERE id <> '.$usrid.' AND visible = 1 AND rights <= 1 ORDER BY first_name, last_name';
				$query = mysql_query($sql);

				while($result = mysql_fetch_row($query)) {
					$id = $result[0];

					$sql2 = "SELECT text FROM comments WHERE nach = ".$id." AND von = ".$usrid." LIMIT 1";
					$query2 = mysql_query($sql2);
					$text = mysql_fetch_array($query2);

					if ($text['text'] == '') {
						echo "\n<option value=\"".$result[0]."\">".$result[1]." ".$result[2]."</option>";
					}
				}
				echo "\n</select></div></div>\n";
				echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea class="xlarge" name="message" cols="50"  rows="4" onkeyup="check()"></textarea><span class="help-block" id="counter"><strong>Zeichen verbleibend: 140</strong></span></div></div>';
				echo '<div class="actions" style="padding-left: 150px"><input class="btn primary" type="submit" value="Speichern">';
				echo "</fieldset></form>\n";
			}
		}
	} elseif($result['value'] == 0) {
		echo '<br><br><font size="5" color="red">Es ist leider nicht mehr möglich Minikommentare zu schreiben und zu verändern.</font>';
	} else {
		echo '<br><font size="5">Zurzeit sind die Minikommentare deaktiviert</font>';
	}
	
	if ($loggedin AND $rights >= 1) {
		$sql = "SELECT von, nach, text FROM comments WHERE von = ".$usrid;
		$query = mysql_query($sql);
		
		if (mysql_num_rows($query) != 0){
			echo "<h2>Geschriebene Kommentare</h2>\n";
			
			while($result = mysql_fetch_row($query)) {

			echo "Kommentar zu: ";
			$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$result[1]." LIMIT 1";
			$query2 = mysql_query($sql2);
			$userdata = mysql_fetch_array($query2);
			echo $userdata['first_name']." ".$userdata['last_name']."<br>\n";
			echo "<textarea name=\"message\" cols=\"35\"  rows=\"5\" readonly>".$result[2]."</textarea><br>\n";
			echo "<form action=\"?s=kommentare/Minikommentare.php\" method=\"post\">\n";
			echo '<input type="hidden" name="id" value = '.$result[1].'>';
			echo '<input class="btn info" type="submit" name="edit" value="bearbeiten">';
			echo '<input style="margin-left: 15px" class="btn danger" type="submit" name="delete" value="löschen">';
			echo "</form>";
			}
		}
	}
?>
