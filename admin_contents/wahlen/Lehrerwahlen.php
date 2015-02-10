<div align="center">
<h1>Auswertung der Lehrerwahlen</h1>
</div>
<br>

<?
	require ('ValUser.php');
	
	if ($rights >= 10) {
		
		echo '<form method="post" action="?s=admin_contents/wahlen/Lehrerwahlen.php">';
		echo '<select class="xlarge" name="vote">';
		
		$sql = "SELECT id, voteString FROM lehrerVoteList ORDER BY voteString";
		$query = mysql_query($sql);
		
		while ($vote = mysql_fetch_array($query)) {
			echo '<option value="'.$vote['id'].'"';
			if ($_POST['vote'] == $vote['id']) {
				echo 'selected="true"';
			}
			echo '>'.$vote['voteString'].'</option>';
		}
		echo '</select>';
		echo '<select name="geschlecht"><option value="m">Männlich</option><option value="w"';
		if($_POST['geschlecht'] == 'w') {
			echo ' selected="true"';
		}
		echo '>Weiblich</option></select>';
		echo '<input class="btn primary" name="submit" type="submit" value="anzeigen">';
		
		if ($_POST) {
			if ($_POST['geschlecht'] == 'm') {
				$vote = 2 * $_POST['vote'] - 1;
				$geschlecht = "männlich";
			} else {
				$vote = 2 * $_POST['vote'];
				$geschlecht = "weiblich";
			}
			$sql = "SELECT voteString FROM lehrerVoteList WHERE id = ".$_POST['vote']." LIMIT 1";
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);
			echo '<br><br><h2>'.$result['voteString'].' ('.$geschlecht.')</h2>';
		
			echo '<table class="zebra-striped"><thead><tr><th>Lehrer</th><th>Anzahl Stimmen</th><th>Prozent Stimmen</th></tr></thead><tbody>';
			
			$sql = "SELECT DISTINCT lehrer, count(lehrer) AS count_lehrer FROM lehrerVoteStat WHERE voteId = '".$vote."' AND lehrer <> 0 GROUP BY lehrer ORDER BY count_lehrer DESC";
			$query = mysql_query($sql);
			
			$sql3 = "SELECT count(*) AS count_voted FROM lehrerVoteStat WHERE voteId = '".$vote."' AND lehrer <> 0";
			$query3 = mysql_query($sql3);
			$count = mysql_fetch_array($query3);
			
			while ($lehrer = mysql_fetch_array($query)) {
				$sql2 = "SELECT name FROM lehrer WHERE id = ".$lehrer['lehrer']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$lehrer2 = mysql_fetch_array($query2);
				
				if ($_POST['geschlecht'] == 'm') {
					$lehrername = "Herr ".$lehrer2['name'];
				} else {
					$lehrername = "Frau ".$lehrer2['name'];
				}
				echo '<tr><td>'.$lehrername.'</td><td>'.$lehrer['count_lehrer'].'</td><td>'.(round($lehrer['count_lehrer'] / $count['count_voted'], 3) * 100).'%</td></tr>';
			}
			echo '</tdata></table>';
		}
	} else {
		echo '<font size="5" color="red">Go away. Nothing to see here...</font>';
	}
?>
