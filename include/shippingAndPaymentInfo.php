<?php
/*
	File: shippingAndPaymentInfo.php, gathers all user data for shipping information.
	Author: Faisal Mahmood
*/
//Check if we should be here in the checkout process.
if (!isset($_GET['step']) || (int)$_GET['step'] != 1) {
	exit;
}

$errorMessage = '&nbsp;';
?>
<script language="JavaScript" type="text/javascript" src="../library/checkout.js"></script>
<script language="JavaScript" type="text/javascript" src="../library/common.js"></script>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr> 
    	<td>Step 1 Of 3 : Enter Shipping And Payment Information </td>
    </tr>
</table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout" onSubmit="return checkShippingAndPaymentInfo();">
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
        	<td colspan="2">Shipping Information</td>
        </tr>
        <tr> 
              <td width="150" class="label">First Name</td>
              <td class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
              <td width="150" class="label">Last Name</td>
              <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
              <td width="150" class="label">Address</td>
              <td class="content"><input name="txtShippingAddress" type="text" class="box" id="txtShippingAddress" size="50" maxlength="100"></td>
        </tr>
        <tr> 
              <td width="150" class="label">Phone Number ##########</td>
              <td class="content"><input name="txtShippingPhone" type="text" class="box" id="txtShippingPhone" size="30" maxlength="10" onKeyUp="checkNumber(this);"></td>
        </tr>
        <tr> 
              <td width="150" class="label">State</td>
              <td class="content"><input name="txtShippingState" type="text" class="box" id="txtShippingState" size="30" maxlength="32"></td>
        </tr>
        <tr> 
              <td width="150" class="label">City</td>
              <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="30" maxlength="32"></td>
        </tr>
        <tr> 
              <td width="150" class="label">Zip Code</td>
              <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" onKeyUp="checkNumber(this);"></td>
        </tr>
    </table>
    
    <p>&nbsp;</p>
    <p align="center"> 
        <input class="box" name="btnStep1" type="submit" id="btnStep1" value="Proceed &gt;&gt;">
    </p>
</form>
