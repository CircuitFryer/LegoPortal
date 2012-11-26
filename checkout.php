<?php
require_once './include/cartFunctions.php';
require_once './include/checkoutFunctions.php';

if (isCartEmpty()) {
	// the shopping cart is still empty
	// so checkout is not allowed
	header('Location: cart.php');
} else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 3) {
	$step = (int)$_GET['step'];

	$includeFile = '';
	if ($step == 1) {
		$includeFile = './include/shippingAndPaymentInfo.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	} else if ($step == 2) {
		$includeFile = './include/checkoutConfirmation.php';
		$pageTitle   = 'Checkout - Step 2 of 2';
	} else if ($step == 3) {
		$orderId     = saveOrder();
		$orderAmount = getOrderAmount($orderId);
		
		$_SESSION['orderId'] = $orderId;
		
		// our next action depends on the payment method
		// if the payment method is COD then show the 
		// success page but when paypal is selected
		// send the order details to paypal
		if ($_POST['hidPaymentMethod'] == 'cod') {
			header('Location: success.php');
			exit;
		} else {
			//$includeFile = 'paypal/payment.php';	
		}
	}
} else {
	// missing or invalid step number, just redirect
	header('Location: storeIndex.php');
}

require_once 'header.php';
?>
<script language="JavaScript" type="text/javascript" src="./library/checkout.js"></script>
<?php
require_once "./include/$includeFile";
require_once './include/footer.php';
?>