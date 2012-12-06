<?php
/*
	File: checkout.php, linking file to take users between the different steps of the checkout process.
	Author: Justin Phillips, Faisal Mahmood
*/
require_once './library/cartFunctions.php';
require_once './library/checkoutFunctions.php';

if (isCartEmpty()) {
	// the shopping cart is still empty, so nothing can occur.
	header('Location: cart.php');
} else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 3) {
	$step = (int)$_GET['step'];
	
	//Redirect user to the appropriate step.
	$includeFile = '';
	if ($step == 1) {
		$includeFile = 'shippingAndPaymentInfo.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	} else if ($step == 2) {
		$includeFile = 'checkoutConfirmation.php';
		$pageTitle   = 'Checkout - Step 2 of 2';
	} else if ($step == 3) {
		$orderId     = saveOrder();
		$orderAmount = getOrderAmount($orderId);
		
		header('Location: success.php');
		exit;
	}
} else {
	// missing or invalid step number, just redirect to store main page
	header('Location: storeIndex.php');
}

require_once './include/header.php';
?>
<script language="JavaScript" type="text/javascript" src="./library/checkout.js"></script>
<?php
require_once "./include/$includeFile";
require_once './include/footer.php';
?>