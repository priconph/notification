<?php
//the table for recipients inside the template
	$pkid=$_GET['pkid'];
	echo'<tr>';
	echo'<th>ID</th>';
	echo'<th>Name</th>';
	echo'<th>E-Mail</th>';
	echo'</tr>';
	require_once ("notif_db.php");
	$connection = new notifDb();
	
	$result = $connection->getAllRecipient($pkid);

	while($row = mysqli_fetch_array($result))
	  {
		 echo "<tr>";
		 echo "<td >".$row['pkid']."</td><td>".$row['recievername']."</td><td >".$row['email']."</td> <td>
		 <button class='btn btn-danger' onclick='delRec(".$row['pkid'].")' ><span class='glyphicon glyphicon-remove'></span> Delete</button></td>";
		 echo "</tr>";
	 }
	 
	$connection->close();
?>