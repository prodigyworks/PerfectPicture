<?php 
	include("system-db.php"); 
	
	start_db();

	$customerid = getLoggedOnCustomerID();
	
	$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}order 
			(
				customerid, orderdate, status
			)
			VALUES
			(
				$customerid, CURDATE(), 0
			)";
				
	$result = mysql_query($sql);

	if (! $result) {
		logError($sql . " = " . mysql_error());
	}
	
	$orderid = mysql_insert_id();
	
	for ($row = 0; $row < count($_POST['productid']); $row++) {
		$productid = $_POST['productid'][$row];
		$qty = $_POST['qty'][$row];
		
		if ($qty <= 0 || $productid == "" || $productid == "0") {
			continue;
		}
		
		$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}frequentproducts 
				(
					customerid, productid, frequency
				)
				VALUES
				(
					$customerid, $productid, $qty
				)";
					
		$result = mysql_query($sql);
		
		if (mysql_errno() == 1062) {
			$sql = "UPDATE {$_SESSION['DB_PREFIX']}frequentproducts SET
					frequency = frequency + $qty
					WHERE customerid = $customerid
					AND productid = $productid";
			
			$result = mysql_query($sql);
						
			if (! $result) {
				logError($sql . " = " . mysql_error());
			}
			
		} else if (! $result) {
			logError($sql . " = " . mysql_error());
		}
		
		$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}orderitem
				(
					orderid, productid, quantity
				)
				VALUES
				(
					$orderid, $productid, $qty
				)";
					
		$result = mysql_query($sql);
	
		if (! $result) {
			logError($sql . " = " . mysql_error());
		}
	}
	
	mysql_query("COMMIT");
	
	sendRoleMessage("JRM", "Confirmed order", "Confirmed order ........");
	sendCustomerMessage($customerid, "Confirmed customer order", "Confirmed order ........");
	
	header("location: processorderconfirm.php?orderid=$orderid");
?>
