<table>
<?php

$Pfad = $_GET['s'];

if($Verzeichniszeiger = opendir($Pfad)) {
    while($Datei = readdir($Verzeichniszeiger)) {
        if ($Datei != "." && $Datei != "..") {
		echo '<tr><td><a href="?s='.$_GET['s'].'/'.$Datei.'" >'.substr($Datei, 0, strrpos($Datei, '.')).'</a></td></tr>';
        }
    }
    closedir($Verzeichniszeiger);
} 
?>
</table>
