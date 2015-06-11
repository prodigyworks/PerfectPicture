<?php 
	include("system-embeddedheader.php"); 
?>
	<div class="header">Order</div>
<?php
	$customerid = getLoggedOnCustomerID();
	
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
	}
?>
<br>
<h2>Order <?php echo $orderid; ?> has been processed.</h2>
<?php
	include("system-embeddedfooter.php"); 
?>

