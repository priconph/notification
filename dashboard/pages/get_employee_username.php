<?php
session_start();
$username = $_SESSION['username'];

if($username == '') {
	echo '<script>parent.window.location.reload(true);</script>';
}
