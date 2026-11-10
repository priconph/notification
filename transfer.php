<html>
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
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="DatePicker/jquery-ui.css">
<link rel="stylesheet" href="css/demo_table.css">		
<link rel="stylesheet" href="css/bootstrap-tagsinput.css">	

<body >
	
<script>
function uploaded(){
alert("File Uploaded");
}
</script>

<?php
//this is used in a modal a form that uploads the file

echo'<form action="upload_file.php" method="post"';
echo'enctype="multipart/form-data" onsubmit="uploaded()">';
echo'<label for="file">Past Uploaded files might be overwrittten when file your upload has same the name.</label>';
echo'<label for="file">Filename:</label>';
echo'<input type="file" name="file" id="file"><br>';
echo'<input type="submit" class="btn btn-info" id="upload" name="submit" value="Submit">';
echo'</form>';

?>
</body>
</html>