<?php
	//checking the user
	session_start();
	$userid= $_SESSION["truserid"];
	if($userid == '' || $userid == 0) {
		#echo "<script>alert('Your session has expired. Please log in again!');</script>";
		#echo "<script>setTimeout(function(){window.parent.location.reload()}, 100);</script>";
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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Reminder Templates</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css";
	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="DatePicker/jquery-ui.css">
	<script src="DatePicker/jquery-1.10.2.js"></script>
	<script src="DatePicker/jquery-ui.js"></script>
	
	<style>
		table {
		 table-layout:fixed;
		}

		table td {
		overflow:hidden;
		}
	</style>

	<script>
		//function for opening the form of an existing template
		function openEditform(pid){
			document.getElementById("pid").value=pid;
			document.getElementById("buttonViewInfo").click();
			$.ajax({url:"showTemp.php?pkid="+pid,success:function(result){
				$("#divViewrem").html(result);
			}});
		}
		
		//reopening the template that was closed when the recipient box showed up
		function reopenEdit(){
			openEditform(document.getElementById('pid').value);
		}

		//ajax for adding the template
		function addTemp(){
			var subj= encodeURIComponent(document.getElementById("txtSubj").value);
			var det=encodeURIComponent(document.getElementById("txtDet").value);
			det = det.replace(/\n/g, '\\r\\n');
			//alert(det);
			$.ajax({url:"addTemp.php?subj="+subj+"&det="+det,success:function(result){
				  $("#trydiv").html(result);
				  loadTable();
				  alert("Template Created!");
				  document.getElementById('displayModaladdClose').click();
				  document.getElementById('txtSubj').value= "";
				  document.getElementById('txtDet').value="";
				}});
		}


		//ajax for loading the table of the templates 
		function loadTable(){
		   $.ajax({url:"tableTemp.php?userid=1",success:function(result){
			  $("#tempTable").html(result);
			}
			});
		}
		
		//ajax for loading the recipient table for a template
		function loadrcpTable(pkid){
		   $.ajax({url:"rcpTable.php?pkid="+pkid,success:function(result){
			  $("#rcpTable").html(result);
			}
			});
		}
		
		//ajax for deleting a template
		function delTemp(pkid){
		   $.ajax({url:"delTemp.php?pkid="+pkid,success:function(result){
				alert("Template Deleted!");
				loadTable();
				document.getElementById("btnCview").click();
			}
			});
		}


		//ajax for deleting recipient of a template
		function delRec(pkid){
		var alertid= document.getElementById("pid").value;
		   $.ajax({url:"delRec.php?pkid="+pkid,success:function(result){
				loadrcpTable(alertid);
			}
			});
		}

		//ajax for adding a recipient in a template
		function addRec(){
			var pkid= document.getElementById("pid").value;
			var name= document.getElementById("txtRcptName").value;
			var email=document.getElementById("txtRcptemail").value;
			$.ajax({url:"addRec.php?pkid="+pkid+"&name="+name+"&email="+email,success:function(result){
					loadrcpTable(pkid);
					document.getElementById("txtRcptName").value = "";
					document.getElementById("txtRcptemail").value = "";
				}
				});
		}
		
		function addEmailAdd() {
			var name = document.getElementById("txtRcptName").value;
			var email = document.getElementById("txtRcptemail");
			var data = {
				"empname":name
			}
			data = $.param(data); //CONVERT FROM ELEMENT VALUES INTO SERIALIZE FOR COMPATIBILITY
			$.ajax({	//START OF AJAX
					type: "POST",
					url: "../Clinic/getEmployeeEmailAdd.php",	//Relative or absolute path to oswsHandler.php file
					data: data,
					success: function(result){
						//$('#txtRcptemail').tagsinput('add', result);
						email.value = result;
					}
			});
		}
	 </script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
  
<body onload="loadTable()"  style="background-color:#FFFDF5;">
		
<div class="container"><br>
	<div align='right'>
		<button type='submit' onClick="window.location = '../includes/download.php?filename=AlertManual'"><img src='../includes/images/download.png' height='35' width='35'>USER MANUAL</button>
	</div>
<br>
<div class="panel panel-default">
	

  <!-- Default panel contents -->
  
<!-- HEADER OF THE WHOLE TABLE -->
  <div class="panel-heading"><EM><h4>Template Management  </h4></EM> <button  class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#displayModaladd"> <span class="glyphicon glyphicon-plus"></span> Add New Template</button></div>
 <!-- TABLE FOR ALL THE TEMPLATES --> 
<table width="50px" class="table table-hover"  id="tempTable" >
</table>
</div>




<button style="display: none;" id="buttonViewInfo" data-toggle="modal" data-target="#displayModalinfo" ></button>
<!-- THIS THE MODAL FOR THE ADDING OF NEW TEMPLATE -->
<div class="modal fade" id="displayModaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id = "displayModaladdClose" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New Template</h4>
      </div>
	    <form class=""form">
     <div class="modal-body">
<label for="txtSubj">Template Task Subject</label>
<input type="text" id="txtSubj" class="form-control" placeholder="Enter Subject..." > <br>
<label for="txtPass">Template Details</label><br>
<textarea  rows="7" cols="75" id="txtDet" style="resize: none;"> </textarea><br>
		     
</div>

<div class="modal-footer">
<button type="button" onclick="addTemp()" class="btn btn-info">Save</button>
<button type="reset" class="btn btn-default">Clear</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		
</div>
	</form>
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
	    <form class=""form" >
     <div class="modal-body">
<label for="txtRcptName">Name</label>
<input type="text" id="txtRcptName" class="form-control" placeholder="Enter Name..." list='emailList' autocomplete="off" name="txtRcptName" oninput="addEmailAdd();"> <br>
<label for="txtRcptemail">E-Mail</label>
<input type="text" id="txtRcptemail" class="form-control" disabled> <br>
<button type="button" onclick="addRec()" class="btn btn-info">Add</button>
<button type="reset" class="btn btn-default">Clear</button>	
</form>
</div>


<div class="modal-body">
 <div class="panel panel-default">
  <div class="panel-heading"><EM><h4>Recipients  </h4></EM></div>
<table width="50px" class="table table-hover"  id="rcpTable" >
</table>
</div> 
</div>


<div class="modal-footer"> <button type="button" class="btn btn-default" onclick="reopenEdit()" data-dismiss="modal">Close</button></div>

 </div>
</div>
</div>



<!-- THIS THE MODAL FOR THE VIEWING & DELETING THE TEMPLATE -->
<div class="modal fade" id="displayModalinfo" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id="btnCview" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Template</h4>
      </div>
<div id="divViewrem">
</div>
	 
    </div>
  </div>
</div>




<input type="hidden" id="pid">
</div>
</body>
</html>
