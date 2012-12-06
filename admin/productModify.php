<?php
/*
	File: productModify.php, allows the modification of a product already in the database / store catalog.
	Author: Justin Phillips, Stephanie Schneider.
*/
require_once '../library/commonMethods.php';
require_once './library/adminFunctions.php';
checkUser();
// make sure a product id exists in get
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {
	// redirect to productIndex.php if product id is not present
	header('Location: productIndex.php');
}

// get product info
$sql = "SELECT * FROM Items WHERE ItemID = $productId";
$result = query($sql) or die('Cannot get product. ' . mysql_error());
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
  </td></tr>
  <tr> 
  	 <td width="150" class="label">Price</td>
  	 <td class="content"><input name="txtPrice" type="text" class="box" id="txtPrice" value="<?php echo $Price; ?>" size="10" maxlength="7"> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Width (studs)</td>
  	 <td class="content"><input name="txtWidth" type="text" id="txtWidth" value="<?php echo $Width; ?>" size="10" maxlength="2" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Length (studs)</td>
  	 <td class="content"><input name="txtLength" type="text" id="txtLength" value="<?php echo $Length; ?>" size="10" maxlength="2" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Height</td>
  	 <td class="content"><input name="txtHeight" type="text" id="txtHeight" value="<?php echo $Height; ?>" size="10" maxlength="5" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Weight(oz)</td>
  	 <td class="content"><input name="txtWeight" type="text" id="txtWeight" value="<?php echo $Weight; ?>"size="10" maxlength="4" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>

  <tr> 
  	 <td width="150" class="label">Quantity In Stock</td>
  	 <td class="content"><input name="txtQty" type="text" class="box" id="txtQty" value="<?php echo $Quantity;  ?>" size="10" maxlength="10" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
  	 <td width="150" class="label">Image</td>
  	 <td class="content"> <input name="txtImage" type="text" id="txtImage" class="box" value="<?php echo $ImageURL; ?>" size="75"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Modify Product" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='productIndex.php';" class="box">  
 </p>
</form>