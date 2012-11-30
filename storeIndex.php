<?php
require_once './sessionStarter.php';
require_once './library/productFunctions.php';
require_once './library/cartFunctions.php';
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];

$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
$colorID   = (isset($_GET['c']) && $_GET['c'] != '') ? $_GET['c'] : 0;

require_once 'include/header.php';
?>
<html>

<body>
<table width="780" border="1" align="center" cellpadding="0" cellspacing="0">
 <tr> 
  <td colspan="3">
  </td>
 </tr>
 <tr valign="top"> 
  <td width="150" height="400" id="leftnav"> 
<?php
require_once 'include/leftNav.php';
?>
  </td>
  <td>
<?php
if ($pdId) {
	require_once 'include/storeProductDetail.php';
} else {
	require_once 'include/storeProductList.php';
}
?>  
  </td>
  <td width="130" align="center"><?php require_once './include/miniCart.php'; ?></td>
 </tr>
</table>
</body>
</html>
<?php
require_once './include/footer.php';
?>
