<?php

require_once '../commonDBMethods.php';
// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {
	// redirect to index.php if product id is not present
	header('Location: productIndex.php');
}

// get product info
$sql = "SELECT Name, Description, Price, Quantity, ImageLarge, Thumbnail, ColorID
        FROM Items
		WHERE ItemID = $productId";
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());
$row    = mysql_fetch_assoc($result);
extract($row);

$sql = "SELECT ColorName FROM Colors WHERE ColorID = $ColorID";
$result = mysql_query($sql) or die('Cannot get color. ' . mysql_error());
$row2 = mysql_fetch_assoc($result);
extract($row2);

?> 
<form action="processProduct.php?action=modifyProduct&productId=<?php echo $productId; ?>" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <p align="center" class="formTitle">Modify Product</p>
 
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" value="<?php echo $Name; ?>" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="70" rows="10" class="box" id="mtxDescription"><?php echo $Description; ?></textarea></td>
  </tr>
  <tr> 
   <td width="150" class="label">Color</td>
   <td class="content">
<?php
	echo $ColorName;
?>	 
  </td>  </tr>
  <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" class="box" id="txtPrice" value="<?php echo $Price; ?>" size="10" maxlength="7"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity In Stock</td>
   <td class="content"><input name="txtQty" type="text" class="box" id="txtQty" value="<?php echo $Quantity;  ?>" size="10" maxlength="10"> </td>
  </tr>
  <tr> 
<?php
	 $thisMax = ini_get('upload_max_filesize');
echo $thisMax; ?>
   <td width="150" class="label">Image</td>
   <td class="content"> <input name="fileImage" type="file" id="fileImage" class="box">
<?php
	if ($Thumbnail != '') {
?>
    <br>
    <img src="<?php echo $Thumbnail; ?>"> &nbsp;&nbsp;<a href="javascript:deleteImage(<?php echo $productId; ?>);">Delete 
    Image</a> 
    <?php
	}
?>    
    </td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='productIndex.php';" class="box">  
 </p>
</form>