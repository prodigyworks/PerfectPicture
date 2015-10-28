<?php
	//Include database connection details
	require_once('system-db.php');
	
	start_db();
	
	$clientid = $_POST['clientid'];
	$memberid = getLoggedOnMemberID();
	
	createComboOptions(
			"id", 
			"name", 
			"{$_SESSION['DB_PREFIX']}customerclientsite", 
			"WHERE A.clientid = $clientid
			 AND A.id IN
			 (
			 	SELECT C.siteid 
			 	FROM {$_SESSION['DB_PREFIX']}customerclientsiteuser C
			 	WHERE C.memberid = $memberid
			 )", 
			false
		);
?>