<?
//require('ValUser.php');

if($_GET['id'] && $_GET['type']) {
	if ($_GET['type'] == 1) {
		$dirtype = "babybilder";
	} elseif ($_GET['type'] == 2) {
		$dirtype = "jetztbilder";
	} else {
		return;
	}
	
	if ($_GET['size'] == "small") {
		$dirsize = "small";
	} elseif ($_GET['size'] == "tiny") {
		$dirsize = "tiny";
	} else {
		$dirsize = "original";
	}
	
	$filename = "../abibuch-bilder/".$dirsize."/".$dirtype."/".$_GET['id'].".jpg";
	if(file_exists($filename)) {
		$size = filesize($filename);
		$date = filemtime($filename);
		
		header("Content-Type: image/jpeg");
		header("Content-Length: " .$size);
		header("Last-Modified: ".gmdate("D, d M Y H:i:s",$date)." GMT");
		
		if(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $date) {
			header("HTTP/1.1 304 Not Modified");
			exit;
		}
		
		if ($_GET['action'] == 'download') {
			header("Content-Disposition: Attachment;filename=".$_GET['first']."_".$_GET['last'].".jpg");
		}
		if($_GET['cache'] == '1') {
			header("Cache-Control: public, max-age=1200, s-maxage=1200");
		}
		readfile($filename);
	} else {
		header("HTTP/1.1 404 Not Found");
	}
} else {
	header("HTTP/1.1 404 Not Found");
}
?>