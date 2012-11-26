<?php
require_once './library/cartFunctions.php';

$cartContent = getCartContent();

$numItem = count($cartContent);	
?>
<table width="100%" border="1" cellspacing="0" cellpadding="2" id="minicart">
 <?php
if ($numItem > 0) {
?>
 <tr>
  <td colspan="2">Cart Content</td>
 </tr>
<?php
	$subTotal = 0;
	for ($i = 0; $i < $numItem; $i++) {
		extract($cartContent[$i]);
		$Name = "$Quantity x $Name";
		$url = "storeIndex.php?p=$pd_id";
		
		$subTotal += $Price * $Quantity;
?>
 <tr>
   <td><a href="<?php echo $url; ?>"><?php echo $Name; ?></a></td>
   
  <td width="30%" align="right"><?php echo displayAmount($Quantity * $Price); ?></td>
 </tr>
<?php
	} // end while
?>
  <tr><td align="right">Sub-total</td>
  <td width="30%" align="right"><?php echo displayAmount($subTotal); ?></td>
 </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
  <td colspan="2" align="center"><a href="cart.php?action=view"> Go To Shopping 
   Cart</a></td>
 </tr>  
<?php	
} else {
?>
  <tr><td colspan="2" align="center" valign="middle">Shopping Cart Is Empty</td></tr>
<?php
}
?> 
</table>
