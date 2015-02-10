<h1>Fiese Minikommentare aussortieren</h1>
<?
	require('ValUser.php');
	require('actionLog.php');
	
	if($rights >= 10) {
		if($rights >= 11) {
			//filter
			echo 'Nur Kommentare anzeigen <form method="POST"><select name="filtertype"><option value="von"';
			
			if($_POST['filtertype'] == 'von' OR $_POST['filtertype'] == 1) {
				echo ' selected="true"';
			}
			echo '>von</option><option value="nach"';
			
			if($_POST['filtertype'] == 'nach' OR $_POST['filtertype'] == 2) {
				echo ' selected="true"';
			}
			echo '>an</option></select><select name="filterid"><option value="0">-</option>';
			
			$sql = "SELECT first_name, last_name, id FROM users WHERE rights <= 1 AND visible = 1 ORDER BY first_name, last_name";
			$query = mysql_query($sql);
			
			while ($user = mysql_fetch_array($query)) {
				echo '<option value="'.$user['id'].'"';
				
				if($_POST['filterid'] == $user['id']) {
					echo ' selected="true"';
				}
				echo '>'.$user['first_name'].' '.$user['last_name'].'</option>';
			}
			echo '</select><input class="btn primary" type="submit" name="filter" value="Go"></form>';
		}
	
		if($_POST['id']) {
			if($_POST['nett']) {
				logAction($usrid, 'Kommentar von '.$_POST['idvon'].' nach '.$_POST['idnach'].' für NETT befunden');
				$sql = "UPDATE comments SET nett = nett + 1 WHERE id = ".$_POST['id']." LIMIT 1";
				$result = mysql_query($sql);
				if($result) {
					echo '<font color="green">Kommentare für nett befunden</font><br><br>';
				}
			} elseif($_POST['fies']) {
				logAction($usrid, 'Kommentar von '.$_POST['idvon'].' nach '.$_POST['idnach'].' fuer FIES befunden');
				$sql = "UPDATE comments SET fies = fies + 1 WHERE id = ".$_POST['id']." LIMIT 1";
				$result = mysql_query($sql);
				if($result) {
					echo '<font color="red">Kommentare für FIES befunden</font><br><br>';
				}
			} elseif($_POST['weiter']) {
				logAction($usrid, 'Kommentar von '.$_POST['idvon'].' nach '.$_POST['idnach'].' NICHT BEWERTET');
				echo 'Minikommentar weiter<br><br>';
			}
			if($_POST['filtertype'] != 0) {
				loadNextComment($_POST['filtertype'], $_POST['filterid']);
			} else {
				loadNextComment(0, 0);
			}
			echo '<br><br><br><form method="POST"><input class="btn primary" name="seeNett" type="submit" value="alle als NETT bewerteten Kommentare sehen"><br><input class="btn primary" name="seeNeutral" type="submit" value="alle als NEUTRAL bewerteten Kommentare sehen"><br><input class="btn primary" name="seeFies" type="submit" value="alle als FIES bewerteten Kommentare sehen"></form>';
		} elseif($_POST['seeFies']) {
			echo '<h2>Alle FIES bewerteten Minikommentare</h2>';
			echo '<br><form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
			
			$sql = "SELECT von, nach, text, nett, fies FROM comments WHERE fies >= 1 ORDER BY fies DESC";
			$query = mysql_query($sql);
			
			while($comment = mysql_fetch_array($query)) {
				$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$von = mysql_fetch_array($query2);
		
				$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['nach']." LIMIT 1";
				$query3 = mysql_query($sql3);
				$nach = mysql_fetch_array($query3);
			
				echo '(Nett: '.$comment['nett'].', Fies: '.$comment['fies'].') Kommentar von <b>'.$von['first_name']." ".$von['last_name']."</b> an <b>".$nach['first_name']." ".$nach['last_name']."</b>:<br>";
				echo $comment['text'].'<br><br>';
			}
		
			echo '<br><br><br><form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
		} elseif($_POST['seeNeutral']) {
			echo '<h2>Alle NEUTRAL bewerteten Minikommentare</h2>';
			echo '<br><form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
			
			$sql = "SELECT von, nach, text, nett, fies FROM comments WHERE nett = fies ORDER BY nett";
			$query = mysql_query($sql);
			
			while($comment = mysql_fetch_array($query)) {
				$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$von = mysql_fetch_array($query2);
		
				$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['nach']." LIMIT 1";
				$query3 = mysql_query($sql3);
				$nach = mysql_fetch_array($query3);
			
				echo '(Nett: '.$comment['nett'].', Fies: '.$comment['fies'].') Kommentar von <b>'.$von['first_name']." ".$von['last_name']."</b> an <b>".$nach['first_name']." ".$nach['last_name']."</b>:<br>";
				echo $comment['text'].'<br><br>';
			}
		
			echo '<form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
		} elseif($_POST['seeNett']) {
			echo '<h2>Alle NETT bewerteten Minikommentare</h2>';
			echo '<br><form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
			
			$sql = "SELECT von, nach, text, nett, fies FROM comments WHERE nett >= 1 ORDER BY nett DESC";
			$query = mysql_query($sql);
			
			while($comment = mysql_fetch_array($query)) {
				$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von']." LIMIT 1";
				$query2 = mysql_query($sql2);
				$von = mysql_fetch_array($query2);
		
				$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['nach']." LIMIT 1";
				$query3 = mysql_query($sql3);
				$nach = mysql_fetch_array($query3);
			
				echo '(Nett: '.$comment['nett'].', Fies: '.$comment['fies'].') Kommentar von <b>'.$von['first_name']." ".$von['last_name']."</b> an <b>".$nach['first_name']." ".$nach['last_name']."</b>:<br>";
				echo $comment['text'].'<br><br>';
			}
		
			echo '<form method="POST"><input class="btn info" type="submit" value="zurück"></form>';
		}  else {
			if($_POST['filter'] AND $_POST['filterid'] != 0) {
				if($_POST['filtertype'] == 'von') {
					loadNextComment(1, $_POST['filterid']);
				} elseif($_POST['filtertype'] == 'nach') {
					loadNextComment(2, $_POST['filterid']);
				}
			} else {
				loadNextComment(0, 0);
			}
			
			echo '<form method="POST"><input class="btn primary" name="seeNett" type="submit" value="alle als NETT bewerteten Kommentare sehen"><br><input class="btn" name="seeNeutral" type="submit" value="alle als NEUTRAL bewerteten Kommentare sehen"><br><input class="btn danger" name="seeFies" type="submit" value="alle als FIES bewerteten Kommentare sehen"></form>';
		}
	}
	
	function loadNextComment($type, $id) {
		require('ValUser.php');
		
		if($rights >= 11) {
			//addFilter();
		}
		
		if($type == 0) {
			$sql = "SELECT id, von, nach, text, (nett + fies) AS count FROM comments ORDER BY count, RAND() LIMIT 1";
		} elseif($type == 1) {
			$sql = "SELECT id, von, nach, text, (nett + fies) AS count FROM comments WHERE von = ".$id." ORDER BY count, RAND() LIMIT 1";
		} elseif($type == 2) {
			$sql = "SELECT id, von, nach, text, (nett + fies) AS count FROM comments WHERE nach = ".$id." ORDER BY count, RAND() LIMIT 1";
		}
		$query = mysql_query($sql);
		$comment = mysql_fetch_array($query);
		
		if(count($comment[0]) > 0) {
			$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von']." LIMIT 1";
			$query2 = mysql_query($sql2);
			$von = mysql_fetch_array($query2);
			
			$sql3 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['nach']." LIMIT 1";
			$query3 = mysql_query($sql3);
			$nach = mysql_fetch_array($query3);
			
			echo '<form method="POST">';
			echo 'Kommentar von <b>'.$von['first_name']." ".$von['last_name']."</b> an <b>".$nach['first_name']." ".$nach['last_name']."</b>:<br><br>";
			echo $comment['text'].'<br><br><br>';
			echo '<input type="hidden" name="id" value="'.$comment['id'].'">';
			echo '<input type="hidden" name="idvon" value="'.$comment['von'].'">';
			echo '<input type="hidden" name="idnach" value="'.$comment['nach'].'">';
			
			if($type != 0){
				echo '<input type="hidden" name="filtertype" value="'.$type.'">';
				echo '<input type="hidden" name="filterid" value="'.$id.'">';
			}
			
			echo '<input class="btn primary" type="submit" name="nett" value="Netter Kommentar">';
			echo '<input style="margin-left: 15px" class="btn danger" type="submit" name="fies" value="FIESER Kommentar">';
			echo '<input style="margin-left: 15px" class="btn" type="submit" name="weiter" value="keine Angabe">';
			echo '</form>';
		} else {
			echo 'Es gibt keine Kommentare in dieser Kategorie';
		}
	}
?>