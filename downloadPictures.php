<?
if($_GET['key'] == sha1(date('d.m.Y'))) {
	$filename = '../abibuch-zip/Bilder.zip';
	if(file_exists($filename)) {
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="Bilder.zip"');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
	} else {
		echo "file does not exist";
	}
} else {
	echo "wrong key";
}
?>