<?
require('ValUser.php');

$pagesize = 100;
if($_GET['hide'] == '1') {
	$hide = "WHERE actionLog.user <> 1 AND actionLog.user <> 105";
	$hidecommand = "&hide=1";
	$hidecommandneg = "";
} else {
	$hide = "";
	$hidecommand = "";
	$hidecommandneg = "&hide=1";
}
if(!$_GET['page']) {
	$pagenumber = 1;
} else {
	$pagenumber = $_GET['page'];
}


if($loggedin && $rights >= 11) {
	
	echo '<h1>ActionLog</h1>';

	$sql = "SELECT count(*) AS count FROM actionLog ".$hide;
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	$num_pages = ceil($result['count'] / $pagesize);
	if($pagenumber < 1) {
		$pagenumber = 1;
	} elseif($pagenumber > $num_pages) {
		$pagenumber = $num_pages;
	}
	echo '<div class="pagination"><ul><li class="prev';
	if($pagenumber == 1) {
		echo ' disabled';
		$pagetogo = $pagenumber;
	} else {
		$pagetogo = $pagenumber - 1;
	}
	echo '"><a href="?s=uberadmin_contents/actionLog.php&page='.$pagetogo.$hidecommand.'">&larr; Previous</a></li>';
	for($i = 1; $i <= $num_pages; $i++) {
		echo '<li';
		if($i == $pagenumber) {
			echo ' class="active"';
		}
		echo '><a href="?s=uberadmin_contents/actionLog.php&page='.$i.$hidecommand.'">'.$i.'</a></li>';
	}
	echo '<li class="next';
	if($pagenumber == $num_pages) {
		echo ' disabled';
		$pagetogo = $pagenumber;
	} else {
		$pagetogo = $pagenumber + 1;
	}
	echo '"><a href="?s=uberadmin_contents/actionLog.php&page='.$pagetogo.$hidecommand.'">Next »</a></li></ul></div>';
	echo '<a href="?s=uberadmin_contents/actionLog.php&page='.$pagenumber.$hidecommandneg.'">toggle hide admin</a>';
	echo '<table style="width: 90%"><thead><tr><th>Zeit</th><th>ID</th><th>Benutzername</th><th>Vorname</th><th>Nachname</th><th>Action</th></tr></thead><tbody>';
	
	$sql = "SELECT actionLog.time, actionLog.user, users.username, users.first_name, users.last_name, actionLog.action FROM actionLog LEFT JOIN users ON actionLog.user = users.id ".$hide." ORDER BY time DESC LIMIT ".($pagenumber - 1) * $pagesize.", ".$pagenumber * $pagesize;
	$query = mysql_query($sql);
	
	while($action = mysql_fetch_array($query)) {
		echo '<tr><td>'.$action['time'].'</td><td>'.$action['user'].'</td><td>'.$action['username'].'</td><td>'.$action['first_name'].'</td><td>'.$action['last_name'].'</td><td>'.$action['action'].'</td></tr>';
	}
	echo '</tbody></table>';
}
?>	
