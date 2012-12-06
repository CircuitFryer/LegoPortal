<?php
/*
	File: checkoutFunctions.php, functions related to assisting in the checkout process.
	Author: Faisal Mahmood, Justin Phillips
*/
require_once './library/commonMethods.php';

/*
	Saves an order into the database after completion.
	Precondition: None
	Postcondition: The order has been saved and cart has been cleared.
function saveOrder()
{
	    $orderId       = 0;

	    extract($_POST);
		
		// make sure the first character in the 
		// customer and city name are properly capitalized.
		$hidShippingFirstName = ucwords($hidShippingFirstName);
		$hidShippingLastName  = ucwords($hidShippingLastName);
		$hidShippingCity      = ucwords($hidShippingCity);
				
		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		
		// save order & get order id
		$sql = "INSERT INTO Orders(OrderDate, FirstName, LastName, Address, 
		                              Phone, State, City, DestZip, ShippingCost, TotalCost, Status)
                VALUES (NOW(), '$hidShippingFirstName', '$hidShippingLastName', '$hidShippingAddress', 
				        '$hidShippingPhone', '$hidShippingState', '$hidShippingCity', '$hidShippingPostalCode', '$hidShippingCost', '$hidTotalCost', 'Waiting')";
		$result = query($sql);
		
		// get the order id
		$orderId = mysql_insert_id();
		
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "INSERT INTO OrderItems(OrderID, ItemID, Quantity)
						VALUES ($orderId, {$cartContent[$i]['ItemID']}, {$cartContent[$i]['Quantity']})";
				$result = query($sql);					
			}
		
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "UPDATE Items 
				        SET Quantity = Quantity - {$cartContent[$i]['Quantity']}
						WHERE ItemID = {$cartContent[$i]['ItemID']}";
				$result = query($sql);					
			}
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "DELETE FROM Cart";
				$result = query($sql);					
			}							
		}					
	return $orderId;
}

/*
	Get order total amount ( total purchase + shipping cost )
	Precondition: The order has been created previously.
	Postcondition: The total order cost has been returned.
	Return: The total cost of the order.
*/
function getOrderAmount($orderId)
{
	$orderAmount = 0;
	
	$sql = "SELECT SUM(Price * oi.Quantity)
	        FROM OrderItems oi, Items i 
		    WHERE oi.ItemID = i.ItemID and oi.OrderID = $orderId
			
			UNION
			
			SELECT ShippingCost 
			FROM Orders
			WHERE OrderID = $orderId";
	$result = query($sql);

	if (mysql_num_rows($result) == 2) {
		$row = mysql_fetch_row($result);
		$totalPurchase = $row[0];
		
		$row = mysql_fetch_row($result);
		$shippingCost = $row[0];
		
		$orderAmount = $totalPurchase + $shippingCost;
	}	
	
	return $orderAmount;	
}

?>