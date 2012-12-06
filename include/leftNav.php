<?php
/*
	File: leftNav.php, left navigation sidebar for filtering product listings in store.
	Author: Stephanie Schneider, Justin Phillips
*/
require_once './library/commonMethods.php';

// get all colors
$colors = buildOptions();

?>
<ul>
 <li>Select a Color</li>
 <li><select name="cboColorList" class="box" id="cboColorList" onChange="location.href='./storeIndex.php?c=' + this.options[this.selectedIndex].value;">
     <option value="" selected>Select-a-Color</option>
     <option value="0">All Colors</option>
     <?php echo $colors; ?>
     </select></li>
</ul>
