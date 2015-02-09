<?
session_start();
require('define.php');
require('loginout.php');
require('ValUser.php');

if(!$_GET['s']) {
	include($HomeFile);
} elseif(file_exists($_GET['s'])) {
	include($_GET['s']);
} else {
	include($Err404File);
}
?>
