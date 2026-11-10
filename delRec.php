<?php
//delete recipient of a specific template
	require_once ("notif_db.php");
	$pkid=$_GET['pkid'];

	$connection = new notifDb();	
	
	$result = $connection->delRecipient($pkid);
	
	$connection->close();
?>