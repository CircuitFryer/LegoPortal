<?php
require_once './library/shippingCalculator.php';

if (!isset($_GET['step']) || (int)$_GET['step'] != 2
	|| $_SERVER['HTTP_REFERER'] != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?step=1') {
	exit;
}

$errorMessage = '&nbsp;';

/*
 Make sure all the required field exist is $_POST and the value is not empty
*/
$requiredField = array('txtShippingFirstName', 'txtShippingLastName', 'txtShippingAddress', 'txtShippingPhone', 'txtShippingState',  'txtShippingCity', 'txtShippingPostalCode');
					   
if (!checkRequiredPost($requiredField)) {
	$errorMessage = 'Input not complete';
}
					   

$cartContent = getCartContent();

?>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr> 
        <td>Step 2 Of 3 : Confirm Order </td>
    </tr>
</table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=3" method="post" name="frmCheckout" id="frmCheckout">
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="infoTable">
        <tr class="infoTableHeader"> 
            <td colspan="3">Ordered Item</td>
        </tr>
        <tr class="label"> 
            <td>Item</td>
            <td>Unit Price</td>
            <td>Total</td>
        </tr>
        <?php
$numItem  = count($cartContent);
$subTotal = 0;
$totalWeight = 0;
for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$subTotal += $Price * $Quantity;
	$totalWeight += $Weight * $Quantity;
?>
        <tr class="content"> 
            <td class="content"><?php echo "$Quantity x $Name"; ?></td>
            <td align="right"><?php echo "$" . $Price; ?></td>
            <td align="right"><?php echo "$" . ($Quantity * $Price); ?></td>
        </tr>
        <?php
}
$shipData = array(
	'toZip' => $_POST['txtShippingPostalCode'],
	'weight' => ($totalWeight / 16)
);
$ship = new shippingCalculator($shipData);
$rate = $ship->calculate();

?>
        <tr class="content"> 
            <td colspan="2" align="right">Sub-total</td>
            <td align="right"><?php echo "$" . $subTotal; ?></td>
        </tr>
        <tr class="content"> 
            <td colspan="2" align="right">Shipping</td>
            <td align="right"><?php echo "$" . $rate; ?>
	      <input name="hidShippingCost" type="hidden" id="hidShippingCost" value="<?php echo $rate; ?>"></td>
        </tr>
        <tr class="content"> 
            <td colspan="2" align="right">Total</td>
            <td align="right"><?php echo "$" . ($rate + $subTotal); ?>
	      <input name="hidTotalCost" type="hidden" id="hidTotalCost" value="<?php echo ($rate + $subTotal); ?>"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="infoTable">
        <tr class="infoTableHeader"> 
            <td colspan="2">Shipping Information</td>
        </tr>
        <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><?php echo $_POST['txtShippingFirstName']; ?>
                <input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php echo $_POST['txtShippingFirstName']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><?php echo $_POST['txtShippingLastName']; ?>
                <input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php echo $_POST['txtShippingLastName']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><?php echo $_POST['txtShippingAddress']; ?>
                <input name="hidShippingAddress" type="hidden" id="hidShippingAddress" value="<?php echo $_POST['txtShippingAddress']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Phone Number</td>
            <td class="content"><?php echo $_POST['txtShippingPhone'];  ?>
                <input name="hidShippingPhone" type="hidden" id="hidShippingPhone" value="<?php echo $_POST['txtShippingPhone']; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">State</td>
            <td class="content"><?php echo $_POST['txtShippingState']; ?> <input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php echo $_POST['txtShippingState']; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><?php echo $_POST['txtShippingCity']; ?>
                <input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php echo $_POST['txtShippingCity']; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">Postal Code</td>
            <td class="content"><?php echo $_POST['txtShippingPostalCode']; ?>
                <input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php echo $_POST['txtShippingPostalCode']; ?>"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
        <p align="center"> 
        <input name="btnBack" type="button" id="btnBack" value="&lt;&lt; Modify Shipping/Payment Info" onClick="window.location.href='checkout.php?step=1';" class="box">
        &nbsp;&nbsp; 
        <input name="btnConfirm" type="submit" id="btnConfirm" value="Confirm Order &gt;&gt;" class="box">
</form>
<p>&nbsp;</p>
