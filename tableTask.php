<?php
//this is for populating the task table depending on its user
	session_start();
	$userid= $_SESSION["truserid"];
	if($userid == '' || $userid == 0) {
		echo "<script>alert('Your session has expired. Please log in again!');</script>";
		echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
	} else {
		echo '<thead>';
		echo'<tr>';
		echo'<th>Task Subject</th>';
		echo'<th>Details</th>';
		echo'<th>Recipient</th>';
		echo'<th>Start Date</th>';
		echo'<th>End Date</th>';
		echo'<th>Date Created</th>';
		echo'<th>Confirmation</th>';
		echo'<th>Status</th>';
		echo '</thead>';

		require_once ("notif_db.php");

		$connection = new notifDb();
	
		$result = $connection->getUseralert($userid);
		$status="";
		echo '<tbody>';
		while($row = mysqli_fetch_array($result))
		{
			$status =$row['status'];
			if($status=="On-Going") {
				$status="<td class='alert alert-info'>".$row['status']."</td>";
			} else if($status=="Confirmed"){
				$status="<td class='alert alert-success'>".$row['status']."</td>";
			} else if($status=="Overdue"){
				$status="<td class='alert alert-danger'>".$row['status']."</td>";
			} else if($status=="Cancelled"){
				$status="<td class='alert alert-warning'>".$row['status']."</td>";
			}
			echo "<tr onclick='openEditform(".$row['pkid'].")'>";
			echo "<td>".substr($row['alertsubj'],0,30)."</td><td>".substr($row['details'],0,30)."</td><td>".substr($row['recipient'],0,30)."...</td><td>".$row['startdate']."</td><td>".$row['enddate']."</td><td>".$row['datecreated']."</td><td>".$row['dateconfirm']."</td>".$status;
			echo "</tr>";
			 
			$pkid = $row['pkid'];
			$selectAllPKID = $connection->viewtask($pkid);
			if($rowPKID = mysqli_fetch_array($selectAllPKID))
			{
				if($rowPKID["status"] != "Confirmed" || $rowPKID["status"] != "Cancelled"){
					$result1= $connection->getAllConfirm($pkid);
					if($row1 = mysqli_fetch_array($result1))
					{
					} else{
					  $email=explode(',',$rowPKID['recipient']);
						for($i=0; $i<sizeof($email); $i++){
							if($email[$i]!=$row1['email']){
								$check = $connection->checkTblConfirm($email[$i],$pkid);
								if($check->num_rows == 0) {
									$result2 = $connection->confirmRec($email[$i],$pkid);
								} 
							}
						}
					}
				}
			}
		}
		echo '</tbody>';

		$connection->close();
	}
?>