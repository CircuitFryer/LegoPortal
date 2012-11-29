<?php
require_once './library/commonMethods.php';
$pageTitle = 'Lego Portal';

// if a product id is set add the product name
// to the page title but if the product id is not
// present check if a category id exist in the query string
// and add the category name to the page title
if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
	$itemID = (int)$_GET['p'];
	$sql = "SELECT Name
			FROM Items
			WHERE ItemID = $itemID";
	
	$result    = query($sql);
	$row       = mysql_fetch_assoc($result);
	$pageTitle = $row['ItemID'];
	
}
?>
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<p>&nbsp;</p>
<p align="center"><img src="./images/LegoPortal2.jpg" alt="LegoPortal"> </p>
<p>&nbsp;</p>
<link href="./include/legoPortal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="./library/common.js"></script>
</head>
<body>