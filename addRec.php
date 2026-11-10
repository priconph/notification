<?php

//adding a recipient that was added to template into the database
	require_once ("notif_db.php");
	$name=$_GET['name'];
	$email=$_GET['email'];
	$tempid=$_GET['pkid'];

	$connection = new notifDb();
	
	$result = $connection->checkRec($name,$email,$tempid);
	while($row=mysqli_fetch_array($result)) {
		$count = $row["ROW"];
	}
	if($count == 0) {
		$result = $connection->addRec($name,$email,$tempid);
	}
	$connection->close();

?>