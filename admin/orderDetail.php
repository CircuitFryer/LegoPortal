<?php
require_once '../library/commonMethods.php';
if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: orderIndex.php');
}

$orderId = (int)$_GET['oid'];

// get ordered items
$sql = "SELECT Name, Price, oi.Quantity
	    FROM OrderItems oi, Items i 
		WHERE oi.ItemID = i.ItemID and oi.OrderID = $orderId
		ORDER BY OrderID ASC";

$result = query($sql);
$orderedItem = array();
while ($row = mysql_fetch_assoc($result)) {
	$orderedItem[] = $row;
}


// get order information
$sql = "SELECT OrderDate, Status, FirstName, LastName, Address, 
               Phone, State, City, DestZip, ShippingCost
	    FROM Orders
		WHERE OrderID = $orderId";

$result = query($sql);
extract(mysql_fetch_assoc($result));

$orderStatus = array('Shipped', 'Waiting');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == $Status) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$status</option>\r\n";
}
?>
<p>&nbsp;</p>
<form action="" method="get" name="frmOrder" id="frmOrder">
    <table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
        <tr> 
            <td colspan="2" align="center" id="infoTableHeader">Order Detail</td>
        </tr>
        <tr> 
            <td width="150" class="label">Order Number</td>
            <td class="content"><?php echo $OrderId; ?></td>
        </tr>
        <tr> 
            <td width="150" class="label">Order Date</td>
            <td class="content"><?php echo $OrderDate; ?></td>
        </tr>
        <tr> 
            <td class="label">Status</td>
            <td class="content"> <select name="cboOrderStatus" id="cboOrderStatus" class="box">
                    <?php echo $orderOption; ?> </select> <input name="btnModify" type="button" id="btnModify" value="Modify Status" class="box" onClick="modifyOrderStatus(<?php echo $OrderId; ?>);"></td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
    <tr id="infoTableHeader"> 
        <td colspan="3">Ordered Item</td>
    </tr>
    <tr align="center" class="label"> 
        <td>Item</td>
        <td>Unit Price</td>
        <td>Total</td>
    </tr>
    <?php
$numItem  = count($orderedItem);
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++) {
	extract($orderedItem[$i]);
	$subTotal += $Price * $Quantity;
?>
    <tr class="content"> 
        <td><?php echo "$Quantity X $Name"; ?></td>
        <td align="right"><?php echo "$" . $Price; ?></td>
        <td align="right"><?php echo "$" . ($Quantity * $Price); ?></td>
    </tr>
    <?php
}
?>
    <tr class="content"> 
        <td colspan="2" align="right">Sub-total</td>
        <td align="right"><?php echo "$" . $subTotal; ?></td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Shipping</td>
        <td align="right"><?php echo "$" . $ShippingCost; ?></td>
    </tr>
    <tr class="content"> 
        <td colspan="2" align="right">Total</td>
        <td align="right"><?php echo "$" . ($ShippingCost + $subTotal); ?></td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
    <tr id="infoTableHeader"> 
        <td colspan="2">Shipping Information</td>
    </tr>
    <tr> 
        <td width="150" class="label">First Name</td>
        <td class="content"><?php echo $FirstName; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">Last Name</td>
        <td class="content"><?php echo $LastName; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">Address1</td>
        <td class="content"><?php echo $Address; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">Phone Number</td>
        <td class="content"><?php echo $Phone; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">Province / State</td>
        <td class="content"><?php echo $State; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">City</td>
        <td class="content"><?php echo $City; ?> </td>
    </tr>
    <tr> 
        <td width="150" class="label">Postal Code</td>
        <td class="content"><?php echo $DestZip; ?> </td>
    </tr>
</table>
<p>&nbsp;</p>
<p align="center"> 
    <input name="btnBack" type="button" id="btnBack" value="Back" class="box" onClick="window.history.back();">
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
