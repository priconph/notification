<?php
//Getting all the reciever of the chosen Template

$pkid=$_GET['pkid'];
$name="";
$email="";

        require_once ("notif_db.php");


		$connection = new notifDb();
		$result = $connection->getAllRecipient($pkid);

while($row = mysqli_fetch_array($result))
  {
  $name .=$row["recievername"].",";
  $email .=$row["email"].",";
  }
  
$connection->close();
?>