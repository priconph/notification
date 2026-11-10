<?php
//function of adding the confirmed recipient to the database
$alertid=$_GET['alertid'];
$recip=$_GET['rec'];
require_once ("notif_db.php");
		 $email=explode(",",$recip);
		$connection = new notifDb();
		 for($i=0; $i<sizeof($email); $i++){
		$result = $connection->confirmRec($email[$i],$alertid);
		echo "dto";
		}

$connection->close();

?>