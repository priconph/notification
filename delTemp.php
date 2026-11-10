<?php
//deleting template and it also deletes the recievers on it in the database
	require_once ("notif_db.php");
	$pkid=$_GET['pkid'];

	$connection = new notifDb();	
	
	$result = $connection->delTemplate($pkid);
	$result1 = $connection->delTempRec($pkid);
	$connection->close();
?>