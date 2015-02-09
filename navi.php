<?
	require('ValUser.php');
?>
<a href="javascript:loadContent('start.php')"><strong>Startseite</strong></a><br><br>
<?

if ($loggedin AND $rights >= 0 AND $rights != 10) {
	echo '<a href="javascript:loadContent(\'ring3/Bilder hochladen.php\')"><strong>Bilder hochladen</strong></a><br><br>';
}

if($loggedin AND $rights >= 1 AND $rights != 10) {
	echo '<a href="javascript:loadContent(\'public_contents/Steckbrief.php\')"><strong>Steckbrief</strong></a><br>';
}
if($loggedin) {
	echo '<a href="javascript:loadContent(\'public_contents/Wer ist wer.php\')"><strong>Wer ist wer?</strong></a><br>';
}
if($loggedin AND $rights >= 1 AND $rights != 10) {
	echo '<a href="javascript:toggleVisibility(\'Wahlen\')" id="WahlenA"><strong>';
	if ($type == 'votes') {
		echo '&#x25BC;';
	} else {
		echo '&#x25B6;';
	}
	echo ' Wahlen</strong></a>';
	echo '<div class="subnavi" id="Wahlen"';
	
	if ($type == 'votes') {
		echo ' style="display: block"';
	}
	echo '>';
	
	echo '<a href="javascript:loadContent(\'wahlen/Schuelerwahlen.php\')"><strong>Schülerwahlen</strong></a><br>';
	echo '<a href="javascript:loadContent(\'wahlen/Paarwahlen.php\')"><strong>Paarwahlen</strong></a><br>';
	echo '<a href="javascript:loadContent(\'wahlen/Lehrerwahlen.php\')"><strong>Lehrerwahlen</strong></a><br>';
	echo '</div><br>';
	
	echo '<a href="javascript:toggleVisibility(\'Kommentare\')" id="KommentareA"><strong>';
	
	if ($type == 'comments') {
		echo '&#x25BC;';
	} else {
		echo '&#x25B6;';
	}
	echo ' Kommentare</strong></a>';
	echo '<div class="subnavi" id="Kommentare"';
	
	if ($type == 'comments') {
		echo ' style="display: block"';
	}
	echo '>';
	
	echo '<a href="javascript:loadContent(\'kommentare/Minikommentare.php\')"><strong>Minikommentare</strong></a><br>';
	echo '<a href="javascript:loadContent(\'kommentare/lange Kommentare.php\')"><strong>lange Kommentare</strong></a><br>';
	echo '</div><br>';
	echo '<a href="javascript:loadContent(\'public_contents/Sprueche.php\')"><strong>Lehrer-/Schülersprüche</strong></a><br>';
	echo '<a href="javascript:loadContent(\'public_contents/Gesamtuebersicht.php\')"><strong>Gesamtübersicht</strong></a><br>';
}

if ($loggedin AND $rights >= 10) {
	echo '<br>';
	
	echo '<a href="javascript:toggleVisibility(\'Auswerung Wahlen\')" id="Auswerung WahlenA"><strong>';
	if ($type == 'auswertung Wahlen') {
		echo '&#x25BC;';
	} else {
		echo '&#x25B6;';
	}
	echo ' Auswertung Wahlen</strong></a>';
	echo '<div class="subnavi" id="Auswerung Wahlen" style="margin-left: 5px';
	
	if ($type == 'auswertung Wahlen') {
		echo ';display: block';
	}
	echo '">';
	
	echo '<a href="?s=admin_contents/wahlen/Auswertung Wahlen.php"><strong>Ranking Schülerwahlen</strong></a><br>';
	echo '<a href="?s=admin_contents/wahlen/Schuelerwahlen.php"><strong>Schülerwahlen</strong></a><br>';
	echo '<a href="?s=admin_contents/wahlen/Paarwahlen.php"><strong>Paarwahlen</strong></a><br>';
	echo '<a href="?s=admin_contents/wahlen/Lehrerwahlen.php"><strong>Lehrerwahlen</strong></a><br>';
	echo '</div><br>';
	
	echo '<a href="javascript:toggleVisibility(\'Admin Kommentare\')" id="Admin KommentareA"><strong>';
	if ($type == 'Admin kommentare') {
		echo '&#x25BC;';
	} else {
		echo '&#x25B6;';
	}
	echo ' Admin Kommentare</strong></a>';
	echo '<div class="subnavi" id="Admin Kommentare" style="margin-left: 5px';
	
	if ($type == 'Admin kommentare') {
		echo ';display: block';
	}
	echo '">';
	
	echo '<a href="?s=admin_contents/kommentare/Anzahl Minikommentare.php"><strong>Anzahl Minikommentare</strong></a><br>';
	echo '<a href="?s=admin_contents/kommentare/Minikommentare.php"><strong>Minikommentare</strong></a><br>';
	echo '<a href="?s=admin_contents/kommentare/Fiese Minikommentare.php"><strong>Fiese Minikommentare</strong></a><br>';
	echo '<a href="?s=admin_contents/kommentare/Minikommentare formatiert.php"><strong>Minikommentare formatiert</strong></a><br>';
	echo '<a href="?s=admin_contents/kommentare/Anzahl lange Kommentare.php"><strong>Anzahl lange Kommentare</strong></a><br>';
	echo '<a href="?s=admin_contents/kommentare/lange Kommentare.php"><strong>lange Kommentare</strong></a><br>';
	echo '</div><br>';
	
	$Pfad = 'admin_contents';

	if($Verzeichniszeiger = opendir($Pfad)) {
		while($Datei = readdir($Verzeichniszeiger)) {
			if (substr($Datei, -3) == 'php') {
				echo '<a href="?s=admin_contents/'.$Datei.'" ><strong>'.substr($Datei, 0, strrpos($Datei, '.')).'</strong></a><br>';
			}
		}
		closedir($Verzeichniszeiger);
	}
}

if ($loggedin AND $rights >= 11) {
	echo '<br>';
	
	$Pfad = 'uberadmin_contents';

	if($Verzeichniszeiger = opendir($Pfad)) {
		while($Datei = readdir($Verzeichniszeiger)) {
			if ($Datei != "." && $Datei != "..") {
				echo '<a href="?s=uberadmin_contents/'.$Datei.'" ><strong>'.substr($Datei, 0, strrpos($Datei, '.')).'</strong></a><br>';
			}
		}
		closedir($Verzeichniszeiger);
	}
}

echo '<br><a href="javascript:loadContent(\'Fotos.php\')"><strong>Status der Fotos</strong></a><br>';
echo '<a href="javascript:loadContent(\'Kontakt.php\')"><strong>Kontakt</strong></a><br>';
echo '<a href="javascript:loadContent(\'FAQ.html\')"><strong>FAQ</strong></a><br>';

if(!$loggedin) {
	echo '<br><a href="javascript:loadContent(\'Login.php\')"><font color="gray"><strong>Login</strong></font></a>';
} else {
	echo '<br><a href="javascript:loadContent(\'public_contents/Passwort aendern.php\')"><strong>Passwort ändern</strong></a><br>';
	echo '<br><a href="?action=logout"><strong>Logout</strong></a>';
}
?>