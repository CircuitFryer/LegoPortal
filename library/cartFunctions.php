<?php
require_once './sessionStarter.php';
require_once 'commonMethods.php';

function addToCart()
{
	// make sure the product id exist
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productId = (int)$_GET['p'];
	} else {
		header('Location: ../storeIndex.php');
	}
	
	// does the product exist ?
	$sql = "SELECT ItemID, Quantity
	        FROM Items
			WHERE ItemID = $productId";
	$result = query($sql);
	
	if (mysql_num_rows($result) != 1) {
		// the product doesn't exist
		header('Location: ../cart.php');
	} else {
		// how many of this product we
		// have in stock
		$row = mysql_fetch_assoc($result);
		$currentStock = $row['Quantity'];

		if ($currentStock == 0) {
			// we no longer have this product in stock
			// show the error message
			setError('The product you requested is no longer in stock');
			header('Location: ../cart.php');
			exit;
		}

	}		
	

	$sql = "SELECT ItemID
	        FROM Cart
			WHERE ItemID = $productId";
	$result = query($sql);
	
	if (mysql_num_rows($result) == 0) {
		// put the product in cart table
		$sql = "INSERT INTO Cart (ItemID, Quantity)
				VALUES ($productId, 1)";
		$result = query($sql);
	} else {
		// update product quantity in cart table
		$sql = "UPDATE Cart
		        SET Quantity = Quantity + 1
				WHERE ItemID = $productId";		
				
		$result = query($sql);		
	}	
	
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	
	header('Location: ' . $_SESSION['shop_return_url']);				
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	$cartContent = array();

	$sql = "SELECT ct.ItemID, ct.Quantity, Name, Price, Thumbnail
			FROM Cart ct, Items i
			WHERE ct.ItemID = i.ItemID";
	
	$result = query($sql);
	
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['Thumbnail']) {
			$row['Thumbnail'] = '../images/product/' . $row['Thumbnail'];
		} else {
			$row['Thumbnail'] = '../images/No-Image-Thumbnail.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}

/*
	Remove an item from the cart
*/
function deleteFromCart()
{

		
	$sql  = "DELETE * FROM tbl_cart";

	$result = query($sql);
	
	header('Location: ../cart.php');	
}

/*
	Update item quantity in shopping cart
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
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {
			// check current stock
			$sql = "SELECT Name, Quantity
			        FROM Items 
					WHERE ItemID = {$productId[$i]}";
			$result = query($sql);
			$row    = mysql_fetch_assoc($result);
			
			if ($newQty > $row['Quantity']) {
				// we only have this much in stock
				$newQty = $row['Quantity'];

				// if the customer put more than
				// we have in stock, give a notice
				if ($row['Quantity'] > 0) {
					setError('The quantity you have requested is more than we currently have in stock. The number available is indicated in the &quot;Quantity&quot; box. ');
				} else {
					// the product is no longer in stock
					setError('Sorry, but the product you want (' . $row['Name'] . ') is no longer in stock');

					// remove this item from shopping cart
					deleteFromCart($cartId[$i]);	
					$numDeleted += 1;					
				}
			} 
							
			// update product quantity
			$sql = "UPDATE Cart
					SET Quantity = $newQty";
				
			query($sql);
		}
	}
	
	if ($numDeleted == $numItem) {
		// if all item deleted return to the last page that
		// the customer visited before going to shopping cart
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		header('Location: ../cart.php');	
	}
	
	exit;
}

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