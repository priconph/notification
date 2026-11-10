<?php
        //adding of template
		session_start();
		echo $userid= $_SESSION["truserid"];
		if($userid != '' || $userid != 0) {
			$subj=$_GET['subj'];
			$det=$_GET['det'];
			require_once ("notif_db.php");

					$connection = new notifDb();
					$result = $connection->addTemp($subj,$det,$userid);

			$connection->close();
		} else {
			echo "<script>alert('Your session has expired. Please log in again!');</script>";
			echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
		}
			

?>