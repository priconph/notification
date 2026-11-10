<?php
//adding the recipients email to the task modal
	require_once ("notif_db.php");
	$tempid=$_GET['tempid'];
	$connection = new notifDb();
	
	$result = $connection->getTempRcp($tempid);
	$x="";
	while($row = mysqli_fetch_array($result))
	{
		if($x!=""){
			$x.=",";
		}
		$x.=$row["email"];
	}
	echo $x;

	$connection->close();
?>