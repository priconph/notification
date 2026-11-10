<?php
    //checking the user existence
	session_start();
	$userid= $_SESSION["truserid"];
	// echo $userid;
	if($userid == '' || $userid == 0) {
		echo "<script>alert('Your session has expired. Please log in again!');</script>";
		echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
	}
	require_once('../Clinic/subcon-oop.php');
	$getEmailAddresses = SUBCON::getInstance()->getAllEmailAddress(); //get all item details from table tbl_items
	echo '<datalist id="emailList">';
	while ($row = mysqli_fetch_array($getEmailAddresses)){
		$name =  $row['LastName'].','. $row['FirstName'];
		//echo '<option value='.$name.'>'.$row['email_add'].'</option>';
		echo '<option>'.$name.'</option>';
	}
	echo '</datalist>';
	//print_r($_SESSION) ;		
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Task Reminder</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="DatePicker/jquery-1.10.2.js"></script>
<script src="DatePicker/jquery-ui.js"></script>		
<script src="js/jquery.dataTables.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="DatePicker/jquery-ui.css">
<link rel="stylesheet" href="css/demo_table.css">		
<link rel="stylesheet" href="css/bootstrap-tagsinput.css">		
		
<script>
	$(document).ready(function () {
		$('#btnExportToExcel').click(function () {
			var category = $('#cmbReportCategory').val();
			var startdate = $('#cmbStartDateReport').val();
			var enddate = $('#cmbEndDateReport').val();
			//alert(category+startdate+enddate);
			window.location.href = "reminderReport.php?keyword="+category+"&startdate="+startdate+"&enddate="+enddate;
		});
	});


