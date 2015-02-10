<div align="center">
<h1>Admin lange Kommentare</h1>
</div>
<?
require('ValUser.php');

if ($rights >= 10) {
	echo 'Alle Kommentare zu';
	echo '<form method="post" action="?s=admin_contents/kommentare/lange Kommentare.php">';
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
	echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" name="show_authors" value=1';
	
	if ($_POST['show_authors'] == 1) {
		echo ' checked';
	}
	echo '>Autoren der Kommentare anzeigen';
	
	if ($_POST['submit']) {
		$sql = "SELECT vonName, text FROM longcomments WHERE nach = ".$_POST['id'];
		$query = mysql_query($sql);
		echo '<br><br><br>';
		
		$i = 0;
		
		echo '<div class="longcomments">';
		
		while ($comment = mysql_fetch_array($query)) {
			if ($_POST['show_authors'] == 1) {
				echo 'Kommentar von: '.$comment['vonName'].'<br><br>';
			}
			echo nl2br($comment['text']).'<br><br><br><br>';
			$i++;
		}
		echo '</div><br><br><br>Gesamtanzahl der langen Kommentare: '.$i;
	}
}
?>
