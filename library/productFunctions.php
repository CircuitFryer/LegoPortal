<?php
require_once 'commonMethods.php';

function getProductDetail($pdId)
{
	
	$_SESSION['shoppingReturnUrl'] = $_SERVER['REQUEST_URI'];
	
	// get the product information from database
	$sql = "SELECT Name, Description, Price, ImageLarge, Quantity
			FROM Items
			WHERE ItemID = $pdId";
	
	$result = query($sql);
	$row    = mysql_fetch_assoc($result);
	extract($row);
	
	$row['Description'] = nl2br($row['Description']);
	
	if ($row['ImageLarge']) {
		$row['ImageLarge'] = '../images/product/' . $row['ImageLarge'];
	} else {
		$row['ImageLarge'] = '../images/No-Image-Large.png';
	}
	
	$row['cart_url'] = "../cart.php?action=add&p=$pdId";
	
	return $row;			
}



?>