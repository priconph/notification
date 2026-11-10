<?php
//this for populating the modal box of a specific template that was click on the table
	require_once ('notif_db.php');
	$pkid=$_GET["pkid"];
	$connection = new notifDb();
	
	$result = $connection->viewTemplate($pkid);

	if($row = mysqli_fetch_array($result))
	{
		echo "<div class='modal-body'>";
		echo "<label for='txtSubj'>Template Task Subject</label>";
		echo "<input type='text' id='txtSubj' class='form-control' disabled  placeholder='Enter Subject...'  value='".$row['subject']."'> <br>";
		echo "<label for='from'>Date Created</label><br>";
		echo "<input type='text' class='form-control' name='date' id='fromDate' disabled  readonly placeholder='Start Date..' value='". $row['dateCreated']."'> <br>";
		echo "<label for='txtPass'>Template Details</label><br>";
		echo "<textarea  rows='7' cols='75' disabled style='resize: none;'>". $row['details']." </textarea><br>";
					 
		echo "</div>";

		echo "<div class='modal-footer'>";
		echo "<button type='button' class='btn btn-warning' onclick='loadrcpTable(".$pkid.")' data-dismiss='modal' data-toggle='modal' data-target='#displayModalrec'><span class='glyphicon glyphicon-user'></span> Recipients</button>";
		echo "<button type='button' class='btn btn-danger' onclick='delTemp(".$pkid.")'><span class='glyphicon glyphicon-remove'></span> Delete</button>";
			   // displayRecip onclick='addRec(".$pkid.")
		echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
				
		echo "</div>";
	}

	$connection->close();
?>