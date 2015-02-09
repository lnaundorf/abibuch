<div align="center">
<h1>Gesamtübersicht</h1>
</div>
<?
require('ValUser.php');
	
if ($loggedin AND $rights >= 1) {
	//Bilder
	echo '<h2>Bilder</h2>';
	
	//echo '<div class="row" style="margin-bottom: -50px"><div class="span7">';
	echo 'Dein zurzeit gewähltes Babybild: <br>';
	if ($baby_status >= 1) {
		echo '<img src=imageloader.php?type=1&id='.$usrid.'&size=small width=400>';
	} else {
		echo '<font color="red" size="4">Du hast bisher noch kein Babybild hochgeladen</font>';
	}
	
	//echo '</div><div class="span7 offset1">';
	echo '<br><br><br>Dein zurzeit gewähltes aktuelles Bild: <br>';
	if ($jetzt_status >= 1) {
		echo '<img src=imageloader.php?type=2&id='.$usrid.'&size=small width=400>';
	} else {
		echo '<font color="red" size="4">Du hast bisher noch kein aktuelles Bild hochgeladen</font>';
	}
	//echo '</div></div>';
	//Steckbrief
	echo '<br><br>';
	/*echo '<h2>Steckbrief</h2>';
	
	$sql = "SELECT first_name, last_name FROM users WHERE id = ".$usrid." LIMIT 1";
	$query = mysql_query($sql);
	$name = mysql_fetch_array($query);
	echo '<form><fieldset><div class="clearfix"><label>Vorname:</label><div class="input"><span class="uneditable-input">'.$name['first_name'].'</span></div></div>';
	echo '<div class="clearfix"><label>Nachname:</label><div class="input"><span class="uneditable-input">'.$name['last_name'].'</span></div></div>';
	
	$sql = "SELECT id, name FROM steckbriefList ORDER BY type, reihenfolge";
	$query = mysql_query($sql);
	
	while ($eintrag = mysql_fetch_array($query)) {
		$sql2 = "SELECT value FROM steckbriefStat WHERE userID = ".$usrid." AND type = ".$eintrag['id']." LIMIT 1";
		$query2 = mysql_query($sql2);
		$value = mysql_fetch_array($query2);
		
		if ($value['value'] == '') {
			$value['value'] = '&nbsp;';
		}

		echo '<div class="clearfix"><label>'.$eintrag['name'].'</label><div class="input"><span class="uneditable-input" style="width: 350px">'.$value['value'].'</span></div></div>';
	}
	
	echo '</fieldset></form><br><br>';*/
	
	//Schülerwahlen
	echo '<h2>Schülerwahlen</h2>';
	echo 'Bisher gewählt:<br><br>';

	echo '<table class="zebra-striped">';
	echo '<thead><tr><th>Kategorie</th><th>Männlich</th><th>Weiblich</th></tr></thead><tbody>';
	$sql = "SELECT id, voteString FROM voteList ORDER BY voteString";
	$query = mysql_query($sql);
	
	while ($vote = mysql_fetch_array($query)) {
		//voteString
		echo '<tr><td>'.$vote['voteString'].'</td>';
		
		//männlich
		$votetransform_m = $vote['id'] * 2 - 1;
		$sql2 = "SELECT voted FROM voteStat WHERE voting = '".$usrid."' AND voteid = ".$votetransform_m." LIMIT 1";
		$query2 = mysql_query($sql2);
		$result2 = mysql_fetch_array($query2);
		
		echo '<td>';
		
		if ($result2['voted'] > 0) { 
			$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$result2['voted']." LIMIT 1";
			$query3 = mysql_query($sql3);
			$result3 = mysql_fetch_array($query3);

			echo $result3['first_name'].' '.$result3['last_name'];
		} else {
			echo '<font color="red">niemand</font>';
		}
		echo '</td>';
		
		//weiblich
		$votetransform_w = $vote['id'] * 2;
		$sql4 = "SELECT voted FROM voteStat WHERE voting = '".$usrid."' AND voteid = ".$votetransform_w." LIMIT 1";
		$query4 = mysql_query($sql4);
		$result4 = mysql_fetch_array($query4);
		
		echo '<td>';
		
		if ($result4['voted'] > 0) { 
			$sql5 = "SELECT first_name, last_name FROM users WHERE id = ".$result4['voted']." LIMIT 1";
			$query5 = mysql_query($sql5);
			$result5 = mysql_fetch_array($query5);

			echo $result5['first_name'].' '.$result5['last_name'];
		} else {
			echo '<font color="red">niemand</font>';
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</tbody></table><br>';
	
	//Paarwahlen
	echo '<h2>Paarwahlen</h2>';
	echo 'Bisher gewählt:<br><br>';
	echo '<table class="zebra-striped">';
	echo '<thead><tr><th>Kategorie</th><th>gewählte Personen</th></tr></thead><tbody>';
	
	$sql = "SELECT id, voteString FROM paarVoteList ORDER BY voteString";
	$query = mysql_query($sql);
	
	while ($vote = mysql_fetch_array($query)) {
		$sql2 = "SELECT voteString, wahl_m, wahl_w FROM paarVoteStat WHERE voteID = ".$vote['id']." AND voting = ".$usrid." LIMIT 1";
		$query2 = mysql_query($sql2);
		$voted = mysql_fetch_array($query2);
		
		if ($voted['wahl_m'] == 0 AND $voted['wahl_w'] == 0) {
			$votedName  = '<font color="red">niemand</font>';
		} else {
			$votedName = $voted['voteString'];
		}
		
		echo '<tr><td>'.$vote['voteString'].'</td><td>'.$votedName.'</td></tr>'; 
	}
	
	echo '</tbody></table><br>';
	
	//Lehrerwahlen
	echo '<h2>Lehrerwahlen</h2>';
	echo 'Bisher gewählt:<br><br>';

	echo '<table class="zebra-striped">';
	echo '<thead><tr><th>Kategorie</th><th>Männlich</th><th>Weiblich</th></tr></thead><tbody>';
	$sql = "SELECT id, voteString FROM lehrerVoteList ORDER BY voteString";
	$query = mysql_query($sql);
	
	while ($vote = mysql_fetch_array($query)) {
		//voteString
		echo '<tr><td>'.$vote['voteString'].'</td>';
		
		//männlich
		$votetransform_m = $vote['id'] * 2 - 1;
		$sql2 = "SELECT lehrer FROM lehrerVoteStat WHERE von = '".$usrid."' AND voteId = ".$votetransform_m.' LIMIT 1';
		$query2 = mysql_query($sql2);
		$result2 = mysql_fetch_array($query2);
		
		echo '<td>';
		
		if ($result2['lehrer'] > 0) { 
			$sql3 = "SELECT name FROM lehrer WHERE id = ".$result2['lehrer'].' LIMIT 1';
			$query3 = mysql_query($sql3);
			$result3 = mysql_fetch_array($query3);
			
			echo 'Herr '.$result3['name'];
		} else {
			echo '<font color="red">niemand</font>';
		}
		echo '</td>';
		
		//weiblich
		$votetransform_w = $vote['id'] * 2;
		$sql4 = "SELECT lehrer FROM lehrerVoteStat WHERE von = '".$usrid."' AND voteId = ".$votetransform_w.' LIMIT 1';
		$query4 = mysql_query($sql4);
		$result4 = mysql_fetch_array($query4);
		
		echo '<td>';
		
		if ($result4['lehrer'] > 0) { 
			$sql5 = "SELECT name FROM lehrer WHERE id = ".$result4['lehrer'].' LIMIT 1';
			$query5 = mysql_query($sql5);
			$result5 = mysql_fetch_array($query5);

			echo 'Frau '.$result5['name'];
		} else {
			echo '<font color="red">niemand</font>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table><br>';
}
?>
