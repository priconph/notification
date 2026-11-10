<?php

//file uploader this will transfer the file to the attachments folder inside the systemone then save its filename depending on the user that uploaded
session_start();
$userid= $_SESSION["truserid"];

		$path = '../notification2/attachments/'.$userid;
if ( ! is_dir($path)) {
    mkdir($path);
}	


if ($_FILES["file"]["error"] > 0)
	{
		//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		if (file_exists($_FILES["file"]["name"]))
		{
			//echo $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"], '../notification2/attachments/'.$userid.'/'.$_FILES["file"]["name"]);
			// move_uploaded_file($_FILES["file"]["tmp_name"], '../attachments/'.$userid.'/'.$_FILES["file"]["name"]);
			//echo "<script>alert(".$userid.");</script>";
		require_once ("notif_db.php");
		$connection = new notifDb();
		
		$filename=$_FILES["file"]["name"];
		$result=	$connection->getFiles();
		$sameFile=false;
		while($row = mysqli_fetch_array($result)){
		if($row["filename"]==$filename){
		$sameFile=true;
		}
		else{
		$sameFile=false;
		}
		}
		if($sameFile!=true){
			$result1 = $connection->addFile($userid,$filename);
		}
		
	}
	}

	
	ob_start(); // ensures anything dumped out will be caught

// do stuff here
$url = 'transfer.php'; // this can be set based on whatever

// clear out the output buffer
while (ob_get_status()) 
{
    ob_end_clean();
}

// no redirect
header( "Location: $url" );
?>