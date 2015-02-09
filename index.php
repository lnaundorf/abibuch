<?
session_start();
require('define.php');
require('loginout.php');
require('ValUser.php');

if (substr($_GET['s'], 0, 3) == 'kom') {
	$type = 'comments';
} elseif (substr($_GET['s'], 0, 3) == 'wah') {
	$type = 'votes';
} elseif(substr($_GET['s'], 0, 5) == 'admin') {
	if (substr($_GET['s'], 15, 10) == 'kommentare') {
		$type = 'Admin kommentare';
	} elseif (substr($_GET['s'], 15, 6) == 'wahlen') {
		$type = 'auswertung Wahlen';
	}
}

$substr = substr($_GET['s'], 0, 4);
$loggedinsites = array('ring', 'publ', 'komm', 'admi', 'uber');
if(!$loggedin && in_array($substr, $loggedinsites)) {
	header('Location: index.php?s=Login.php');
}
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><? echo $SysName; ?></title>
	<link rel="stylesheet" href="bootstrap-1.2.0<?//if ($rights < 11) { echo '.min';}?>.css">
	<link rel="stylesheet" href="style<?//if ($rights < 11) { echo '.min';}?>.css">
	<script src="js_lib<?//if ($rights < 11) { echo '.min';}?>.js" type="text/javascript"></script>
	<!--[if gte IE 5]>
		<style type="text/css">
			.content {
				width:expression(document.body.clientWidth > 1405? "1180px": "auto");
			}
		</style>
	<![endif]-->
	<link rel="icon" href="favicon.ico" type="image/x-icon"
</head>
<body>
	<div class="header">
		<div align="center">
			AKS Kronberg Abibuch 2012
			<!--<font size="4" style="font-variant: normal"><br><br>HIER KÖNNTE IHR ABIMOTTO STEHEN</font>-->
		</div>
	</div>
	<div class="container-fluid">
		<div class="sidebar">
			<div class="navi" id="navi">
				<? include('navi.php'); ?>
			</div>
		</div>
		<div class="content">
		<?
			if($loggedin) {
				echo 'Benutzer: <font color="green">'.$user.'</font><br>';
			}
		?>
			<div id="realContent">
				<?	if(!$_GET['s']) {
						include($HomeFile);
					} elseif(file_exists($_GET['s'])) {
						include($_GET['s']);
					} else {
						include($Err404File);
					}
				?>
			</div>
		</div>
	</div>
	<div class="footer">
		© Leif Naundorf 2009 - 2012 <a href="index.php?s=Impressum.php">Impressum</a>
	</div>
</body>
</html>
