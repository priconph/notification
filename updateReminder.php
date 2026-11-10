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
		echo '<input type="text" id="txtSubjUpdate" class="form-control" placeholder="No Subject.."  value="'. $row["alertsubj"].'"  >';
		echo '<label>Select Recipient name:</label>
			<table><tr><td><input type="text" id="cmbRecipientUpdateName" style="width:300px"  class="form-control" list="emailList" autocomplete="off" name="cmbRecipientUpdateName"></td><td style="width:10px;"></td>
			<td><button type="button" onclick="addEmailAddRecipientUpdate()" class="btn btn-info">Add recipient</button></td></tr></table><br>
			<input type="text" id="cmbRecipientFieldUpdateName" class="form-control" data-role="tagsinput" required placeholder="Add Recipient E-mail" value="'. $row["recipient"].'"><br>';
		echo '<label>Select Secondary Recipient:</label>
			<table><tr><td><input type="text" id="cmbSecondaryRecipientUpdateName" style="width:300px"  class="form-control" list="emailList" autocomplete="off" name="cmbSecondaryRecipientUpdateName"></td><td style="width:10px;"></td>
			<td><button type="button" onclick="addEmailAddSecondaryRecipientUpdate()" class="btn btn-info">Add secondary recipient</button></td></tr></table><br>
			<input type="text" id="cmbSecondaryRecipientFieldUpdateName" class="form-control" data-role="tagsinput" required placeholder="Add Secondary Recipient E-mail" value="'. $row["secondary"].'"><br>';
		
		echo '<label for="from">Reminder Date</label><br>';
		echo 'From &nbsp;&nbsp;';
		echo '<input type="date" id="fromDateUpdate" value="'. date("Y-m-d",strtotime($row["startdate"])).'" min="'. date("Y-m-d",strtotime($row["startdate"])).'">&nbsp;&nbsp;';
		echo 'To&nbsp;&nbsp;';
		echo '<input type="date" id="toDateUpdate" value="'. date("Y-m-d",strtotime($row["enddate"])).'"  min="'. date("Y-m-d",strtotime($row["enddate"])).'">';

		echo '<br><br>';

		echo '<label for="txtAtt">Attachment</label><br>
			<select id ="fileListUpdate">
			</select>
			<button type="button" onclick="fileaddUpdate()">Add</button><br><br>';
		echo '<input type="text" id="txtAttUpdate" class="form-control" placeholder="Attachment"  value="'. $row["filename"].'"  >';
		echo '<label for="txtPass">Details</label><br>';
		echo '<textarea id="txtDetailsUpdate" rows="7" cols="75" style="resize: none;">'. $row["details"].' </textarea><br>';
					 
		//echo "<button type='button' class='btn btn-warning' onclick='loadconTable(".$pkid.")' data-dismiss='modal' data-toggle='modal' data-target='#displayModalrec'><span class='glyphicon glyphicon-user'></span> Recipients</button>";
		echo '</div>';

		echo '<div class="modal-footer">';
		//if($row["status"]=="Confirmed"){
		//	echo '<button type="button" class="btn btn-warning" onclick="unconTask('.$pkid.')">Reopen Task</button>';
		//} else if($row["status"]=="Cancelled"){
		//	echo '<button type="button" class="btn btn-warning" onclick="uncancelTask('.$pkid.')">Reopen Task</button>';
		//} else{
		//	echo '<button type="button" class="btn btn-success" onclick="updateReminder('.$pkid.')">Update</button>';
		//	echo '<button type="button" class="btn btn-success" onclick="conTask('.$pkid.')">Confirm</button>';
		//	echo '<button type="button" class="btn btn-warning" onclick="cancelTask('.$pkid.')">Cancel</button>';
		//}
		//echo '<button type="button" class="btn btn-danger" onclick="delTask('.$pkid.')">Delete</button>';
		echo '<button type="button" class="btn btn-success" onclick="updateReminderChanges('.$pkid.')">Save Changes</button>';		
		echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
				
		echo '</div>';
 }

$connection->close();
?>