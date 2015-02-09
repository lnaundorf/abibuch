<div align="center">
<h1>Steckbrief</h1>
</div>
<?

require ('ValUser.php');
require('actionLog.php');

/*
if($_POST['submit']) {
	logAction($usrid, "Steckbrief aktualisiert");
	$allgood = true;
	
	foreach ($_POST as $postname => $postvar) {
		if ($postname != 'submit') {
			$postvarNEW = mysql_real_escape_string($postvar);
			$postnameNEW = mysql_real_escape_string($postname);
			
			$sql = "SELECT id FROM steckbriefStat WHERE userID = ".$usrid." AND type = ".$postnameNEW." LIMIT 1";
			
			if (mysql_num_rows(mysql_query($sql)) == 1) {
				//update entry in database
				$sql = "UPDATE steckbriefStat SET value = '".$postvarNEW."' WHERE userID = ".$usrid." AND type = ".$postnameNEW." LIMIT 1";
				$result = mysql_query($sql);
				if(!$result) {
					$allgood = false;
				}
			} else {
				//insert new entry in database
				$sql = "INSERT INTO steckbriefStat (userID, type, value) VALUES (".$usrid.", ".$postnameNEW.", '".$postvarNEW."')";
				$result = mysql_query($sql);
				if (!$result) {
					$allgood = false;
				}
			}
		}
	}
	
	if ($allgood) {
		$message = '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Deine daten wurden erfolgreich aktualisiert</p></div>';
	} else {
		$message = '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Beim Aktualisieren deiner Daten ist ein Fehler aufgetreten</p></div>';
	}
}
*/

if ($loggedin and $rights >= 1) {

	/*echo $message.'<br><br><form method="post" action="?s=public_contents/Steckbrief.php">';*/
	
	$sql = "SELECT first_name, last_name FROM users WHERE id = ".$usrid." LIMIT 1";
	$query = mysql_query($sql);
	$name = mysql_fetch_array($query);
	echo '<form><fieldset><div class="clearfix"><label>Vorname: </label><div class="input"><span class="uneditable-input">'.$name['first_name'].'</span></div></div>';
	echo '<div class="clearfix"><label>Nachname: </label><div class="input"><span class="uneditable-input">'.$name['last_name'].'</span></div></div>';
	echo '<br>';
	echo '<div class="row"><div class="span10 columns offset3" style="font-size:9pt; line-height: 150%"><strong>Hinweis: Falls du unter anderem Namen wählbar und im Abibuch stehen willst, sag uns Bescheid<br>über das <a href="javascript:loadContent(\'Kontakt.php\')">Kontaktformular</a> oder wende dich an jemandem aus dem Abibuch Komitee</strong></div></div></fieldset></form>';
	echo '<br><br><div class="row"><div class="span16 columns offset3" style="font-size: 14pt; line-height: 150%">Bitte schickt eure Steckbriefe/Profile als Word- oder Openoffice-Datei per Mail an <a href="mailto:abibuch.aks@gmx.de">abibuch.aks@gmx.de</a>.</div></div>';
	/*echo '<fieldset><legend>Pflichtfelder:</legend>';
	$sql = "SELECT id, name FROM steckbriefList WHERE type = 0 ORDER BY reihenfolge";
	$query = mysql_query($sql);
	
	while ($eintrag = mysql_fetch_array($query)) {
		$sql2 = "SELECT value FROM steckbriefStat WHERE userID = ".$usrid." AND type = ".$eintrag['id']." LIMIT 1";
		$query2 = mysql_query($sql2);
		$value = mysql_fetch_array($query2);
		
		echo "<div class='clearfix'><label for='".$eintrag['id']."'>".$eintrag['name'].": </label><div class='input'><input size='30' name=\"".$eintrag['id']."\" value=\"".$value['value']."\" type=\"text\" class='xlarge'></div></div>";
	}
	
	echo '</fieldset><br><br><fieldset><legend>Optionale Felder. Fülle bitte bis zu acht der folgenden Felder aus:</legend>';
	$sql = "SELECT id, name FROM steckbriefList WHERE type = 1 ORDER BY reihenfolge";
	$query = mysql_query($sql);
	
	while ($eintrag = mysql_fetch_array($query)) {
		$sql2 = "SELECT value FROM steckbriefStat WHERE userID = ".$usrid." AND type = ".$eintrag['id']." LIMIT 1";
		$query2 = mysql_query($sql2);
		$value = mysql_fetch_array($query2);
		
		echo "<div class='clearfix'><label for='".$eintrag['id']."'>".$eintrag['name'].": </label><div class='input'><input class='xlarge' size='30' id=\"".$eintrag['id']."\" name=\"".$eintrag['id']."\" value=\"".$value['value']."\" type=\"text\"></div></div>";
	}
	
	echo '</fieldset><div class="actions" style="padding-left: 270px"><input class="btn primary" name="submit" type="submit" value="Speichern"></div>';
	//echo '<font color="red" size="5">Es ist leider nicht mehr möglich, deinen Steckbrief zu verändern. Wenn du unbedingt noch etwas ändern willst, wende dich an das Komitee</font>';
	echo '</form>';*/
}
?>