//jquery function for DatePicker
	$(function() {
			$( "#fromDate" ).datepicker({
			dateFormat: 'yy/mm/dd',
			minDate: 0,
			maxDate: '+30Y'}).datepicker("setDate", "0");
	});
	$(function() {
			$( "#toDate" ).datepicker({
			dateFormat: 'yy/mm/dd',
			minDate: 0,
			maxDate: '+30Y'}).datepicker("setDate", "0");
	});

	function rmdclear(){
		document.getElementById("AlertSubj").value="";
		document.getElementById("fromDate").value="";
		document.getElementById("toDate").value="";
		document.getElementById("AlertDet").value="";
	}

	//function using ajax for adding new reminder		
	function addRemajax(){
		var subj= encodeURIComponent(document.getElementById("AlertSubj").value);
		var recip=document.getElementById("AlertRec").value;
		var sec=$("#AlertSec").val();
		var sdate=document.getElementById("fromDate").value;
		var edate=document.getElementById("toDate").value;
		var det=encodeURIComponent(document.getElementById("AlertDet").value);
		var att=document.getElementById("txtAtt").value;
		var userid="<?php echo $userid; ?>";

		det = det.replace(/\n/g, '\\r\\n');
		//det = det.replace("#", '[asterisk]');
		//det = det.replace("&", '[ampersand]');
		
		console.log(`subj: ${subj} \n det: ${det}  \n sdate: ${sdate}  \n edate: ${edate}  \n recip: ${recip}`);
		// if(subj=="" || det=="" || sdate==""||edate==""||recip==""){
		// if(subj=="" || det=="" || sdate==""||edate==""||recip==""||att==""){
		if(subj=="" || det=="" || sdate==""||edate==""||recip==""){ // 12122025
			// alert("Please complete all the fields! Subject, Details, Recipient, Start Date, End Date and Attachment are required.");
			alert("Please complete all the fields! Subject, Details, Recipient, Start Date, End Date are required.");
		} else{
			//alert(userid);
			$.ajax({url:"addTask.php?subj="+subj+"&det="+det+"&recip="+recip+"&sec="+sec+"&sdate="+sdate+"&edate="+edate+"&att="+att+"&trususerid="+userid,success:function(result){
				loadTable();
				alert("Reminder Added!");
				rmdclear();
				document.getElementById('displayModalClose').click();
			}});
		}
		
	}
			
	//opening modal and getting reminder info
	function openEditform(pkid){
		document.getElementById("buttonViewInfo").click();
		$.ajax({url:"showTask.php?pkid="+pkid,success:function(result){
			$("#divViewrem").html(result);
		}});
		document.getElementById("pid").value=pkid;
	}

	//datalist for template choices
	function addDatalist(){
		$.ajax({url:"listTemplate.php?",success:function(result){
		  $("#tempOpt").html(result);
		}});
		fileDatalist();
	}

	//loading table of reminder 
	function loadTable(){
		$.ajax({url:"tableTask.php",success:function(result){
		  $("#taskTable").html(result);
		}
		});
	}
	//list of files for the user
	function fileDatalist(){
		$.ajax({url:"fileList.php",success:function(result){
		 $("#fileList").html(result);
		}
		});
	}
	
	//getting template details
	function getTempDetails(){
		var x = $('#AlertSubj').val();
		var z = $('#tempOpt');
		var val = $(z).find('option[value="' + x + '"]');
		var pkid = val.attr('id');
		var check ="";
		$.ajax({url:"detTemp.php?pkid="+pkid,success:function(result){
			check = $.trim(result);
			if(check!=""){
				document.getElementById("AlertDet").value=$.trim(check);
			}
		}});
		
		$.ajax({url:"rcpTemp.php?tempid="+pkid,success:function(result){
			//$('.bootstrap-tagsinput').html(result);
			$('#AlertRec').tagsinput('add', result);
		}});
	}


	//deleting reminder
	function delTask(pkid){
	   $.ajax({url:"delTask.php?pkid="+pkid,success:function(result){
			alert("Reminder Deleted!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
		}
		//cancelation of task
		function cancelTask(pkid){
	   $.ajax({url:"cancelTask.php?pkid="+pkid,success:function(result){
			alert("Task Canceled!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
		
	}

	//update reminder
	function updateReminder(pkid){
		

		document.getElementById("buttonViewInfo").click();
		$.ajax({url:"updateReminder.php?pkid="+pkid,success:function(result){
			$("#divViewrem").html(result);
			$.ajax({url:"rcpTemp.php?tempid="+pkid,success:function(result){
				$('#cmbRecipientFieldUpdateName').tagsinput('add', result);
			}});
			$.ajax({url:"fileList.php",success:function(result){
				$("#fileListUpdate").html(result);
				}
			});
		}});
		document.getElementById("pid").value=pkid;
	}

	//task confirmation
	function conTask(pkid){
	   $.ajax({url:"confirmTask.php?pkid="+pkid,success:function(result){
			alert("Reminder Confirmed!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
	}
	//unconfirming a task of a confirmed task
	function unconTask(pkid){
	   $.ajax({url:"unconfirmTask.php?pkid="+pkid,success:function(result){
			alert("Reminder Reopened!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
	}
	//ajax for uncancellation of a cancelled task
	function uncancelTask(pkid){
	   $.ajax({url:"uncancelTask.php?pkid="+pkid,success:function(result){
			alert("Reminder Reopened!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
	}
	//loading table confirmed/ongoing emails 
	function loadconTable(pkid){
		$.ajax({url:"conRcptable.php?pkid="+pkid,success:function(result){
		$("#conTable").html(result);
		}
		});
	}
	//task update
	function updateReminderChanges(pkid){
		var alertsubj=$('#txtSubjUpdate').val();
		var recipient=$('#cmbRecipientFieldUpdateName').val();
		var secondary=$('#cmbSecondaryRecipientFieldUpdateName').val();
		var startdate=$('#fromDateUpdate').val();
		var enddate=$('#toDateUpdate').val();
		var filename=$('#txtAttUpdate').val();
		var details=$('#txtDetailsUpdate').val();
	   $.ajax({url:"updateReminderChanges.php?pkid="+pkid+"&alertsubj="+alertsubj+"&details="+details+"&recipient="+recipient+"&secondary="+secondary+"&startdate="+startdate+"&enddate="+enddate+"&filename="+filename,success:function(result){
			alert("Reminder updated!");
			loadTable();
			document.getElementById("btnCview").click();
		}
		});
	}
	//updating if email is done or will still continue
	function conRec(pkid,stat){
		var pid=document.getElementById("pid").value;
		$.ajax({url:"emailStat.php?pkid="+pkid+"&stat="+stat+"&alertid="+pid,success:function(result){
			loadconTable(pid);
		}
		});
	}

	function fileadd(){
		if(document.getElementById("fileList").value!=""){
			var x=document.getElementById("txtAtt").value;
			if(x==""){
				document.getElementById("txtAtt").value+=document.getElementById("fileList").value;
			} else {
				document.getElementById("txtAtt").value+=","+document.getElementById("fileList").value;
			}
		}
	}

	function fileaddUpdate(){		
		if(document.getElementById("fileListUpdate").value!=""){
			var x=document.getElementById("txtAttUpdate").value;
			if(x==""){
				document.getElementById("txtAttUpdate").value+=document.getElementById("fileListUpdate").value;
			} else {
				document.getElementById("txtAttUpdate").value+=","+document.getElementById("fileListUpdate").value;
			}
		}
	}
	
	function clearFile(){
		document.getElementById("txtAtt").value="";
	}
	
	function addEmailAdd() {
		var name = document.getElementById("cmbEmailName").value;
		var email = document.getElementById("AlertSec");
		var data = {
			"empname":name
		}
		data = $.param(data); //CONVERT FROM ELEMENT VALUES INTO SERIALIZE FOR COMPATIBILITY
		$.ajax({	//START OF AJAX
				type: "POST",
				url: "../Clinic/getEmployeeEmailAdd.php",	//Relative or absolute path to oswsHandler.php file
				data: data,
				success: function(result){
					$('#AlertSec').tagsinput('add', result);
					//email.value = result;
				}
		});
	}
	function addEmailAddRecipientUpdate() {
		var name = document.getElementById("cmbRecipientUpdateName").value;
		var data = {
			"empname":name
		}
		data = $.param(data); //CONVERT FROM ELEMENT VALUES INTO SERIALIZE FOR COMPATIBILITY
		$.ajax({	//START OF AJAX
				type: "POST",
				url: "../Clinic/getEmployeeEmailAdd.php",	
				data: data,
				success: function(result){
					$('#cmbRecipientFieldUpdateName').tagsinput('add', result);
					$('#cmbRecipientUpdateName').val("");
					$('#cmbRecipientUpdateName').focus();
				}
		});
	}
	function addEmailAddSecondaryRecipientUpdate() {
		var name = document.getElementById("cmbSecondaryRecipientUpdateName").value;
		var data = {
			"empname":name
		}
		data = $.param(data); //CONVERT FROM ELEMENT VALUES INTO SERIALIZE FOR COMPATIBILITY
		$.ajax({	//START OF AJAX
				type: "POST",
				url: "../Clinic/getEmployeeEmailAdd.php",	
				data: data,
				success: function(result){
					$('#cmbSecondaryRecipientFieldUpdateName').tagsinput('add', result);
					$('#cmbSecondaryRecipientUpdateName').val("");
					$('#cmbSecondaryRecipientUpdateName').focus();
				}
		});
	}
 </script>
<script src="js/bootstrap-tagsinput.js"></script>
<script src="js/bootstrap-tagsinput-angular.js"></script>

 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
  </head>
  
<body onload="loadTable()" style="background-color:#FFFDF5;">

<div class="container">
<br><br>
<div class="panel panel-default">
  <!-- HEADER OF THE WHOLE TABLE-->  
  <div class="panel-heading">
	<EM><h4>Task Reminder (Email)   </h4></EM> 
	<button  class="btn btn-primary btn-sm" onclick="addDatalist()" data-toggle="modal" data-target="#displayModaladd"> <span class="glyphicon glyphicon-plus"></span> Add New Reminder</button> 
	<button  class="btn btn-primary btn-sm" onclick="addDatalist()" data-toggle="modal" data-target="#displayUpload"> <span class="glyphicon glyphicon-inbox"></span> Add File</button>
	<button  class="btn btn-primary btn-sm" onclick="addDatalist()" data-toggle="modal" data-target="#displayModalReport"> <span class="glyphicon glyphicon-inbox"></span> Generate Report</button></div>
<table width="50px" class="table table-hover" id="taskTable" >
</table>
</div>

  <!-- the datalist for the subject choices -->  
<datalist id ="tempOpt">
</datalist>


<button style="display: none;" id="buttonViewInfo" data-toggle="modal" data-target="#displayModalinfo" ></button>

  <!-- MODAL FOR ADDING NEW TASK -->  
<div class="modal fade" id="displayModaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id = "displayModalClose" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New Reminder</h4>
      </div>
		<form class="form" >
		  <div class="modal-body">
			<label for="AlertSubj">Tasks Subject</label>
			<input type="text" id="AlertSubj" oninput="getTempDetails()" required autofocus  list="tempOpt"class="form-control" placeholder="Enter Subject..." ><br> 
			<label for="AlertRec">Recipient</label><br>
			<input type="text" id="AlertRec"  value="" class="form-control" data-role="tagsinput" required placeholder="Add E-mail" readOnly><br>
			<label for="AlertSec">Secondary Recipient</label><br>
			<label>Select name:</label>
			<table><tr><td><input type="text" id="cmbEmailName" style="width:300px"  class="form-control" list="emailList" autocomplete="off" name="cmbEmailName"></td><td style="width:10px;"></td>
			<td><button type="button" onclick="addEmailAdd()" class="btn btn-info">Add recipient</button></td></tr></table><br>
			<input type="text" id="AlertSec" class="form-control" data-role="tagsinput" required placeholder="Add Secondary E-mail" ><br>
			<label for="from">Reminder Date</label>
			<br>From &nbsp;&nbsp;<input type="text"  id="fromDate"    required readonly placeholder="Start Date.." tabindex="5">&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text"  id="toDate" required  readonly placeholder="End Date..."   tabindex="5">
			<br><br>
			<label for="txtAtt">Attachment</label><br>
			<select id ="fileList">
			</select>
			<button type="button" onclick="fileadd()">Add</button>&nbsp;<button type="button" onclick="clearFile()">Clear File</button><br><br>
			<input type="text" id="txtAtt" autofocus readonly class="form-control" placeholder="add file"><br> 
			<br><br>
			<label for="txtAtt">Details</label><br>
		
			<textarea rows='7' cols='75' required id='AlertDet'>
			</textarea><br>

			
			  <div class="modal-footer">
			  <button type="button" onclick="addRemajax()" class="btn btn-info">Send Reminder</button>
				<input type="button" onclick="rmdclear()"  class="btn btn-default" value="Clear">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>     					 
			  </div>
		  </div>
		</form>
	</div>
  </div>
</div>
  <!-- MODAL FOR DISPLAYING THE TASK CLICKED IN THE TABLE -->  

<div class="modal fade" id="displayModalinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id="btnCview" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Task</h4>
      </div>
		<div id="divViewrem">
		</div>
	  
	
    </div>
  </div>
</div>

  <!-- MODAL FOR THE FILE UPLOADER -->  
<div class="modal fade" id="displayUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add File</h4>
      </div>
<div class="modal-body">
 <div class="panel panel-default">
  <div class="panel-heading"><EM><h4>File Upload</h4></EM></div>
<iframe frameBorder="0" style="padding-left:50px" width="800px" height="auto" src="transfer.php"></iframe>
</table>
</div> 
</div>
<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
</div>
</div>
</div>

<!-- THIS THE MODAL FOR THE ADDING OF RECIPIENT -->
<div class="modal fade" id="displayModalrec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">RECIPIENT</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-heading"><EM><h4>Recipients</h4></EM></div>
					<table width="50px" class="table table-hover"  id="conTable" >
					</table>
				</div> 
			</div>
			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" onclick="reopenEdit()" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- modal for generating report -->
<div class="modal fade" id="displayModalReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">GENERATE REPORT</h4>
			</div>
			<div class="modal-body">
					<label>Select report category</label>
					<select id="cmbReportCategory">
						<option value="startdate">Start Date</option>
						<option value="enddate">End Date</option>
						<option value="datecreated">Date Created</option>
					</select><br>
					<label>Select Date Range: To</label>
					<input type="date" id="cmbStartDateReport" value="<?php echo date('Y-m-d'); ?>"> <label>From</label>
					<input type="date" id="cmbEndDateReport" value="<?php echo date('Y-m-d'); ?>">
			</div>
			<div class="modal-footer"> 
				<button type="button" id="btnExportToExcel" class="btn btn-primary" aria-hidden="true">Export to excel</button>
				<button type="button" class="btn btn-default" onclick="reopenEdit()" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>	

<input type=hidden id="pid">
</body>
</html>