<?php
require_once '../sessionStarter.php';
require_once './library/adminFunctions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'orderList.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Orders';
		break;

	case 'detail' :
		$content 	= 'orderDetail.php';		
		$pageTitle 	= 'Shop Admin Control Panel - Order Detail';
		break;

	case 'modify' :
		modifyStatus();
		//$content 	= 'modify.php';		
		//$pageTitle 	= 'Shop Admin Control Panel - Modify Orders';
		break;

	default :
		$content 	= 'orderList.php';		
		$pageTitle 	= 'Shop Admin Control Panel - View Orders';
}




$script    = array('./library/order.js');

require_once './template.php';
?>
