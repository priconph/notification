<?php
	//remove all session data upon visiting start page
	#php file where scripts are included
	require_once("../global_includes/sys1-oop.php");
	#boolean for login
	$logonSuccess = false;
	// verify user's credentials
			session_start();
			$rR = sys1OOP::getInstance()->getUserpkid("techsupport","pmi1234");
			if ($row = mysqli_fetch_array($rR)) {
			echo  $row['pkid']."AW";
				$_SESSION['truserid'] = $row['pkid'];
			}
			
	 
	
	 
?>