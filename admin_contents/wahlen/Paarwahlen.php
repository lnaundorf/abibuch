<div align="center">
<h1>Auswertung der Paarwahlen</h1>
</div>

<?
	require('ValUser.php');
	
	if ($rights >= 10) {
		
		echo '<form method="post" action="?s=admin_contents/wahlen/Paarwahlen.php">';
		echo '<select class="xlarge" name="vote">';
		
		$sql = "SELECT id, voteString FROM paarVoteList ORDER BY voteString";
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
		
		echo '<input class="btn primary" name="submit" type="submit" value="anzeigen">';
		
		if ($_POST) {
		
			$sql = "SELECT DISTINCT voteString, count(voteString) AS count_voteString FROM paarVoteStat where voteId = ".$_POST['vote']." GROUP BY voteString ORDER BY count_voteString DESC";
			$query = mysql_query($sql);
			
			$sql3 = "SELECT count(*) AS count_voted FROM paarVoteStat WHERE voteId = '".$_POST['vote']."' AND wahl_m <> 0 AND wahl_w <> 0";
			$query3 = mysql_query($sql3);
			$count = mysql_fetch_array($query3);
			
			echo '<table class="zebra-striped">';
			echo '<thead><tr><th>Paar</th><th>Anzahl Stimmen</th><th>Prozent Stimmen</th>';
			if ($_POST['erweitern'] AND $rights == 11) {
				echo '<th><input class="btn primary" name="verstecken" type="submit" value="Wähler verstecken">';
			}
			else if ($rights == 11){
				echo '<th><input class="btn primary" name="erweitern" type="submit" value="Wähler anzeigen"></th>';
			}
			echo '</tr></thead><tbody>';
			
			while ($stat = mysql_fetch_array($query)) {
				if ($stat['voteString'] != '  &  ') {
					echo '<tr><td>'.$stat['voteString'].'</td><td>'.$stat['count_voteString'].'</td><td>'.(round($stat['count_voteString'] / $count['count_voted'], 3) * 100).'%</td>';
					if ($_POST['erweitern'] AND $rights == 11) {
						echo '<td>';
						$sql3 = "SELECT voting FROM paarVoteStat WHERE voteId = ".$_POST['vote']." AND voteString = '".$stat['voteString']."'";
						$query3 = mysql_query($sql3);
					
						while ($voting = mysql_fetch_array($query3)) {
					
							$sql4 = "SELECT first_name, last_name FROM users WHERE id = ".$voting['voting']." LIMIT 1";
							$query4 = mysql_query($sql4);
							$waehler = mysql_fetch_array($query4);
							echo $waehler['first_name']." ".$waehler['last_name'].", ";
						}
						echo '</td>';
					}
					else if ($rights == 11){
						echo '<td>&nbsp;</td>';
					}
					echo '</tr>';
				}
			}
			echo '</tdata></table>';		
		}
		echo '</form>';
	}
?>
