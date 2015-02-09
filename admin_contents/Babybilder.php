<div align="center">
<h1>Übersicht über alle Babybilder</h1>
</div>
<?
	require('ValUser.php');
	
	if ($loggedin AND $rights >= 10) {
		
		$sql = "SELECT first_name, last_name, id, babybild_status FROM users WHERE visible = 1 AND rights <= 1 ORDER by first_name, last_name";
		$query = mysql_query($sql);
		echo '<table border="1"><tr><td>Name</td><td>Babybild</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Name</td><td>babybild</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Name</td><td>Babybild</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
		
		$i = 0;
		while ($user = mysql_fetch_array($query)) {
			$i++;
			if ($i % 3 == 1) {
				echo '<tr>';
			}
			echo '<td>'.$user['first_name'].' <br>'.$user['last_name'].'</td><td>';
			
			if($user['babybild_status'] >= 1) {
				echo '<img src="imageloader.php?type=1&id='.$user['id'].'&size=small" width="150"></td>';
			} else {
				echo '<font color="red">noch kein Babybild</font>';
			}
			echo '</td>';
			
			if ($i % 3 == 0) {
				echo '</tr>';
			} else {
				echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
			}
		}
		echo '</table>';
	}
?>