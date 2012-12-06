<?php
/*
	File: productIndex.php, the main index of the product catalog for admins, gathers everything
	into one location.
	Author: Stephanie Schenider, Justin Phillips
*/
require_once '../sessionStarter.php';
require_once './library/adminFunctions.php';
checkUser();

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'productList.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Product';
		break;

	case 'add' :
		$content 	= 'productAdd.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Add Product';
		break;

	case 'modify' :
		$content 	= 'productModify.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Modify Product';
		break;

	case 'detail' :
		$content    = 'productDetail.php';
		$pageTitle  = 'Shop Admin Control Panel - View Product Detail';
		break;
		
	default :
		$content 	= 'productList.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Product';
}




$script    = array('./library/product.js');

require_once './template.php';
?>
