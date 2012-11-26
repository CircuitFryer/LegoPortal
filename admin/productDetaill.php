<?php
require_once '../library/commonMethods.php';
// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {
	// redirect to index.php if product id is not present
	header('Location: ./prodcutIndex.php');
}

$sql = "SELECT Name, Description, Price, Quantity, ImageLarge
        FROM Items
		WHERE ItemID = $productId";
$result = query($sql) or die('Cannot get product. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

if ($ImageLarge) {
	$ImageLarge = '../images/product/' . $ImageLarge;
} else {
	$ImageLarge = '../images/No-Image-Large.png';
}


?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <?php echo $Name; ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"><?php echo nl2br($Description); ?> </td>
  </tr>
  <tr> 
   <td width="150" height="36" class="label">Price</td>
   <td class="content"><?php echo number_format($Price, 2); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Qty In Stock</td>
   <td class="content"><?php echo number_format($Quantity); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"><img src="<?php echo $ImageLarge; ?>"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="window.location.href='productIndex.php?view=modify&productId=<?php echo $productId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>
