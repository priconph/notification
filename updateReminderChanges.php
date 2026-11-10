<?php

    require_once ("notif_db.php");
	$pkid=$_GET['pkid'];
	$alertsubj=$_GET['alertsubj'];
	$details=$_GET['details'];
	$recipient=$_GET['recipient'];
	$secondary=$_GET['secondary'];
	$startdate=date('Y/m/d', strtotime($_GET['startdate']));
	$enddate=date('Y/m/d', strtotime($_GET['enddate']));
	$filename=$_GET['filename'];

	$connection = new notifDb();	
	
	$result = $connection->updateReminderChanges($pkid,$alertsubj,$details,$recipient,$secondary,$startdate,$enddate,$filename);	
	
	$result2 = $connection->viewtask($pkid);	

	if($row = mysqli_fetch_array($result2))
	{
		if($row["status"]!="Confirmed"||$row["status"]!="Cancelled"){
			$result1= $connection->getAllConfirm($pkid);
			$email=explode(',',$row['recipient']);
			for($i=0; $i<sizeof($email); $i++){
				$check = $connection->checkTblConfirm($email[$i],$pkid);
				if($check->num_rows == 0) {
					$result2 = $connection->confirmRec($email[$i],$pkid);
				}
			}
		}
	}
	
	$connection->close();
?>