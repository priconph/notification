<?php
	//task delete
	require_once ("notif_db.php");
	$pkid=$_GET['pkid'];

	$connection = new notifDb();	
	
	$result = $connection->delTask($pkid);
	$result1 = $connection->delConfirm($pkid);
	
	$connection->close();			
?>