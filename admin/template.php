<html>
<!-- File: template.php, pieces together all different parts of administrator side into one screen, to allow for optimal code reuse. -->
<!-- Author: Stephanie Scheider -->
<head>
<link rel="icon" type="image/png" href="http://userpages.umbc.edu/~schneid6/img/favicon.ico">
<title><?php echo $pageTitle; ?></title>
<link href="http://userpages.umbc.edu/~schneid6/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../library/common.js"></script>
<?php
	$n = count($script);
	for ($i = 0; $i < $n; $i++) {
		if ($script[$i] != '') {
			echo '<script language="JavaScript" type="text/javascript" src="' . $script[$i] . '"></script>';
		}
	}
?>
</head>
<body>
<div id="header"><img src="http://userpages.umbc.edu/~schneid6/img/LegoPortal.jpg"></img></div>
<table border="0" class="graybox">
  <tr>

  </tr>
  <tr>
    <td width="150" valign="top" class="navArea"><p>&nbsp;</p>
      	  <a href="./adminIndex.php" class="leftnav">Home</a> 
	  <a href="./productIndex.php" class="leftnav">Product</a> 
	  <a href="./orderIndex.php" class="leftnav">Order</a>
	  <a href="./adminIndex.php?logout" class="leftnav">Logout</a>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td class="contentArea"><table border="0" >
        <tr>
          <td>
<?php
require_once $content;	 
?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center">Copyright &copy; 2012 Apature Science
</body>
</html>
