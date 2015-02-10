<h1>Anzahl Minikommentare</h1>

<?
	require ('ValUser.php');
	
	if ($rights >= 10) {
		echo '<table class="zebra-striped"><thead><tr><th>Name</th><th>Anzahl Minikommentare</th></tr></thead><tbody>';
		$sql = "SELECT U.id, IFNULL(C.count_nach, 0) AS count_nach FROM $database.users as U LEFT JOIN (SELECT DISTINCT nach, count(nach) AS count_nach FROM $database.comments GROUP BY nach) AS C ON U.id = C.nach WHERE (U.rights <= 1 AND U.visible = 1) ORDER BY C.count_nach";
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query)) {
			$sql2 = "SELECT first_name, last_name FROM users WHERE id = ".$result['id']." LIMIT 1";
			$query2 = mysql_query($sql2);
			$user = mysql_fetch_array($query2);
			echo '<tr><td>'.$user['first_name']." ".$user['last_name'].'</td><td>'.$result['count_nach']."</td></tr>";
		}
		echo '</tbody></table>';
	}
?>