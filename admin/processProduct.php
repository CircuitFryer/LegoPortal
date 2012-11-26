<?php
require_once '../library/commonMethods.php';
require_once './library/adminFunctions.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

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
	
	case 'deleteImage' :
		deleteImage();
		break;
    

	default :
	    // if action is not defined or unknown
		// move to main product page
		header('Location: productIndex.php');
}


function addProduct()
{
    	$name        = $_POST['txtName'];
	$description = $_POST['mtxDescription'];
	$price       = str_replace(',', '', (double)$_POST['txtPrice']);
	$weight       = str_replace(',', '', (double)$_POST['txtWeight']);
	$qty         = (int)$_POST['txtQty'];
	$colorID     = $_POST['cboColor'];
	$images = uploadProductImage('fileImage', '../images/product');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
	$sql   = "INSERT INTO Items (Name, Description, Weight, Price, Quantity, ImageLarge, Thumbnail, ColorID)
	          VALUES ('$name', '$description', $weight, $price, $qty, '$mainImage', '$thumbnail', '$colorID')";

	$result = query($sql);
	
	header("Location: productIndex.php");	
}

/*
	Upload an image and return the uploaded image name 
*/
function uploadProductImage($inputName, $uploadDir)
{
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';
	
	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";
		
		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']); 

		// make sure the image width does not exceed the
		// maximum allowed width
		if ($width > 300) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, 300);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . rand() . ".$ext"); //. $imagePath);

		}	
		
		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, 75);
			
			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}	
		} else {
			// the product cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}
		
	}

	
	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}

/*
	Modify a product
*/
function modifyProduct()
{
	$productId   = (int)$_GET['productId'];	
   	$name        = $_POST['txtName'];
	$description = $_POST['mtxDescription'];
	$price       = str_replace(',', '', $_POST['txtPrice']);
	$qty         = $_POST['txtQty'];
	
	$images = uploadProductImage('fileImage', '../images/product/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];

	// if uploading a new image
	// remove old image
	if ($mainImage != '') {
		_deleteImage($productId);
		
		$mainImage = "'$mainImage'";
		$thumbnail = "'$thumbnail'";
	} else {
		// if we're not updating the image
		// make sure the old path remain the same
		// in the database
		$mainImage = 'ImageLarge';
		$thumbnail = 'Thumbnail';
	}
			
	$sql   = "UPDATE Items
	          SET Name = '$name', Description = '$description', Price = $price, 
			      Quantity = $qty, ImageLarge = $mainImage, Thumbnail = $thumbnail
			  WHERE ItemID = $productId";  

	$result = query($sql);
	
	header('Location: productIndex.php');			  
}

/*
	Remove a product
*/
function deleteProduct()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: productIndex.php');
	}
	
	// remove any references to this product from
	// tbl_order_item and tbl_cart
	/*$sql = "DELETE FROM tbl_order_item
	        WHERE pd_id = $productId";
	dbQuery($sql);*/
			
	/*$sql = "DELETE FROM tbl_cart
	        WHERE pd_id = $productId";	
	dbQuery($sql);*/
			
	// get the image name and thumbnail
	/*$sql = "SELECT pd_image, pd_thumbnail
	        FROM tbl_product
			WHERE pd_id = $productId";
			
	$result = dbQuery($sql);
	$row    = dbFetchAssoc($result);
	
	// remove the product image and thumbnail
	if ($row['pd_image']) {
		unlink(SRV_ROOT . 'images/product/' . $row['pd_image']);
		unlink(SRV_ROOT . 'images/product/' . $row['pd_thumbnail']);
	}*/
	
	// remove the product from database;
	$sql = "DELETE FROM Items
	        WHERE ItemID = $productId";
	query($sql);
	
	header('Location: productIndex.php');
}


/*
	Remove a product image
*/
function deleteImage()
{
	if (isset($_GET['productId']) && (int)$_GET['productId'] > 0) {
		$productId = (int)$_GET['productId'];
	} else {
		header('Location: productIndex.php');
	}
	
	$deleted = _deleteImage($productId);

	// update the image and thumbnail name in the database
	$sql = "UPDATE Items
			SET ImageLarge = '', Thumbnail = ''
			WHERE ItemID = $productId";
	query($sql);		

	header("Location: productIndex.php?view=modify&productId=$productId");
}

function _deleteImage($productId)
{
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;
	
	$sql = "SELECT ImageLarge, Thumbnail 
	        FROM Items
			WHERE ItemID = $productId";
	$result = query($sql) or die('Cannot delete product image. ' . mysql_error());
	
	if (dbNumRows($result)) {
		$row = mysql_fetch_assoc($result);
		extract($row);
		
		if ($ImageLarge && $Thumbnail) {
			// remove the image file
			$deleted = @unlink("../images/product/$ImageLarge");
			$deleted = @unlink("../images/product/$Thumbnail");
		}
	}
	
	return $deleted;
}




?>