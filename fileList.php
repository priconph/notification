<?php
//getting all the file names that the user has uploaded and putting it in a combobox
	require_once ("notif_db.php");
	session_start();
	$userid= $_SESSION["truserid"];
	if($userid != '' || $userid != 0) {
		$connection = new notifDb();
		
		$result = $connection->getuserFiles($userid);
		echo'<option value=""></option>';
		while($row = mysqli_fetch_array($result))
		{
			echo'<option id="'.$row["pkid"].'" value="'.$row["filename"].'" >'.$row["filename"].'</option>';
		}

		$connection->close();
	} else {
		echo "<script>alert('Your session has expired. Please log in again!');</script>";
		echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
	}
?>