<h1>Kommentarübersicht</h1>

<?
require('ValUser.php');

if ($rights >= 10) {
	echo 'Alle Kommentare zu';
	echo '<form method="post" action="?s=admin_contents/kommentare/Minikommentare.php">';
	echo '<select name="id">';
	
	$sql = "SELECT id, first_name, last_name FROM users WHERE visible = 1 AND rights <= 1 ORDER BY first_name, last_name";
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
		$sql = "SELECT von, text FROM comments WHERE nach = ".$_POST['id'];
		$query = mysql_query($sql);
		
		echo '<table class="zebra-striped"><thead><tr><th>Von</th><th>Kommentar</th></tr></thead><tdata>';
		
		$i = 0;
		
		while ($comment = mysql_fetch_array($query)) {
		
			$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$comment['von']." LIMIT 1";
			$query2 = mysql_query($sql2);
			$user = mysql_fetch_array($query2);
			
			echo '<tr><td>'.$user['first_name'].' '.$user['last_name'].'</td><td>'.$comment['text'].'</td></tr>';	
			$i++;
		}
		echo '</tdata></table>';
		
		echo 'Gesamtanzahl der Kommentare: '.$i;
	}
}
?>
