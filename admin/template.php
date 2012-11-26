<html>
<head>
<title><?php echo $pageTitle; ?></title>
<link href="./include/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../library/common.js"></script>
<?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="../include/' . $script[$i]. '"></script>';
	}
}
?>
</head>
<body>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="1" class="graybox">
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
    <td width="600" valign="top" class="contentArea"><table width="100%" border="0" cellspacing="0" cellpadding="20">
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
