<?php 
echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
?>
<?php include("system-embeddedheader.php"); ?>
<h2>Online Ordering</h2>
<table width='100%'>
	<tr>
		<td>Product</td>
		<td>Qty</td>
	</tr>
	<tr>
		<td>
			<?php createLazyCombo("productid", "id", "description", "{$_SESSION['DB_PREFIX']}product", "", false); ?>
		</td>
		<td>
			<input type="text" id="qty" name="qty[]" size=5 />
		</td>
	</tr>
</table>

<?php include("system-embeddedfooter.php"); ?>

