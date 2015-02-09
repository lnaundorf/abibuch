<div align="center">
<h1>Bilder hochladen</h1>
</div>

<?php
	require('ValUser.php');
	require('actionLog.php');
	
	if ($loggedin) {
		if ($_POST['completed'] && ($_POST['type'] == 1 || $_POST['type'] == 2)) {
			if (($_FILES['imagefile']['type'] != 'image/jpeg') AND ($_FILES['imagefile']['type'] != 'image/pjpeg')) {
				//boese
				$message = 'Deine Ausgewählte Datei ist kein gültiges JPG-Bild oder die Datei ist zu groß';
				$success = false;
			} elseif (exif_imagetype($_FILES['imagefile']['tmp_name']) != IMAGETYPE_JPEG) {
				$message = 'Deine ausgewählte Datei ist kein gültiges JPG-Bild';
				$success = false;
			} else {
				if ($_FILES['imagefile']['size'] > 5242880) {
					$message = 'Dein Bild ist zu groß';
					$sucess = false;
				} else {
					if ($_POST['type'] == 1) {
						$dir = 'babybilder';
					} else {
						$dir = 'jetztbilder';
					}
				
					move_uploaded_file($_FILES['imagefile']['tmp_name'], "../abibuch-bilder/original/".$dir."/".$usrid.".jpg");
					/*
					if($usrvisible && $rights <= 1) {
						$newloc = "../abibuch-bilder/ftp-dir/".$dir."/".$first_name."_".$last_name.".jpg";
						if(copy("../abibuch-bilder/original/".$dir."/".$usrid.".jpg", $newloc)) {
							//echo 'copy OK ';
						}
					}
					*/
					createMiniature($usrid, $_POST['type']);
					
					logAction($usrid, "Bild hochgeladen. Typ: ".$_POST['type']);

					if($_POST['type'] == 1) {
						$field = "babybild_status";
						
						if ($baby_status >= 0 && $baby_status <= 2 ){
							$updateval = $baby_status = 1;
						} elseif ($baby_status == 3){
							$updateval = 3;
						}
					} else {
						$field = "jetztbild_status";
						
						if ($jetzt_status >= 0 && $jetzt_status <= 2 ){
							$updateval = $jetzt_status = 1;
						} elseif ($jetzt_status == 3){
							$updateval = 3;
						}
					}
						
					$sql = "UPDATE users SET ".$field." = ".$updateval." WHERE id = ".$usrid." LIMIT 1";
					$result = mysql_query($sql);
					
					$message = "Dein Bild wurde erfolgreich hochgeladen";
					$success = true;
				}
			}
			if(!$success){
				echo '<div id="tooltip" class="alert-message error"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Fehler: </strong>'.$message.'</p></div>';
			} else {
				echo '<div id="tooltip" class="alert-message success"><a class="close" href="javascript:removett(\'tooltip\')">×</a><p><strong>Erfolg: </strong>'.$message.'</p></div>';
			}
		}
		

		echo '<div style="font-size: 13pt"><br><br><br>Hier kannst du deine Bilder hochladen. Bitte lade diese im .jpg Format hoch. Die maximale Dateigröße beträgt 5 Megabyte.<br><br></div>';
		
		//section Babybild
		echo '<h2>Babybild</h2>';
		if ($baby_status >= 1) {
			if($baby_status == 1) {
				//pending
				echo '<font color="orange">Dein babybild wurde noch nicht freigeschaltet</font>';
			} elseif($baby_status == 2) {
				//blocked
				echo '<font color="red">Dein Babybild wurde nicht akzeptiert. Bitte lade ein anderes Bild hoch, auf dem du wirklich bzw. deutlich zu sehen bist.</font>';
			} elseif($baby_status == 3) {
				//freigeschaltet
				echo '<font color="green">Dein Babybild wurde freigeschaltet</font>';
			}  else {
				echo '<font color="red">Es ist ein Fehler aufgetreten</font>';
			}
			echo '<br><br>';
			
			echo 'Dein zurzeit gewähltes Babybild: <br><br>';
			echo '<img src="imageloader.php?type=1&id='.$usrid.'&size=small" width=400><br><br>';
			echo 'Beim Hochladen eines neuen Bildes wird ein eventuell vorhandenes Babybild überschrieben';
		} else {
			echo '<br><br><font color="red" size="4">Du hast bisher noch kein Babybild hochgeladen</font><br><br>';
		}
		
		
		echo '<form name="baby" enctype=multipart/form-data method="post" action="?s=ring3/Bilder hochladen.php" onsubmit=disable1()>';
		echo '<input type=hidden name=MAX_FILE_SIZE value=6000000>';
		echo '<input type=hidden name=completed value=1>';
		echo '<input type=hidden name=type value=1>';
		echo '<input class="input-file" type="file" name="imagefile"><br>';
		echo '<input class="btn primary" name="button1" type="submit" value="Babybild Hochladen"></form>';
		echo '<br><br>';
		
		//section aktuelles Bild
		echo '<h2>Aktuelles Bild</h2>';
		echo '<font color="red" size="4">Bitte beachte: Dein aktuelles Bild erscheint auf der "Wer ist Wer?"-Seite und ist von jedem 
		Schüler der Stufe einsehbar. Achte deshalb bitte darauf, dass du ein Bild hochlädst, das jeder sehen darf und auf dem 
		du wirklich und deutlich zu sehen bist.</font><br><br>';
		if ($jetzt_status >= 1) {
			if($jetzt_status == 1) {
				//pending
				echo '<font color="orange">Dein Aktuelles Bild wurde noch nicht freigeschaltet</font>';
			} elseif($jetzt_status == 2) {
				//blocked
				echo '<font color="red">Dein aktuelles Bild wurde nicht akzeptiert. Bitte lade ein anderes Bild hoch, auf dem du wirklich bzw. deutlich zu sehen bist.</font>';
			} elseif($jetzt_status == 3) {
				//freigeschaltet
				echo '<font color="green">Dein aktuelles Bild wurde freigeschaltet</font>';
			}  else {
				echo '<font color="red">Es ist ein Fehler aufgetreten</font>';
			}
			echo '<br><br>';
			
			echo 'Dein zurzeit gewähltes aktuelles Bild: <br><br>';
			echo '<img src="imageloader.php?type=2&id='.$usrid.'&size=small" width=400><br><br>';
			echo 'Beim Hochladen eines neuen Bildes wird ein eventuell vorhandenes aktuelles Bild überschrieben';
		} else {
			echo '<br><br><font color="red" size="4">Du hast bisher noch kein aktuelles Bild hochgeladen</font><br><br>';
		}
		
		
		echo '<form name="aktuell" enctype=multipart/form-data method="post" action="?s=ring3/Bilder hochladen.php" onsubmit=disable2()>';
		echo '<input type=hidden name=MAX_FILE_SIZE value=6000000>';
		echo '<input type=hidden name=completed value=1>';
		echo '<input type=hidden name=type value=2>';
		echo '<input class="input-file" type="file" name="imagefile"><br>';
		echo '<input class="btn primary" name="button2" type="submit" value="Aktuelles Bild Hochladen"></form>';
	}
	
	function createminiature($id, $type) {
		$smallwidth = 400;
		//$tinywidth = 135;
		
		if ($type == 1) {
			$dir = "babybilder";
		} elseif ($type == 2){
			$dir = "jetztbilder";
		} else {
			return;
		}
		
		$filename = "../abibuch-bilder/original/".$dir."/".$id.".jpg";
		if(file_exists($filename)) {
			include("SimpleImage.php");
			$image = new SimpleImage();
			$image->load($filename);

			if(($image->getWidth()) > $smallwidth) {
				$image->resizeToWidth($smallwidth);
			}
			$image->save("../abibuch-bilder/small/".$dir."/".$id.".jpg");

			/*
			if(($image->getWidth()) > $tinywidth) {
				$image->resizeToWidth($tinywidth);
			}
			$image->save("../abibuch-bilder/tiny/".$dir."/".$id.".jpg");*/
		}
	}
	
	function remove_accents($text) {
		return strtr($text,
		"\xe1\xc1\xe0\xc0\xe2\xc2\xe4\xc4\xe3\xc3\xe5\xc5".
		"\xaa\xe7\xc7\xe9\xc9\xe8\xc8\xea\xca\xeb\xcb\xed".
		"\xcd\xec\xcc\xee\xce\xef\xcf\xf1\xd1\xf3\xd3\xf2".
		"\xd2\xf4\xd4\xf6\xd6\xf5\xd5\x8\xd8\xba\xf0\xfa".
		"\xda\xf9\xd9\xfb\xdb\xfc\xdc\xfd\xdd\xff\xe6\xc6\xdf",
		"aAaAaAaAaAaAacCeEeEeEeEiIiIiIiInNoOoOoOoOoOoOoouUuUuUuUyYyaAs");
	}
?>
