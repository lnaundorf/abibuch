<?
	function logAction($userid, $action) {
		$sqlhost = 'rdbms.strato.de';
		$sqluser = 'U954445';
		$sqlkey  = 'kcirtap';
		$database = 'DB954445';

		$sqlconn = mysql_connect($sqlhost, $sqluser, $sqlkey);
		mysql_select_db($database);
		
		$sql = "INSERT INTO actionLog (user, action) VALUES (".$userid.", '".$action."')";
		$result = mysql_query($sql);
	}
?>