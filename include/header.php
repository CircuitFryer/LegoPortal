<?php
/*
	File: header.php, a generic header for all store pages.
	Author: Justin Phillips
*/
require_once './library/commonMethods.php';
$pageTitle = 'Lego Portal';

// If on a product page append the product name to the page title.
if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
	$itemID = (int)$_GET['p'];
	$sql = "SELECT Name
			FROM Items
			WHERE ItemID = $itemID";
	
	$result    = query($sql);
	$row       = mysql_fetch_assoc($result);
	$pageTitle = $row['Name'];
	
}
?>
<html>
<head>
	<link rel="icon" type="image/png" href="http://userpages.umbc.edu/~schneid6/img/favicon.ico">
	<title><?php echo $pageTitle; ?></title>
	<link href="http://userpages.umbc.edu/~schneid6/main.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="./library/common.js"></script>
</head>
<body>
	<div id="header"><img src="http://userpages.umbc.edu/~schneid6/img/LegoPortal.jpg"></img></div>