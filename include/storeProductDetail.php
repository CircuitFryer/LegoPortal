<?php
require_once './library/commonMethods.php';

	$sql = "SELECT Name, Description, Price, ImageLarge, Quantity
			FROM Items
			WHERE ItemID = $pdId";
	
	$result = query($sql);
	$row    = mysql_fetch_assoc($result);
	extract($row);
	
	$row['Description'] = nl2br($row['Description']);
	
	if ($row['ImageLarge']) {
		$row['ImageLarge'] = '../images/product/' . $row['ImageLarge'];
	} else {
		$row['ImageLarge'] = '../images/No-Image-Large.png';
	}
	
	$row['cart_url'] = "../cart.php?action=add&p=$pdId";

?> 
<table width="100%" border="0" cellspacing="0" cellpadding="10">
 <tr> 
  <td align="center"><img src="<?php echo $ImageLarge; ?>" border="0" alt="<?php echo $Name; ?>"></td>
  <td valign="middle">
<strong><?php echo $Name; ?></strong><br>
Price : <?php echo $Price; ?><br>
<?php
// if we still have this product in stock
// show the 'Add to cart' button
if ($Quantity > 0) {
?>
<input type="button" name="btnAddToCart" value="Add To Cart &gt;" onClick="window.location.href='<?php echo $cart_url; ?>';" class="addToCartButton">
<?php
} else {
	echo 'Out Of Stock';
}
?>
  </td>
 </tr>
 <tr align="left"> 
  <td colspan="2"><?php echo $Description; ?></td>
 </tr>
</table>