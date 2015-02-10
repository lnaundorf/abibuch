<div align="center">
<h1>Auswertung der Schülerwahlen</h1>
</div>
<?
	require('ValUser.php');
	
	if ($rights >= 10) {
		
		echo '<form method="post" action="?s=admin_contents/wahlen/Schuelerwahlen.php">';
		echo '<select class="xxlarge" name="vote">';
		
		$sql = "SELECT id, voteString FROM voteList ORDER BY voteString";
		$query = mysql_query($sql);
		
		while ($vote = mysql_fetch_array($query)) {
			echo '<option value="'.$vote['id'].'"';
			if ($_POST['vote'] == $vote['id']) {
				echo 'selected="true"';
			}
			echo '>';
			echo $vote['voteString'];
			echo '</option>';
		}
		echo '</select>';
		
		echo '<select name="geschlecht"><option value="m"';
		if ($_POST['geschlecht'] == 'm') {
			echo 'selected = "true"';
		}
		echo '>männlich</option><option value="w"';
		if ($_POST['geschlecht'] == 'w') {
			echo 'selected="true"';
		}
		echo '>weiblich</option></select>';
		echo '<input class="btn primary" name="submit" type="submit" value="anzeigen">';
		
		if ($_POST) {
			if ($_POST['geschlecht'] == 'm') {
				$selected_vote = 2 * $_POST['vote'] - 1;
			}
			else {
				$selected_vote = 2 * $_POST['vote'];
			}
		
			$sql = "SELECT DISTINCT voted, count(voted) AS count_voted FROM voteStat where voteid = '".$selected_vote."' GROUP BY voted ORDER BY count_voted DESC";
			$query = mysql_query($sql);
			
			$sql3 = "SELECT count(*) AS count_voted FROM voteStat WHERE voteid = '".$selected_vote."' AND voted <> 0";
			$query3 = mysql_query($sql3);
			$count = mysql_fetch_array($query3);
			
			echo '<table class="zebra-striped"><thead><tr><th>Name</th><th>Anzahl Stimmen</th><th>Prozent Stimmen</th>';
			if ($_POST['erweitern'] AND $rights == 11) {
				echo '<th><input class="btn primary" name="verstecken" type="submit" value="Wähler verstecken">';
			}
			else if ($rights == 11){
				echo '<th><input class="btn primary" name="erweitern" type="submit" value="Wähler anzeigen">';
			}
			echo '</tr></thead><tdata></tr>';
			
			while ($stat = mysql_fetch_array($query)) {
				if ($stat['voted'] != '' AND $stat['voted'] != 0) {
					$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$stat['voted'];
					$query2 = mysql_query($sql2);
					$user = mysql_fetch_array($query2);
					
					
				
					$vorname = $user['first_name'];
					$nachname = $user['last_name'];
				
					echo '<tr><td>'.$vorname.' '.$nachname.'</td><td>'.$stat['count_voted'].'</td><td>'.(round($stat['count_voted'] / $count['count_voted'], 3) * 100).'%</td>';
					if ($_POST['erweitern'] AND $rights == 11) {
						echo '<td>';
						$sql3 = "SELECT voting FROM voteStat WHERE voteid = ".$selected_vote." AND voted = ".$stat['voted'];
						$query3 = mysql_query($sql3);
					
						while ($voting = mysql_fetch_array($query3)) {
							$sql4 = "SELECT first_name, last_name FROM users WHERE id = ".$voting['voting']." LIMIT 1";
							$query4 = mysql_query($sql4);
							$waehler = mysql_fetch_array($query4);
							echo $waehler['first_name']." ".$waehler['last_name'].", ";
						}
						echo '</td>';
					} elseif ($rights == 11){
						echo '<td>&nbsp;</td>';
					}
					echo '</tr>';
				}
			}
			echo '</thead></table>';		
		}
	echo '</form>';
	}
?>
