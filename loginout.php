<?
if($_POST['login_submit'] == 1) { //login
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['password'] = sha1($_POST['password']);
} elseif( $_GET['action'] == 'logout' ) { //logout
	$_SESSION['user'] = '';
	$_SESSION['password'] = '';
	session_destroy();
	//echo '<meta http-equiv="refresh" content="0; URL=index.php?s=start">';
}
?>