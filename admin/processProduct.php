<?php
/*
	File: processProduct.php, product processing for administrative side, based upon action in get.
	Author: Justin Phillips
*/
require_once '../library/commonMethods.php';
require_once './library/adminFunctions.php';
checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

//Switch based upon $action.
switch ($action) {
	
	case 'addProduct' :
		addProduct();
		break;
		
	case 'modifyProduct' :
		modifyProduct();
		break;
		
	case 'deleteProduct' :
		deleteProduct();
		break;
	
	default :
		//Default to the product index if invalid or missing action.
		header('Location: productIndex.php');
}

/*
	Adds a product to the catalog/database.
	Precondition: All fields are valid, i.e. (number fields are numeric.)
	Postcondition: A new product has been added to the database.
*/
function addProduct()
{
	//Gather all data from post.
    	$name        = $_POST['txtName'];
	$description = $_POST['mtxDescription'];
	$price       = str_replace(',', '', (double)$_POST['txtPrice']);
	$width		= str_replace(',','', (double)$_POST['txtWidth']);
	$length	= str_replace(',','', (double)$_POST['txtLength']);
	$height	= str_replace(',','', (double)$_POST['txtHeight']);
	$weight       = str_replace(',', '', (double)$_POST['txtWeight']);
	$qty         = (int)$_POST['txtQty'];
	$colorID     = $_POST['cboColor'];
	$image = 	$_POST['txtImage'];
	

	$sql   = "INSERT INTO Items (Name, Description, Width, Length, Height, Weight, Price, Quantity, ImageURL, ColorID)
	          VALUES ('$name', '$description', $width, $length, $height, $weight, $price, $qty, '$image', '$colorID')";
	//Insert the row into the database.
	$result = query($sql);
	
	header("Location: productIndex.php");	
}

/*
	Modify a product already in the catalog/database.
	Precondition: All fields are valid, i.e. (number fields are numeric.)
	Postcondition: The product has been updated.
*/
function modifyProduct()
{
	$productId   = (int)$_GET['productId'];	
   	$name        = $_POST['txtName'];
	$description = $_POST['mtxDescription'];
	$price       = str_replace(',', '', (double)$_POST['txtPrice']);
	$width		= str_replace(',','', (double)$_POST['txtWidth']);
	$length	= str_replace(',','', (double)$_POST['txtLength']);
	$height	= str_replace(',','', (double)$_POST['txtHeight']);
	$weight       = str_replace(',', '', (double)$_POST['txtWeight']);
	$qty         = $_POST['txtQty'];
	
	$imageURL = $_POST['txtImage'];
		
	$sql   = "UPDATE Items
	          SET Name = '$name', Description = '$description', Price = $price, Width = $width,
		   Length = $length, Height = $height, Weight = $weight, Quantity = $qty, ImageURL = '$imageURL'
			  WHERE ItemID = $productId";  

	$result = query($sql);
	
	header('Location: productIndex.php');			  
}

/*
	Remove a product already in the catalog/database.
	Precondition: A valid product has been selected for removal.
	Postcondition: The product has been removed from the store.
*/
function deleteProduct()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: productIndex.php');
	}
	
	// remove any references to this product from
	// OrderItems and Cart
	$sql = "DELETE FROM OrderItems
	        WHERE ItemID = $productId";
	query($sql);
			
	$sql = "DELETE FROM Cart
	        WHERE ItemID = $productId";	
	query($sql);
			
	// remove the product from database;
	$sql = "DELETE FROM Items
	        WHERE ItemID = $productId";
	query($sql);
	
	header('Location: productIndex.php');
}

?>