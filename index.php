<?php
	if (strpos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
		header("location: onlineordering.php");
		
	} else {
		header("location: manageorders.php");
	}
?>
