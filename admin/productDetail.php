<?php
/*
	File: productDetail.php, displays detailed information on a single product in the catalog.
	Author: Stephanie Schneider
*/
require_once '../library/commonMethods.php';
require_once './library/adminFunctions.php';
checkUser();

// Check that a product has been selected.
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {
	// redirect to productIndex.php if not
	header('Location: ./prodcutIndex.php');
}

$sql = "SELECT * FROM Items WHERE ItemID = $productId";
$result = query($sql) or die('Cannot get product. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
  	 <td width="150" class="label">Product Name</td>
  	 <td class="content"> <?php echo "$Width" . "x" . "$Length" ." " . $Name; ?></td>
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
 	  <td width="150" class="label">Quantity In Stock</td>
  	 <td class="content"><?php echo number_format($Quantity); ?> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Image</td>
 	  <td class="content"><img src="<?php echo $ImageURL; ?>"></td>
  </tr>
 </table>
 <p align="center"> 
 	 <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="window.location.href='productIndex.php?view=modify&productId=<?php echo $productId; ?>';" class="box">
 	 &nbsp;&nbsp;
 	 <input name="btnBack" type="button" id="btnBack" value=" Back " onClick="window.history.back();" class="box">
 </p>
</form>
