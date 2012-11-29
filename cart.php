<?php

require_once './library/cartFunctions.php';

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
}

$cartContent = getCartContent();
$numItem = count($cartContent);

$pageTitle = 'Shopping Cart';
require_once './include/header.php';

// show the error message ( if we have any )
displayError();

if ($numItem > 0 ) {
?>
<form action="<?php echo $_SERVER['PHP_SELF'] . "?action=update"; ?>" method="post" name="frmCart" id="frmCart">
 <table width="780" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr class="entryTableHeader"> 
   <td colspan="2" align="center">Item</td>
   <td align="center">Unit Price</td>
   <td width="75" align="center">Quantity</td>
   <td align="center">Total</td>
  <td width="75" align="center">&nbsp;</td>
 </tr>
 <?php
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$productUrl = "./storeIndex.php?p=$ItemID";
	$subTotal += $Price * $Quantity;
?>
 <tr class="content"> 
  <td width="80" align="center"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $ImageURL; ?>" border="0" width="30" height="30"></a></td>
  <td><a href="<?php echo $productUrl; ?>"><?php echo $Name; ?></a></td>
   <td align="right"><?php echo "$". $Price; ?></td>
  <td width="75"><input name="txtQty[]" type="text" id="txtQty[]" size="5" value="<?php echo $Quantity; ?>" class="box" onKeyUp="checkNumber(this);">
  <input name="hidProductId[]" type="hidden" value="<?php echo $ItemID; ?>">
  </td>
  <td align="right"><?php echo "$" . ($Price * $Quantity); ?></td>
  <td width="75" align="center"> <input name="btnDelete" type="button" id="btnDelete" value="Delete" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF'] . "?action=delete&p=$ItemID"; ?>';" class="box"> 
  </td>
 </tr>
 <?php
}
?>
 <tr class="content"> 
  <td colspan="4" align="right">Sub-Total</td>
  <td align="right"><?php echo "$" . $subTotal; ?></td>
  <td width="75" align="center">&nbsp;</td>
 </tr>  
 <tr class="content"> 
  <td colspan="5" align="right">&nbsp;</td>
  <td width="75" align="center">
<input name="btnUpdate" type="submit" id="btnUpdate" value="Update Cart" class="box"></td>
 </tr>
</table>
</form>
<?php
} else {
	
?>
<p>&nbsp;</p><table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
 <tr>
  <td><p align="center">You shopping cart is empty</p>
   <p>If you find you are unable to add anything to your cart, please ensure that 
    your internet browser has cookies enabled and that any other security software 
    is not blocking your shopping session.</p></td>
 </tr>
</table>
<?php
}

$shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : './storeIndex.php';
?>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
 <tr align="center"> 
  <td><input name="btnContinue" type="button" id="btnContinue" value="&lt;&lt; Continue Shopping" onClick="window.location.href='<?php echo $shoppingReturnUrl; ?>';" class="box"></td>
<?php 
if ($numItem > 0) {
?>  
  <td><input name="btnCheckout" type="button" id="btnCheckout" value="Proceed To Checkout &gt;&gt;" onClick="window.location.href='checkout.php?step=1';" class="box"></td>
<?php
}
?>  
 </tr>
</table>
<?php
require_once './include/footer.php';
?>