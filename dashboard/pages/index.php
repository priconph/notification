<?php
/* Include employee information */
require_once('get_employee_username.php');
?>
<input type="hidden" id="hidden_username" value="<?php echo $username; ?>">
<input type="hidden" id="hidden_date_today" value="<?php echo date('Y-m-d'); ?>">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Alert Notification System</title>
	
	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../media/font_awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>	
	<div id="swrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Home</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-3 col-md-6" data-toggle="tooltip" data-placement="bottom" title="Click to create / view / update template and recipients" id="div_template">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-object-group fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" id="" data-placement="bottom" title="">&nbsp;</div>
								<div data-toggle="tooltip" data-placement="bottom" title="Click to create / view / update template and recipients">Template Manager</div>
							</div>
						</div>
					</div>
					<a href="../template.php" data-placement="bottom" title="Click to view the template">
						<div class="panel-footer">
							<span class="pull-left">View Template List</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green" data-placement="bottom" title="Click to view the created reminder" id="div_reminder">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-exclamation-circle fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" id="pending_alert" data-placement="bottom" title="Total number of on-going and overdue reminder"></div>
								<div>Task Reminder</div>
							</div>
						</div>
					</div>
					<a href="../landing.php" data-placement="bottom" title="Click to view the created reminder">
						<div class="panel-footer">
							<span class="pull-left">View Reminder Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- Call user defined functions common functions -->
<script src="../../../common_functions/common_functions.js" type="text/javascript"></script>
<script src="../../../media/js/jquery.js"></script>

<script type="text/javascript">
	var username 				= $('#hidden_username').val();
	var handler 				= '../handler/handler.php';
	pending_alert();
	
	$('#div_template').click(function() {
		window.location.href = '../template.php';
	});
	$('#div_reminder').click(function() {
		window.location.href = '../landing.php';
	});
	function pending_alert(){
		var data = {
			"action"	: "pending_alert",
			"requestor"	: username
		}
		call_ajax(data, handler, function(result){
			$('#pending_alert').text(result['pending']);
		});
	}
</script>	
	
	
	
	