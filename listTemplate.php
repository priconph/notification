<?php
//getting the list of the templates and populating the datalist for the subject of the task for choices.
    require_once ("notif_db.php");
	session_start();
	$userid= $_SESSION["truserid"];
	if($userid != '' || $userid != 0) {
		$connection = new notifDb();		
		$result = $connection->listTemplate($userid);
		while($row = mysqli_fetch_array($result))
		{
			echo'<option id="'.$row["pkid"].'" value="'.$row["subject"].'" ></option>';
		}

		$connection->close();
	} else {
		echo "<script>alert('Your session has expired. Please log in again!');</script>";
		echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
	}	
?>