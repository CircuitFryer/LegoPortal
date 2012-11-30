<?php
require_once '../library/commonMethods.php';

if (isset($_GET['status']) && $_GET['status'] != '') {
	$status = $_GET['status'];
	$sql2   = " AND Status = '$status'";
	$queryString = "&status=$status";
} else {
	$status = '';
	$sql2   = '';
	$queryString = '';
}	

// for paging
// how many rows to show per page
$rowsPerPage = 10;

$sql = "SELECT o.OrderID, OrderDate, Status,
               SUM(Price * oi.Quantity) + ShippingCost AS Amount
	    FROM Orders o, OrderItems oi, Items i 
		WHERE oi.ItemID = i.ItemID and o.OrderID = oi.OrderID $sql2
		GROUP BY OrderID
		ORDER BY OrderID";
$result     = query(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$orderStatus = array('Shipped', 'Waiting');
$orderOption = '';
foreach ($orderStatus as $stat) {
	$orderOption .= "<option value=\"$stat\"";
	if ($stat == $status) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$stat</option>\r\n";
}
?> 
<p>&nbsp;</p>
<form action="processOrder.php" method="post"  name="frmOrderList" id="frmOrderList">
 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="text">
 <tr align="center"> 
  <td align="right">View</td>
  <td width="75"><select name="cboOrderStatus" class="box" id="cboOrderStatus" onChange="viewOrder();">
    <option value="" selected>All</option>
    <?php echo $orderOption; ?>
  </select></td>
  </tr>
</table>

 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td width="60">Order #</td>
   <td width="60">Amount</td>
   <td width="150">Order Time</td>
   <td width="70">Status</td>
  </tr>
  <?php
$parentId = 0;
if (mysql_num_rows($result) > 0) {
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)) {
		extract($row);
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
   <td width="60"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=detail&oid=<?php echo $OrderID; ?>"><?php echo $OrderID; ?></a></td>
   <td width="60" align="right"><?php echo "$" . $Amount; ?></td>
   <td width="150" align="center"><?php echo $OrderDate; ?></td>
   <td width="70" align="center"><?php echo $Status; ?></td>
  </tr>
  <?php
	} // end while

?>
  <tr> 
   <td colspan="5" align="center">
   <?php 
   echo $pagingLink;
   ?></td>
  </tr>
<?php
} else {
?>
  <tr> 
   <td colspan="5" align="center">No Orders Found </td>
  </tr>
  <?php
}
?>

 </table>
 <p>&nbsp;</p>
</form>