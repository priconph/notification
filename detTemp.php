<?php

//populating the textarea with the details of a template that was chosen
	require_once ("notif_db.php");
	$pkid=$_GET['pkid'];
	$connection = new notifDb();
	
	$result = $connection->getSubDet($pkid);
	$details="";
	if($row = mysqli_fetch_array($result))
	{
		$details = $row['details'];
	} else{
		$details="";
	}
	echo $details;

	$connection->close();
?>