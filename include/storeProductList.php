<?php
/*
	File: storeProductList.php, displays all of the items in the store in a list.
	Author: Stephanie Schneider, Justin Phillips
*/
require_once './library/commonMethods.php';
//Values for how to set up a page in terms of columns and rows of items.
$productsPerRow = 2;
$productsPerPage = 4;

//Selection based upon whether sorting by a specific color.
if($colorID != 0) {
	$sql = "SELECT ItemID, Name, Price, ImageURL, Quantity, ColorID
		FROM Items WHERE ColorID = $colorID
		ORDER BY ColorID, (Width * Length)";
}
else {
	$sql = "SELECT ItemID, Name, Price, ImageURL, Quantity, ColorID
		FROM Items
		ORDER BY ColorID, (Width * Length)";
}

$result     = query(getPagingQuery($sql, $productsPerPage));
$pagingLink = getPagingLink($sql, $productsPerPage, "");
$numProduct = mysql_num_rows($result);

// Make sure all the product spacing is equal with some setups.
$columnWidth = (int)(100 / $productsPerRow);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="20">
<?php 
if ($numProduct > 0 ) {

	$i = 0;
	while ($row = mysql_fetch_assoc($result)) {
	
		extract($row);
		if ($ImageURL) {
			$Thumbnail = $ImageURL;
		} else {
			$Thumbnail = './images/No-Image-Thumbnail.png';
		}
	
		if ($i % $productsPerRow == 0) {
			echo '<tr>';
		}

		// format how we display the price
		$Price = '$' . $Price;
		
		echo "<td width=\"$columnWidth%\" align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?p=$ItemID" . "\"><img src=\"$Thumbnail\" border=\"0\" width=\"75\" height=\"75\"><br>$Name</a><br>Price : $Price";

		// if the product is no longer in stock, tell the customer
		if ($Quantity <= 0) {
			echo "<br>Out Of Stock";
		}
		
		echo "</td>\r\n";
	
		if ($i % $productsPerRow == $productsPerRow - 1) {
			echo '</tr>';
		}
		
		$i += 1;
	}
	
	if ($i % $productsPerRow > 0) {
		echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>';
	}
	
} else {
?>
	<tr><td width="100%" align="center" valign="center">No products in this color.</td></tr>
<?php	
}	
?>
</table>
<p align="center"><?php echo $pagingLink; ?></p>