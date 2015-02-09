<h1>Passwort</h1>
Passwort noch nicht geändert, obwohl eingeloggt:<br><br><br>
<?
require('define.php');
require('ValUser.php');

if($loggedin && $rights >= 11) {
	$sql = "SELECT id, first_name, last_name, username, password, lastonline FROM users ORDER BY lastonline DESC";
	$query = mysql_query($sql);
	while($user = mysql_fetch_array($query)) {
		$sha1 = sha1($user['username']);
		if($user['password'] == $sha1 && $user['lastonline'] != 0) {
			echo $user['first_name']." ".$user['last_name']." ".$user['lastonline']."<br>";
		}
	}
}