<h1>Minikommentare formatiert</h1>

<?
require('ValUser.php');

if ($rights >= 10) {
	echo 'Alle Kommentare zu';
	echo '<form method="post" action="?s=admin_contents/kommentare/Minikommentare formatiert.php">';
	echo '<select name="id">';
	
	$sql = "SELECT id, first_name, last_name FROM users WHERE rights <= 1 AND visible = 1 ORDER BY first_name, last_name";
	$query = mysql_query($sql);
	
	while ($user = mysql_fetch_array($query)) {
		echo '<option value="'.$user['id'].'"';
		if ($_POST['id'] == $user['id']) {
			echo 'selected="true"';
		}
		echo '>'.$user['first_name'].' '.$user['last_name'].'</option>';
	}
	echo '</select>';
	echo '<input class="btn primary" name="submit" type="submit" value="anzeigen">';
		
	if ($_POST['submit']) {
	
		$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$_POST['id']." LIMIT 1";
		$query2 = mysql_query($sql2);
		$user = mysql_fetch_array($query2);
		
		echo "<h3>".$user['first_name']." ".$user['last_name']."</h3>";
		
		$sql = "SELECT von, text FROM comments WHERE nach = ".$_POST['id']." AND nett >= fies";
		$query = mysql_query($sql);
		
		$i = 0;
		
		echo '<br><div class="shortcomments">';
		
		while ($comment = mysql_fetch_array($query)) {
			$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von'];
			$query2 = mysql_query($sql2);
			$user = mysql_fetch_array($query2);
			echo '<b>'.$user['first_name'].' '.$user['last_name'].':</b> ';
			echo $comment['text'].'  -  ';
			
			$i++;
		}
		
		echo '</div><br><br><br><br>Gesamtanzahl der Kommentare: '.$i;
	}
}
?>