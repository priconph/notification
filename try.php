<?php
//checking if task is overdue and changing its status when it is.
	//require_once("smtp_class.php");
	//require_once("smtp_config.php");

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

/*$today = strtotime('2014/07/14');
$after = strtotime('2014/07/13');

if ($today > $after ) {
  echo 'today is greater than later';
} 
else {
  echo 'not';
}


/*$today = new DateTime(date('Y/m/d'));
$after = new DateTime('2014/07/28');

if ($today < $after ) {
  echo 'yes';
} else if($today == $after) {
	echo "equals";
}
else {
  echo 'not';
}

echo "<br>";
$today = '2014/07/25';
$after = '2014/07/28';
$datetime1 = new DateTime($today);
$datetime2 = new DateTime($after);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%a days');
/*
	require_once('PHPMailerAutoload.php');
	require_once ('class.phpmailer.php');

$mail = new PHPMailer();
$mail->AddAddress('issinfoservice@pricon.ph');
$mail->SetFrom('issinfoservice@pricon.ph', 'Alert Notification System');
$mail->Subject = "Subject";
$mail->Body = "Body to";
$mail->AddAttachment('attachments/13/Capture2.JPG');
$mail->AddAttachment('attachments/13/file.txt');
$mail->Send();
*/
?>