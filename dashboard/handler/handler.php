<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				/* REQUESTOR FUNCTIONS */
				case "pending_alert"					: pending_alert(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	
	function pending_alert() {
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('pkid');
		$table 	   	= 'tbl_Alert';
		$joins 	   	= '';
		$sql_where 	= 'WHERE status="On-going" OR status = "Overdue"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = ALERT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pending = $result->num_rows;
		$return['pending'] = $pending;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
?>