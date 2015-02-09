<?
require('ValUser.php');

if($loggedin && $rights >= 11) {
	$sql = "SELECT id, first_name FROM users";
	$query = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($query)) {
		echo 'id: '.$row['id'].', first_name: "'.$row['first_name'].'" ';
		if(substr($row['first_name'], -1) == " ") {
			$new_name = substr($row['first_name'], 0, strlen($row['first_name']) - 1);
			echo 'space -> "'.$new_name.'"';
			/*$sql2 = "UPDATE users SET first_name = '".$new_name."' WHERE id = ".$row['id']." LIMIT 1";
			$result = mysql_query($sql2);
			if($result) {
				echo " success";
			} else {
				echo " fail";
			}*/
		} else {
			echo "OK";
		}
		echo "<br>";
	}
} else {
	echo "no rights";
}
?>