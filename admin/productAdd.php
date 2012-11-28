<?php
require_once '../library/commonMethods.php';

$colorList = buildOptions();
?> 
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr><td colspan="2" id="entryTableHeader">Add Product</td></tr>
  <tr> 
   <td width="150" class="label">Product Name</td>
   <td class="content"> <input name="txtName" type="text" class="box" id="txtName" size="50" maxlength="100"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"> <textarea name="mtxDescription" cols="70" rows="10" class="box" id="mtxDescription"></textarea></td>
  </tr>
  <tr> 
   <td width="150" class="label">Color</td>
   <td class="content"> <select name="cboColor" id="cboColor" class="box">
     <option value="" selected>-- Choose Color --</option>
<?php
	echo $colorList;
?>	 
    </select></td>  </tr>
  <tr> 
   <td width="150" class="label">Price</td>
   <td class="content"><input name="txtPrice" type="text" id="txtPrice" size="10" maxlength="7" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
 <tr> 
   <td width="150" class="label">Width (studs)</td>
   <td class="content"><input name="txtWidth" type="text" id="txtWidth" size="10" maxlength="2" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
 <tr> 
   <td width="150" class="label">Length (studs)</td>
   <td class="content"><input name="txtLength" type="text" id="txtLength" size="10" maxlength="2" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
 <tr> 
   <td width="150" class="label">Height</td>
   <td class="content"><input name="txtHeight" type="text" id="txtHeight" size="10" maxlength="5" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Weight(oz)</td>
   <td class="content"><input name="txtWeight" type="text" id="txtWeight" size="10" maxlength="4" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Quantity In Stock</td>
   <td class="content"><input name="txtQty" type="text" id="txtQty" size="10" maxlength="10" class="box" onKeyUp="checkNumber(this);"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image URL</td>
   <td class="content"> <input name="txtImage" type="text" id="txtImage" class="box"> 
    </td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddProduct" type="button" id="btnAddProduct" value="Add Product" onClick="checkAddProductForm();" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='productIndex.php';" class="box">  
 </p>
</form>
