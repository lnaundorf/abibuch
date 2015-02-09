<div align="center">
<h1>Lehrer-/Schülersprüche einschicken</h1>
</div>
<?
require('ValUser.php');
require('actionLog.php');

if($loggedin && $rights >= 1) {
	echo '<div style="font-size: 14pt">Hier kannst du lustige Lehrer-/Schülersprüche einschicken, die dann im Abibuch veröffentlicht werden<br><br></div>';
	if($_POST['einschicken']) {
		if($_POST['message'] == '') {
			echo '<br><div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Dein Spruch darf nicht leer sein</p></div>';
		} else {
			$sql = 'INSERT INTO quotes (user, text) VALUES ('.$usrid.', "'.mysql_real_escape_string($_POST['message']).'")';
			if(mysql_query($sql)) {
				echo '<br><div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>Dein Spruch wurde eingeschickt</p></div>';
				logAction($usrid, "Spruch eingeschickt");
			} else {
				echo '<br><div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>Beim Einsenden deines Spruchs ist ein Fehler aufgetreten</p></div>';
			}
		}
	}
	echo '<form method="post" action="?s=public_contents/Sprueche.php"><fieldset>';
	echo '<div class="clearfix"><label style="width: 130px">Text:</label><div class="input" style="margin-left: 150px"><textarea name="message" class="xxlarge" rows="5"></textarea>';
	echo '</div></div><div class="actions" style="padding-left: 150px"><input name="einschicken" class="btn primary" type="submit" value="Spruch einschicken"></div>';
	echo "</fieldset></form>";
}
?>
