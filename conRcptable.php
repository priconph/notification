<?php

//getting the if the recipient of a specific task is done or ongoing then display in the modal box

	$pkid=$_GET['pkid'];
	echo'<tr>';
	echo'<th>E-Mail</th>';
	echo'<th>Status</th>';
	echo'<th></th>';
	echo'</tr>';
	require_once ("notif_db.php");
	$connection = new notifDb();
	
	$result =$connection->getAllConfirm($pkid);

	while($row = mysqli_fetch_array($result))
	{
		$status="";
		echo "<tr>";
		echo "<td >".$row['email']."</td> ";
		
		if($row['status']=="On-Going") {
			echo"<td class='alert alert-info'>".$row['status']."</td>";
			echo " <td> <button class='btn btn-success' onclick='conRec(".$row['pkid'].",1,".$pkid.")' ><span class='glyphicon glyphicon-ok'></span> Done</button></td>";
		} else if($row['status']=="Done") {
			echo"<td class='alert alert-success'>".$row['status']."</td>";
			echo " <td> <button class='btn btn-warning' onclick='conRec(".$row['pkid'].",2,".$pkid.")' ><span class='glyphicon glyphicon-ok'></span>Continue</button></td>";
		}
		echo "</tr>";
	}
 
	$connection->close();
?>




