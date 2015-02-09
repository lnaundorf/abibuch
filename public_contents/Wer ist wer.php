<div align="center">
<h1>Wer ist wer in meiner Stufe?</h1>
</div>
<?
	require('ValUser.php');
	$imagewidth = 200;
	
	if ($loggedin) {
		$sql = "SELECT first_name, last_name, id, jetztbild_status FROM users WHERE visible = 1 AND rights <= 1 ORDER by first_name, last_name";
		$query = mysql_query($sql);
		echo '<div style="font-size: 16pt; line-height: 100%"><br>Bewege die Maus über ein Bild, um eine vergrößerte Ansicht zu sehen.</div><br><br>';
		echo '<table><thead><tr><th>Name</th><th>Aktuelles Bild</th><th class="td-plain" width="1" bgcolor="#dddddd"></th><th>Name</th><th>Aktuelles Bild</th><th class="td-plain" width="1" bgcolor="#dddddd"></th><th>Name</th><th>Aktuelles Bild</th></tr></thead><tbody>';
		
		$i = 0;
		while ($user = mysql_fetch_array($query)) {
			$i++;
			if ($i % 3 == 1) {
				echo '<tr>';
			}
			echo '<td style="padding: 5px 5px 4px"><div style="font-size: 13pt; line-height: 125%">'.$user['first_name'].'<br>'.$user['last_name'].'</div></td><td style="padding: 4px 1px 4px">';
			
			if($user['jetztbild_status'] == 3) {
				if($user['id'] == $usrid) {
					$cacherandom = '&date='.(time() % 10000);
				} else {
					$cacherandom = '';
				}
				echo '<img id="img'.$user['id'].'" src="imageloader.php?type=2&size=small&id='.$user['id'].'&cache=1'.$cacherandom.'" width="'.$imagewidth.'"';
				echo ' onmouseover="ShowBigImage(this,'.$user['id'].', event, true)" onmousemove="moveImage(event, '.$user['id'].')" onmouseout="var child = document.getElementById('.$user['id'].');if(child){document.body.removeChild(child)}"';
				echo '></td>';
			} else {
				echo '<font color="red">noch kein aktuelles Bild</font>';
			}
			echo '</td>';
			
			if ($i % 3 == 0) {
				echo '</tr>';
			} else {
				echo '<td class="td-plain" width="1" bgcolor="#dddddd"><br></td>';
			}
		}
		echo '</tbody></table>';
	}
?>