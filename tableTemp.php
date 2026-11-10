<?php
//this is for populating the template table
	session_start();
	$userid= $_SESSION["truserid"];
	if($userid != '' || $userid != 0) {
		echo'<tr>';
		echo'<th>ID</th>';
		echo'<th>Task Subject</th>';
		echo'<th>Details</th>';
		echo'<th>Date Created</th>';
		echo'<th>Date Updated</th>';

        require_once ("notif_db.php");

		$connection = new notifDb();
		$result = $connection->getUsertemplate($userid);

		while($row = mysqli_fetch_array($result))
		{
			 echo "<tr onclick='openEditform(".$row['pkid'].",".$row['userid'].")'>";
			 echo "<td  >".$row['userid']."-".$row['pkid']."</td><td>".substr($row['subject'],0,30)."</td><td >".substr($row['details'],0,30)."...</td><td>".$row['dateCreated']."</td><td>".$row['dateUpdated']."</td>";
			 echo "</tr>";
		}

		$connection->close();
	} else {
		echo "<script>alert('Your session has expired. Please log in again!');</script>";
		echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
	}
?>