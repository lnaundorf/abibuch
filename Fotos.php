<div align="center">
<h1>Status der Fotos</h1>
</div>
<br>
<?
require ('define.php');

$sqlconn = mysql_connect($sqlhost, $sqluser, $sqlkey);
mysql_select_db($database);
mysql_set_charset("utf8");
$query = mysql_query("SELECT id, first_name, last_name, babybild_status, jetztbild_status from users WHERE visible = 1 AND rights <= 1 ORDER BY first_name, last_name");

$tableString = '<table class="zebra-striped" id="table" border="1"><thead><tr><th>Vorname</th><th>Nachname</th><th>Babybild hochgeladen</th><th>Aktuelles Bild hochgeladen</th></tr></thead><tbody>';

$gut = 0;
$boese = 0;

while ($user = mysql_fetch_array($query)) {
	$gutpart = false;
	
	if ($user['babybild_status'] == 3) {
		$gutpart = true;
		$babyString = '<font color="green">ja</font>';
	} else {
		$babyString = '<font color="red">nein</font>';
	}
	
	if ($user['jetztbild_status'] == 3) {
		$jetztString = '<font color="green">ja</font>';
		
		if ($gutpart) {
			$gut++;
		} else {
			$boese++;
		}
	} else {
		$jetztString = '<font color="red">nein</font>';	
		$boese++;
	}
	
	$tableString .= '<tr id="'.$user['id'].'"><td>'.$user['first_name'].'</td><td>'.$user['last_name'].'</td><td>'.$babyString.'</td><td>'.$jetztString.'</td></tr>';
}
$tableString .= '</tbody></table>';
?>
<div style="font-size: 13pt; line-height: 120%">Hier seht ihr in der Übersicht, wer seine Bilder schon hochgeladen hat. Wer
seine Bilder nicht hochlädt, muss damit rechnen dieses schöne Bild auf seine persönliche
Seite im Abibuch zu bekommen.<br><br>
<img src="pictures/no-knut.jpg">
<br><br>
Bisher haben <? echo $gut ?> von <? echo $gut + $boese ?> Schüler beide Bilder hochgeladen, das macht eine Quote von
 <? echo round((($gut / ($boese + $gut)) * 100), 1) ?> %.</div><br><br>
 <? echo $tableString; ?>