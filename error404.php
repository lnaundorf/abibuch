<h1>Error 404</h1>
Die Seite wurde nicht gefunden.
<?
	
	$sqlconn = mysql_connect($sqlhost, $sqluser, $sqlkey);
	
	$sql = "INSERT INTO $database.notFoundErrors (request) Values('".$_SERVER['REQUEST_URI']."')";
	$result = mysql_query($sql);

?>
<!--
<div align="center">
<object width="480" height="385">
	<param name="movie" value="http://www.youtube.com/v/BzAs1vMymtg&hl=de_DE&fs=1&rel=0&autoplay=1"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allowscriptaccess" value="always"></param>
	<embed src="http://www.youtube.com/v/BzAs1vMymtg&hl=de_DE&fs=1&rel=0&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed>
</object>
</div>
<div align="center">
<font size="7">FAIL!<br>Versuch's nochmal...</font>
</div>-->
