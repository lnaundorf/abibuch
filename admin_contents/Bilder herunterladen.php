<div align="center">
<h1>Bilder herunterladen</h1>
</div>
<?
require('ValUser.php');

if($loggedin && $rights >= 10) {
	echo '<div style="font-size: 13pt; line-height: 125%">';
	echo 'Um einzelne von bestimmten Leuten herunterzuladen, geht man auf <a href="?s=admin_contents/Steckbrief.php">Steckbrief</a> und klickt dort nach der Namenswahl unten auf das gewünschte Bild.<br><br>';
	echo 'Um alle bisher hochgeladenen Bilder aller Personen auf einmal herunterzuladen, gibt es die Möglichkeit eine ZIP-Datei aller Bilder zu erstellen. Diese muss vor dem Herunterladen
	eventuell noch per Klick auf den Button aktualisiert werden, damit auch wirklich alle aktuellen Bilder enthalten sind.<br><br>';
	echo '<a href="downloadPictures.php?key='.sha1(date('d.m.Y')).'">LINK ZUR ZIP-DATEI</a><br>';
	if(!$_POST['createzip']) {
		echo 'Letztes Aktualisierungsdatum der ZIP-Datei aller Bilder: '.date('d.m.Y G:i:s', filemtime('../abibuch-zip/Bilder.zip'));
	}
	echo '<br><br></div>';
	echo '<form method="POST"><input id="but" class="btn primary" type="submit" value="ZIP-Archiv aktualisieren" name="createzip"></form>';
	
	if($_POST['createzip']) {
		set_time_limit(240);
		$zip = new ZipArchive();
		if(!$zip->open('../abibuch-zip/Bilder.zip', ZIPARCHIVE::OVERWRITE)) {
			echo 'Fehler beim erstellen der ZIP-Datei';
			exit();
		}
		
		$sql = "SELECT id, first_name, last_name, babybild_status, jetztbild_status FROM users WHERE rights <= 1 AND visible = 1";
		$query = mysql_query($sql);
		
		while($row = mysql_fetch_array($query)) {
			if($row['babybild_status'] > 0) {
				$filename = "../abibuch-bilder/original/babybilder/".$row['id'].".jpg";
				if(file_exists($filename)) {
					$zip->addFile($filename, "babybilder/".$row['first_name']."_".$row['last_name'].".jpg");
				}
			}
			
			if($row['jetztbild_status'] > 0) {
				$filename = "../abibuch-bilder/original/jetztbilder/".$row['id'].".jpg";
				if(file_exists($filename)) {
					$zip->addFile($filename, "aktuelle Bilder/".$row['first_name']."_".$row['last_name'].".jpg");
				}
			}
		}
		
		$zip->close();
		echo "<div style='font-size: 13pt; color: green'>Die ZIP-Datei wurde erfolgreich aktualisiert. Änderungsdatum: ".date('d.m.Y G:i:s').'</div>';
	}
}