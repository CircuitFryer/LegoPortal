<?php
require_once '../library/commonMethods.php';
// for paging
// how many rows to show per page
$rowsPerPage = 5;
$queryString = '';
$sql = "SELECT ItemID, Name, ImageURL
        FROM Items ORDER BY Name";
$result     = query(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

?> 
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post"  name="frmListProduct" id="frmListProduct">
<br>
 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
  <tr align="center" id="listTableHeader"> 
   <td>Product Name</td>
   <td width="75">Thumbnail</td>
   <td width="70">Modify</td>
   <td width="70">Delete</td>
  </tr>
  <?php
$parentId = 0;
if (mysql_num_rows($result) > 0) {
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)) {
		extract($row);
		
		$Thumbnail = $ImageURL;
		
		if ($i%2) {
			$class = 'row1';
		} else {
			$class = 'row2';
		}
		
		$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
   <td><a href="productIndex.php?view=detail&productId=<?php echo $ItemID; ?>"><?php echo $Name; ?></a></td>
   <td width="75" align="center"><img src="<?php echo $Thumbnail; ?>" height = "50" width = "50"></td>
   <td width="70" align="center"><a href="javascript:modifyProduct(<?php echo $ItemID; ?>);">Modify</a></td>
   <td width="70" align="center"><a href="javascript:deleteProduct(<?php echo $ItemID; ?>);">Delete</a></td>
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
   <td colspan="5" align="center">No Products Yet</td>
  </tr>
  <?php
}
?>
  <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  <tr> 
   <td colspan="5" align="right"><input name="btnAddProduct" type="button" id="btnAddProduct" value="Add Product" class="box" onClick="addProduct()"></td>
  </tr>
 </table>
 <p>&nbsp;</p>
</form>