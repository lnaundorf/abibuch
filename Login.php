<h1>Login</h1>
<?
require('ValUser.php');
require('actionLog.php');
//check if user already logged in
if(!$loggedin) {

if($_POST['user']) {
	if(!$userexists) {
		echo '<div style="color: red; font-size: 14pt">Der Benutzer existiert nicht<br></div>';
	} else {
		if(!$pwright) {
			echo '<div style="color: red; font-size: 14pt">Das Passwort stimmt nicht überein<br></div>';
		}
	}
}
?>
<form method="post" action="
<?
$einm = false;
//resend get variables
foreach($_GET as $GI => $Index) {
	if( $GI != 'action' ) {
		if($GI == 's' && (strtolower($Index) == 'login' ||strtolower($Index) == 'login.php')) {
			$Index = 'Login.php';
		}
		if($einm) {
			echo '&'.$GI.'='.$Index;
		} else {
			$einm = true;
			echo '?'.$GI.'='.$Index;
		}
	}
}
?>" ><fieldset>
	
<?
$einm = false;

//resend post variables
foreach($_POST as $GI => $Index) {
	echo '<input type="hidden" name="'.$GI.'" value="'.$Index.'" />';
}
?>

<input type="hidden" name="login_submit" value="1" />
<div class="clearfix"><label>Benutzername:</label>
<div class="input"><input class="xlarge" type="text" name="user" value="<?php echo $_POST['user']; ?>" /></div></div>
<div class="clearfix"><label>Passwort:</label>
<div class="input"><input class="xlarge" type="password" name="password" /></div></div>
<div class="actions"><input class="btn primary" type="submit" value="Login" /></div>

</form></fieldset><?
}
else{//inform user
	echo '<font size="4">Du bist jetzt eingeloggt als </font><font color="green" size="4">'.$user.'</font>';

	logAction($usrid, "eingeloggt");
	
	$sql = "SELECT password, username from users WHERE id = ".$usrid." LIMIT 1";
	$query = mysql_query($sql);
	$user = mysql_fetch_array($query);

	if ($user['password'] == sha1($user['username'])) {
		echo '<br><br><div style="font-size: 22pt; color: red; line-height: 120%">Du hast dein Passwort noch nicht geändert.<br> Du solltest dies sofort tun. Klicke dazu <a href="javascript:loadContent(\'public_contents/Passwort aendern.php\')">hier</a></div><br><br>';
	}
	
	//Aktuelles
	$sql = "SELECT featureString FROM newFeatures ORDER BY reihenfolge";
	$query = mysql_query($sql);
	if(mysql_num_rows($query) > 0) {
		echo '<br><br><br><h1>Aktuelles</h1>';
		echo '<font size="4"><ul>';
		while($feature = mysql_fetch_array($query)) {
			echo '<li>'.$feature['featureString'].'</li><br>';
		}
		echo '</ul></font>';
	}
}
?>