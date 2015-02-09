<h1>Admin Schüler-/Lehrersprüche</h1>
<?
require('ValUser.php');

if($loggedin && $rights >= 10) {
	echo '<div style="font-size: 14pt">alle bisher eingeschickten Sprüche:<br><br></div>';
	$sql = "SELECT * FROM quotes ORDER BY id";
	$query = mysql_query($sql);
	
	while($row = mysql_fetch_array($query)) {
		$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$row['user']." LIMIT 1";
		$query2 = mysql_query($sql2);
		$user = mysql_fetch_array($query2);
		echo 'eingeschickt von <strong>'.$user['first_name'].' '.$user['last_name'].':</strong><br><br>';
		echo nl2br($row['text']).'<br><br><br>';
	}

}
?>