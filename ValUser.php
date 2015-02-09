<?
require('define.php');

$loggedin = false;

//validate user
if($_SESSION['user'] && $_SESSION['password']) {
	$userexists = false;

	//load user data from MySQL-Database
	$sqlconn = mysql_connect($sqlhost, $sqluser, $sqlkey);
	mysql_select_db($database);
	mysql_set_charset("utf8");
	$sql = 'SELECT * FROM users WHERE username = \''.mysql_real_escape_string($_SESSION['user']).'\' LIMIT 1';
	$query = mysql_query($sql);
	if($row = mysql_fetch_array($query)) {
		$userexists = true;
		$pwright= false;
		//$usrenabled = false;
		if($row['password'] == $_SESSION['password']) {
			$pwright = true;
			
			//set user variables
			$usrvisible = $row['visible'];
			$usrid = $row['id'];
			$user  = $row['username'];
			$rights = intval($row['rights']);
			$loggedin = true;
			$jetzt_status = intval($row['jetztbild_status']);
			$baby_status = intval($row['babybild_status']);
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$_SESSION['start'] = time();
		
			$sql = 'UPDATE users SET `lastonline` = \''.date('Y-m-d H-i-s').'\' WHERE username = \''.$_SESSION['user'].'\';';
			mysql_query($sql);
		} elseif($row['password'] == sha1($_SESSION['password'])) {
				$pwright = true;
		}
	}	
}
?>