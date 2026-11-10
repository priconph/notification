<?php
//checking if task is overdue and changing its status when it is.

    require_once ("notif_db.php");
	$connection = new notifDb();
	$result = $connection->getAllalert();
 
	$datetoday=date('Y/m/d');
	while($row = mysqli_fetch_array($result))
	{ 
		if($row["status"] != "Confirmed"){
			$datetoday=strtotime(date('Y/m/d'));
			$endDate=strtotime($row["enddate"]);
			if($row["status"]=="On-Going"){
				if($datetoday>$endDate){
					$result2 = $connection->overdueTask($row["pkid"]);
				}
			}
		}
	}

$connection->close();
?>