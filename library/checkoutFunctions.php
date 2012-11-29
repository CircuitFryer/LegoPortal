<?php
require_once './library/commonMethods.php';

function saveOrder()
{
	$orderId       = 0;
	$shippingCost  = 0;
	$requiredField = array('hidShippingFirstName', 'hidShippingLastName', 'hidShippingAddress', 'hidShippingCity', 'hidShippingPostalCode');
						   
	if (checkRequiredPost($requiredField)) {
	    extract($_POST);
		
		// make sure the first character in the 
		// customer and city name are properly upper cased
		$hidShippingFirstName = ucwords($hidShippingFirstName);
		$hidShippingLastName  = ucwords($hidShippingLastName);
		$hidShippingCity      = ucwords($hidShippingCity);
				
		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		
		// save order & get order id
		$sql = "INSERT INTO Orders(Date, FirstName, LastName, Address, 
		                              Phone, State, City, DestZip, ShippingCost)
                VALUES (NOW(), '$hidShippingFirstName', '$hidShippingLastName', '$hidShippingAddress', 
				        '$hidShippingPhone', '$hidShippingState', '$hidShippingCity', '$hidShippingPostalCode', '$shippingCost')";
		$result = query($sql);
		
		// get the order id
		$orderId = mysql_insert_id();
		
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "INSERT INTO OrderItem(OrderID, ItemID, Quantity)
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
				$sql = "DELETE * FROM Cart";
				$result = query($sql);					
			}							
		}					
	}
	
	return $orderId;
}

/*
	Get order total amount ( total purchase + shipping cost )
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

	if (dbNumRows($result) == 2) {
		$row = mysql_fetch_row($result);
		$totalPurchase = $row[0];
		
		$row = mysql_fetch_row($result);
		$shippingCost = $row[0];
		
		$orderAmount = $totalPurchase + $shippingCost;
	}	
	
	return $orderAmount;	
}

?>