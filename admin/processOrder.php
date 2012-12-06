<?php
/*
	File: processOrder.php, order processing for administrative side, based upon action in get.
	Author: Justin Phillips
*/
require_once '../sessionStarter.php';
require_once './library/adminFunctions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'modify' :
        modifyOrder();
        break;

    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: orderIndex.php');
}


/*
	Updates an orders shipping status to shipped.
	Precondition: The order has not been shipped.
	Postcondition: The order has been marked as shipped.
*/
function modifyOrder()
{
	if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0
	    || !isset($_GET['status']) || $_GET['status'] == '') {
		header('Location: orderIndex.php');
	}
	
	$orderId = (int)$_GET['oid'];
	$status  = $_GET['status'];

	if ($status == "Shipped") {

	    $sql = "UPDATE Orders SET Status = '$status', ShipDate = NOW()
                WHERE OrderID = $orderId";
	    $result = query($sql);
	}
	header("Location: orderIndex.php?view=list");    
}

?>