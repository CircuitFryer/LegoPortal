<?php
require_once './sessionStarter.php';
//require_once 'library/category-functions.php';
//require_once 'library/product-functions.php';
//require_once 'library/cart-functions.php';

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];

$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;

require_once 'header.php';
?>
<table width="780" border="1" align="center" cellpadding="0" cellspacing="0">
 <tr> 
  <td colspan="3">
  </td>
 </tr>
 <tr valign="top"> 
  <td width="150" height="400" id="leftnav"> 
<?php
require_once 'leftNav.php';
?>
  </td>
  <td>
<?php
if ($pdId) {
	require_once 'storeProductDetail.php';
} else {
	require_once 'storeProductList.php';
}
?>  
  </td>
  <td width="130" align="center"><?php require_once 'include/miniCart.php'; ?></td>
 </tr>
</table>
<?php
require_once 'footer.php';
?>
