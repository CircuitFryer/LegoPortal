<?php
/*
	File: storeIndex.php, the main page of the store, gathers all files into one location and displays.
	Author: Stephanie Schneider
*/
require_once './sessionStarter.php';
require_once './library/productFunctions.php';
require_once './library/cartFunctions.php';


$_SESSION['shop_return_url'] = $_SERVER['REQUEST_URI'];

$pdId   = (isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : 0;
$colorID   = (isset($_GET['c']) && $_GET['c'] != '') ? $_GET['c'] : 0;

require_once 'include/header.php';
?>

<table border="1">

 <tr valign="top"> 
  <td id="leftnav"> 
<?php
require_once 'include/leftNav.php';
?>
  </td>
  <td id="center">
<?php
if ($pdId) {
	require_once 'include/storeProductDetail.php';
} else {
	require_once 'include/storeProductList.php';
}
?>  
  </td>
  <td id="rightnav"><?php require_once './include/miniCart.php'; ?></td>
 </tr>
</table>

<?php
require_once './include/footer.php';
?>
