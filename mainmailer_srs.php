<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Notification Mailer</title>

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
		


<script>

//an interval function that loops every 5 seconds and run a specific function called send mail
//window.onload=function(){setInterval(function(){document.getElementById("sending").click();},5000);}
window.onload=function(){setInterval(function(){check_srs_for_conformance();},55000);}
var lastsent="";

//this functions is run for every 5sec this check if the the mailer has sent today or not if the mailer has not yet sent an email it will go to the first if and send all the email that is either on-going or overdue(it runs the alertmailer.php) else it will keep checking if the day has ended if it has ended then it will send again an email for that day. this will keep continue to check if the this php file is open in a browser
function sendMail(){
	//overdueTask();
	check_srs_for_conformance();
	if(document.getElementById("Checker").value==""||document.getElementById("Checker").value=="false"){
		/* $.ajax({url:"../srs/srs_reminder.php?",success:function(result){
			$.ajax({url:"alertmailer.php?",success:function(result){
				document.getElementById("Checker").value=$.trim(result);
				lastsent=dateToday();
			   }
			});
		   }
		}); */
	}
	else{
		if(lastsent<dateToday()){
			document.getElementById("Checker").value="false";
		}
	}
}
//function for overdue task
function overdueTask(){
	$.ajax({url:"overdueTask.php?",success:function(result){
	}
	});
}

/* Send email every 12 hours for those Service Request are not yet conformed. This is the corrective action for QAD Audit findings. Because they say that the request is still on queue since requestor did not yet conform the request. Therefor, the system must "kulitin" the requestor to conform the request.*/
function check_srs_for_conformance() {
	$.ajax({url:"../srs/srs_unconformed_reminder.php",success:function(result){
	}
	}); 
}
//just getting the date today
function dateToday(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; 
	var yyyy = today.getFullYear();

	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 

	today = mm+'/'+dd+'/'+yyyy;
	return today;
}

 </script>

 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
  </head>
  
<body>
<!-- do not change this is what the function checks if is false/blank("") the mailer will sent for today and if is true/ has a value on it this will start to go to the "else part" of the sendmail function -->
<div class="container"><center>
<h1>DO NOT CLOSE</h1>
<p>This is an Auto mailer of the Service Request System. This Sends the notifications on the unconformed requests. Please RE-OPEN when CLOSED.</p>
<input type="text" id="Checker"/>
<button type="button" id="sending" onclick="sendMail()">Send Mail</button>
</center>


</div>
</body>
</html>