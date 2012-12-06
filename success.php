<?php
/*
	File: success.php, displayed after an order has been placed to notify of success.
	Author: Justin Phillips
*/
$pageTitle   = 'Checkout Completed Successfully';
require_once './include/header.php';

?>
<p>&nbsp;</p><table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                        <p>Thank you for shopping with Lego Portal. To continue shopping please <a href="./storeIndex.php">click 
                            here</a></p>
                  <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
</table>
<br>
<br>
<?php
require_once './include/footer.php';
?>