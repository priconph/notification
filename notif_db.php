 <?php 
 //this is the class of the connection closing and all of the queries that has been used for the alert notification system
 class notifDb{
        var $dbHost;
        var $dbUsername;
        var $dbPassword;
        var $dbName;
        var $dbc;

			public function notifDb()
        {
            $this->dbHost = "localhost";
            $this->dbUsername = "root";
            $this->dbPassword = "newd3v";
            $this->dbName = "db_Alert";

            $this->dbc = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName) or die('Error connecting to DB');        
        }

        public function getAllalert()
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Alert") or die('Error querying the dbName');
           return $result;
        }
		
		  public function getAlltemplate()
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Template") or die('Error querying the dbName');
           return $result;
        }
		
		
		 public function getUsertemplate($userid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Template where userid='".$userid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getUseralert($userid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Alert where userid='".$userid."' ORDER BY datecreated DESC") or die('Error querying the dbName');
           return $result;
        }
		
		
		public function getAllRecipient($pkid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Reciever where tempid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }				
				
		public function getPkid()
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Alert") or die('Error querying the dbName');
           return $result;
        }
		
		public function generateReportByDate($keyword,$startDate,$endDate)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Alert WHERE ".$keyword." BETWEEN '".$startDate."' AND '".$endDate."'") or die('Error querying the dbName');
           return $result;
        }
		
		 public function viewTask($pkid)
        { 
			$result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Alert where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function listTemplate($userid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Template where userid='".$userid."'") or die('Error querying the dbName');
           return $result;
        }
		
		
		public function viewTemplate($pkid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Template where  pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function delTemplate($pkid)
        { 	$result=  mysqli_query($this->dbc,"DELETE FROM tbl_Template where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function delTempRec($tempid)
        { 	$result=  mysqli_query($this->dbc,"DELETE FROM tbl_Reciever where tempid='".$tempid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getTempRcp($tempid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Reciever where tempid='".$tempid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getUser($uname,$pword)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_User where username='".$uname."' and password='".$pword."'") or die('Error querying the dbName');
           return $result;
        }
				
		public function delTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"DELETE FROM tbl_Alert where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		public function cancelTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET status='Cancelled' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function confirmTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET status='Confirmed' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function unconfirmTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET status='On-Going' , dateconfirm='N/A' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function uncancelTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET status='On-Going' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }

		public function overdueTask($pkid)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET status='Overdue' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function updateReminderChanges($pkid,$alertsubj,$details,$recipient,$secondary,$startdate,$enddate,$filename) {
			$result=  mysqli_query($this->dbc,"UPDATE tbl_Alert SET alertsubj='$alertsubj',details='$details',recipient='$recipient',secondary='$secondary',startdate='$startdate',enddate='$enddate',filename='$filename' where pkid='".$pkid."'") or die('Error querying the dbName');
			return $result;
		}
		
		public function emailStat($pkid,$stat)
        { 	$result=  mysqli_query($this->dbc,"UPDATE tbl_Confirm SET status='".$stat."' where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function delRecipient($pkid)
        { 	$result=  mysqli_query($this->dbc,"DELETE FROM tbl_Reciever where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		
		public function getSubDet($pkid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Template where pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getAllConfirm($pkid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Confirm where alertid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getConfirmemail($pkid, $email)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Confirm where alertid='".$pkid."' and email='".$email."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getEmailcon($alertid,$pkid)
        { $result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Confirm where alertid='".$alertid."' AND pkid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function getConnamemail($email)
		{
		$result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Reciever where email='".$email."'") or die('Error querying the dbName');
          return $result;
		}
		
		public function getFiles()
		{
		$result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Files") or die('Error querying the dbName');
          return $result;
		}
		public function getuserFiles($userid)
		{
		$result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Files where userid='".$userid."'") or die('Error querying the dbName');
          return $result;
		}
		
		public function delConfirm($pkid)
        { $result=  mysqli_query($this->dbc,"Delete FROM tbl_Confirm where alertid='".$pkid."'") or die('Error querying the dbName');
           return $result;
        }

		 public function addTask($subj,$det, $rec,$sec, $sdate, $edate, $userid,$att)
        { 
			//$det = str_replace("[asterisk]", "#", $det);
			//$det = str_replace("[ampersand]", "&", $det);
		//$this->thisIsMine($subj,$det, $rec,$sec, $sdate, $edate, $userid,$att);
		$cdate=date('Y/m/d');
		if(strpos($subj, "'") != false) {
			//contains single quote
			$subj = str_replace("'", "", $subj);
		} if(strpos($subj, '"') != false) {
			//contains double quote
			$subj = str_replace('"', '', $subj);
		} 
		if(strpos($det, "'") != false) {
			//contains single quote
			$det = str_replace("'", "", $det);
		} if(strpos($det, '"') != false) {
			//contains double quote
			$det = str_replace('"', '', $det);
		} 
		$rec = trim($rec, " ");
		$result=  mysqli_query($this->dbc,"INSERT INTO tbl_Alert VALUES('','".$userid."','".$subj."','".$det."','".$rec."','".$sec."','".$sdate."','".$edate."','".$cdate."','On-Going','N/A','".$att."')") or die('Error querying the dbName');
		//$result2 = mysqli_query($this->dbc,"UPDATE tbl_Template SET subject= '".$subj."', details='".$det."' WHERE userid='".$id."';") or die('Error querying the dbName');
		return $result;
        }
		
		//public function thisIsMine($subj,$det, $rec,$sec, $sdate, $edate, $userid,$att) {
		//	$result2 = mysqli_query($this->dbc,"UPDATE tbl_Template SET subject= '".$subj."', details='".$det."' WHERE userid='".$userid."';") or die('Error querying the dbName');
		//	return $result;
		//}
		
		public function confirmRec($email,$alertid)
        { 
		$result=  mysqli_query($this->dbc,"INSERT INTO tbl_Confirm VALUES('','".$email."','On-Going','".$alertid."')") or die('Error querying the dbName');
           return $result;
        }
		
		//dinagdag ko
		 public function checkTblConfirm($email,$alertid)
        { 
			//echo "SELECT * FROM tbl_Confirm where email='".$email."' AND alertid='".$alertid."'";
			$result=  mysqli_query($this->dbc,"SELECT * FROM tbl_Confirm where email='".$email."' AND alertid='".$alertid."'") or die('Error querying the dbName');
           return $result;
        }
		
		public function addFile($userid,$filename)
        { 
		$result=  mysqli_query($this->dbc,"INSERT INTO tbl_Files VALUES('','".$userid."','".$filename."')") or die('Error querying the dbName');
           return $result;
        }
		
		public function addTemp($subj,$det,$userid)
        { 
		$cdate=date('Y/m/d');
		if(strpos($subj, "'") != false) {
			//contains single quote
			$subj = str_replace("'", "", $subj);
		} if(strpos($subj, '"') != false) {
			//contains double quote
			$subj = str_replace('"', '', $subj);
		} 
		if(strpos($det, "'") != false) {
			//contains single quote
			$det = str_replace("'", "", $det);
		} if(strpos($det, '"') != false) {
			//contains double quote
			$det = str_replace('"', '', $det);
		} 
		$result=  mysqli_query($this->dbc,"INSERT INTO tbl_Template VALUES('','".$subj."','".$det."','".$userid."','".$cdate."','".$cdate."')") or die('Error querying the dbName');
           return $result;
        }
		
		public function checkRec($name,$email,$tempid) {
			$result=  mysqli_query($this->dbc,"SELECT COUNT(*) AS ROW FROM tbl_Reciever WHERE recievername='".$name."' AND email='".$email."' AND tempid='".$tempid."'") or die('Error querying the dbName');
           return $result;
		}
		
		public function addRec($name,$email,$tempid)
        { 
			$result=  mysqli_query($this->dbc,"INSERT INTO tbl_Reciever VALUES('','".$name."','".$email."','".$tempid."')") or die('Error querying the dbName');
           return $result;
        }
		
        public function close()
        {
            return mysqli_close($this->dbc);
        }
    }
    ?>
	
	