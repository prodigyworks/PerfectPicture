<?php include("system-embeddedheader.php"); ?>
<div id="orderapp">
	<form id="orderform" method="POST" action="processorder.php">
		<table width='100%' cellspacing=0 cellpadding=0>
			<tr class="header">
				<td>Product</td>
				<td>Qty</td>
			</tr>
<?php 
	$siteid = getLoggedOnSiteID();
	$sql = "SELECT A.*, B.description 
			FROM {$_SESSION['DB_PREFIX']}frequentproducts A
			INNER JOIN {$_SESSION['DB_PREFIX']}product B 
			ON B.id = A.productid 
			WHERE siteid = $siteid 
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
					<div><?php echo $product; ?></div>
					<input type="hidden" id="productid" name="productid[]" value="<?php echo $member['productid']; ?>" />
				</td>
				<td>
					<input type="number" id="qty" name="qty[]" size=5 value="" style="width:40px" />
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
					<?php createLazyCombo("productid" . $row, "id", "description", "{$_SESSION['DB_PREFIX']}product", "", false, 55	, "productid[]"); ?>
				</td>
				<td>
					<input type="number" id="qty" name="qty[]" value="" size=5  style="width:40px" />
				</td>
			</tr>
<?php
	}
?>
		</table>
		<input id="submitbutton" type="button" onclick="processorder()" value="Process"></input>
	</form>
	<script>
	function processorder() {
		$("#orderform").submit();
	}
	</script>
</div>
<?php include("system-embeddedfooter.php"); ?>

