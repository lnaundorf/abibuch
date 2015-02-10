<div align="center">
<h1>Ranking Schülerwahlen</h1>
</div>
<?
	require('ValUser.php');
	
	if ($rights >= 10) {
	
		$sql = "SELECT id, voteString FROM voteList ORDER BY voteString";
		$query = mysql_query($sql);
		echo 'Reihenfolge: Platz, Name, Anzahl Stimmen, Prozent aller abgegebenen Stimmen<br>';
		while ($vote = mysql_fetch_array($query)) {
			echo '<h2 style="margin-top: 40px;margin-bottom: 10px">'.$vote['voteString'].'</h2>';
			echo '<h3>männlich</h3>';
			$vote_m = $vote['id'] * 2 - 1;
			outputVote($vote_m);
			
			echo '<h3>weiblich</h3>';
			$vote_w = $vote['id'] * 2;
			outputVote($vote_w);
		}
	}
	
	function outputVote($id) {
		$sql3 = "SELECT count(*) AS count_voted FROM voteStat WHERE voteid = '".$id."' AND voted <> 0";
		$query3 = mysql_query($sql3);
		$count = mysql_fetch_array($query3);
		
		$sql2 = "SELECT DISTINCT voted, count(voted) AS count_voted FROM voteStat WHERE voteid = '".$id."' AND voted <> 0 GROUP BY voted ORDER BY count_voted DESC LIMIT 3";
		$query2 = mysql_query($sql2);
		
		$counter = 1;
		while ($schueler = mysql_fetch_array($query2)) {
			$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$schueler['voted']." LIMIT 1";
			$query3 = mysql_query($sql3);
			$name = mysql_fetch_array($query3);
			
			echo $counter.': '.$name['first_name']." ".$name['last_name']." ".$schueler['count_voted'].' '.(round($schueler['count_voted']/$count['count_voted'], 3) * 100).'%<br>';
			$counter++;
		}
	}
?>