<?php
/*
	File: cartFunctions.php, contains functions for handling items inside the store shopping cart.
	Author: Justin Phillips, Faisal Mahmood
*/
require_once './sessionStarter.php';
require_once './library/commonMethods.php';

/*
	Add an item to the shopping cart.
	Precondition: The item is still in stock.
	Postcondition: The item has been added to the cart.
*/
function addToCart()
{
	// make sure the product id is in get, redirect otherwise.
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productID = (int)$_GET['p'];
	} else {
		header('Location: ./storeIndex.php');
	}
	
	// check if the product is in the database.
	$sql = "SELECT ItemID, Quantity
	        FROM Items
			WHERE ItemID = $productID";
	$result = query($sql);
	
	if (mysql_num_rows($result) != 1) {
		// the product doesn't exist
		header('Location: ./cart.php');
	} else {
		//Check stock
		$row = mysql_fetch_assoc($result);
		$currentStock = $row['Quantity'];

		if ($currentStock == 0) {
			// Out of stock item, show error.
			setError('The product you requested is no longer in stock');
			header('Location: ./cart.php');
			exit;
		}

	}		
	
	//Check if items is already in cart, and if so, update quantity.
	$sql = "SELECT ItemID
	        FROM Cart
			WHERE ItemID = $productID";
	$result = query($sql);
	
	if (mysql_num_rows($result) == 0) {
		// put the product in the cart 
		$sql = "INSERT INTO Cart (ItemID, Quantity)
				VALUES ($productID, 1)";
		$result = query($sql);
	} else {
		// update product quantity in the cart
		$sql = "UPDATE Cart
		        SET Quantity = Quantity + 1
				WHERE ItemID = $productID";		
				
		$result = query($sql);		
	}	
		
	header('Location: ' . $_SESSION['shop_return_url']);				
}

/*
	Generates and returns a list of all items in the cart.
	Precondition: None
	Postcondition: An array of all items in the cart has been returned.
	Return: An array containing all items in the cart.
*/
function getCartContent()
{
	$cartContent = array();

	$sql = "SELECT ct.ItemID, ct.Quantity, Name, Price, ImageURL, i.Weight
			FROM Cart ct, Items i
			WHERE ct.ItemID = i.ItemID";
	
	$result = query($sql);
	
	while ($row = mysql_fetch_assoc($result)) {
		if (!$row['ImageURL']) {
			$row['ImageURL'] = '../images/No-Image-Thumbnail.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}

/*
	Remove an item from the cart completely.
	Precondition: None
	Postcondition: The selected item has been removed from the cart.
*/
function deleteFromCart()
{
	$productID = (int)$_GET['p']; //Get product id to be removed.
		
	$sql  = "DELETE FROM Cart WHERE ItemID = $productID";

	$result = query($sql);
	
	header('Location: ./cart.php');	
}

/*
	Update item quantitys in the shopping cart.
	Precondition: None
	Postcondition: All cart quantities have been updated.
*/
function updateCart()
{

	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$numDeleted = 0;
	$notice     = '';
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = (int)$itemQty[$i];
		if ($newQty < 1) {
			// Remove items from the cart if new quantity is negative,
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {
			// Check if enough in stock to update.
			$sql = "SELECT Name, Quantity
			        FROM Items 
					WHERE ItemID = {$productId[$i]}";
			$result = query($sql);
			$row    = mysql_fetch_assoc($result);
			
			if ($newQty > $row['Quantity']) {
				// we only have this much in stock
				$newQty = $row['Quantity'];

				// If request is more than in stock, update to total quantity and display error.
				if ($row['Quantity'] > 0) {
					setError('The quantity you have requested is more than we currently have in stock. The number available is indicated in the &quot;Quantity&quot; box. ');
				} else {
					// the product is no longer in stock
					setError('Sorry, but the product you want (' . $row['Name'] . ') is no longer in stock');

					// Remove this item from the shopping cart
					deleteFromCart($cartId[$i]);	
					$numDeleted += 1;					
				}
			} 
							
			// update product quantities in database.
			$sql = "UPDATE Cart
					SET Quantity = $newQty";
				
			query($sql);
		}
	}
	
	if ($numDeleted == $numItem) {
		// Return user to last page if entire cart is cleared.
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		header('Location: ./cart.php');	
	}
	
	exit;
}

/*
	Checks if the shipping cart is empty.
	Precondition: None
	Postcondition: A boolean of whether the cart is empty has been returned.
	Return: A boolean of whether the cart is empty.
*/
function isCartEmpty()
{
	$isEmpty = false;
	

	$sql = "SELECT *
			FROM Cart";
	
	$result = query($sql);
	
	if (mysql_num_rows($result) == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

?>