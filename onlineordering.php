<?php 
//echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
?>
<?php include("system-embeddedheader.php"); ?>
<div id="orderapp">
	<div style="text-align:center">
		<img src="images/logomain2.png"/>
	</div>
	<br>
	<div style="text-align:center">
		<h2><?php echo $_SESSION['SESS_CUSTOMER_NAME']; ?></h2>
	</div>
	<br>
	<hr>
	<br>
	<h1>Online Ordering</h1>
	<form id="orderform" method="POST" action="processorder.php">
		<table width='100%'>
			<tr class="header">
				<td>Product</td>
				<td>Qty</td>
			</tr>
<?php 
	$customerid = getLoggedOnCustomerID();
	$sql = "SELECT A.*, B.description 
			FROM {$_SESSION['DB_PREFIX']}frequentproducts A
			INNER JOIN {$_SESSION['DB_PREFIX']}product B 
			ON B.id = A.productid 
			WHERE customerid = $customerid 
			ORDER BY A.frequency DESC 
			LIMIT 20";
	
	$result = mysql_query($sql);
	$row = 1;
	
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$row++;
			$product = mysql_escape_string($member['description']);
?>
			<tr>
				<td class="favourite">
					<?php echo $product; ?>
					<input type="hidden" id="productid" name="productid[]" size=5 value="<?php echo $member['productid']; ?>" />
				</td>
				<td>
					<input type="text" id="qty" name="qty[]" size=15 value="0" />
				</td>
			</tr>
<?php
		}
		
	} else {
		logError($sql . " - " . mysql_error());
	}
	
	for (; $row < 20; $row++) {
?>
			<tr>
				<td>
					<?php createLazyCombo("productid" . $row, "id", "description", "{$_SESSION['DB_PREFIX']}product", "", false, 60, "productid[]"); ?>
				</td>
				<td>
					<input type="text" id="qty" name="qty[]" value="0" size=15 />
				</td>
			</tr>
<?php
	}
?>
		</table>
	<div style="float:right">
		<a href="system-logout.php">Log Out</a>
	</div>
		<input id="submitbutton" type="button" onclick="processorder()" value="Process"></input>
	</form>
	<script>
	function processorder() {
		$("#orderform").submit();
	}
	</script>
</div>
<?php include("system-embeddedfooter.php"); ?>

