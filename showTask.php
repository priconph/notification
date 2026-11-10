<?php
//this for populating the modal box of a specific task that was click on the table
	$pkid=$_GET['pkid'];
	require_once ("notif_db.php");
	$connection = new notifDb();		
	$result = $connection->viewtask($pkid);	

	if($row = mysqli_fetch_array($result))
	{
		if($row["status"]!="Confirmed"||$row["status"]!="Cancelled"){
			$result1= $connection->getAllConfirm($pkid);
			if($row1 = mysqli_fetch_array($result1))
			{
			} else{
			  $email=explode(',',$row['recipient']);
				for($i=0; $i<sizeof($email); $i++){
					if($email[$i]!=$row1['email']){
						//$result2 = $connection->confirmRec($email[$i],$pkid);
						$check = $connection->checkTblConfirm($email[$i],$pkid);
						if($check->num_rows == 0) {
							$result2 = $connection->confirmRec($email[$i],$pkid);
						} 
					}
				}
			}
		}
		  
		$statlabel="default";
		if($row["status"]=="Confirmed"){
			$statlabel="success";
		} else if($row["status"]=="Overdue"){
			$statlabel="danger";
		} else if($row["status"]=="On-Going"){
			$statlabel="info";
		} else if($row["status"]=="Cancelled"){
			$statlabel="warning";
		}
		echo '<div class="modal-body">';
		echo '<label for="txtSubj">Task Subject <span class="label label-'.$statlabel.'">'.$row["status"].'</span></label>';
		echo '<input type="text" id="txtSubj" class="form-control" disabled readonly placeholder="No Subject.."  value="'. $row["alertsubj"].'"  >';
		echo '<label for="txtRecip">Recipient</label>';
		echo '<input type="text" id="txtRecip" class="form-control" disabled readonly placeholder="No Recipient.."  value="'. $row["recipient"].'"  >';
		echo '<label for="txtSec">Secondary</label>';
		echo '<input type="text" id="txtSec" class="form-control" disabled readonly placeholder="No Secondary Recipient.."  value="'. $row["secondary"].'"  >';
		echo '<label for="from">Reminder Date</label><br>';
		echo 'From &nbsp;&nbsp;';
		echo '<input type="text" name="date" id="fromDate" disabled  readonly placeholder="No Start Date.." value="'. $row["startdate"].'" >&nbsp;&nbsp;';
		echo 'To&nbsp;&nbsp;';
		echo '<input type="text" name="date" id="toDate" disabled   readonly placeholder="No End Date.."   value="'. $row["enddate"].'" >';

		echo '<br><br>';

		echo '<label for="txtAtt">Attachment</label><br>';
		echo '<input type="text" id="txtAtt" class="form-control" disabled readonly placeholder="No attached File.."  value="'. $row["filename"].'"  >';
		echo '<br><br>';

		echo '<label for="txtPass">Details</label><br>';
		echo '<textarea  rows="7" cols="75" disabled readonly style="resize: none;">'. $row["details"].' </textarea><br>';
					 
		echo "<button type='button' class='btn btn-warning' onclick='loadconTable(".$pkid.")' data-dismiss='modal' data-toggle='modal' data-target='#displayModalrec'><span class='glyphicon glyphicon-user'></span> Recipients</button>";
		echo '</div>';

		echo '<div class="modal-footer">';
		if($row["status"]=="Confirmed"){
			echo '<button type="button" class="btn btn-warning" onclick="unconTask('.$pkid.')">Reopen Task</button>';
		} else if($row["status"]=="Cancelled"){
			echo '<button type="button" class="btn btn-warning" onclick="uncancelTask('.$pkid.')">Reopen Task</button>';
		} else{
			echo '<button type="button" class="btn btn-primary" onclick="updateReminder('.$pkid.')">Enable update</button>';
			echo '<button type="button" class="btn btn-success" onclick="conTask('.$pkid.')">Confirm</button>';
			echo '<button type="button" class="btn btn-warning" onclick="cancelTask('.$pkid.')">Cancel</button>';
		}
		echo '<button type="button" class="btn btn-danger" onclick="delTask('.$pkid.')">Delete</button>';
				
		echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				
		echo '</div>';
 }

$connection->close();
?>