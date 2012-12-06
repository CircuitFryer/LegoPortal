<?php
/*
	File: adminIndex.php, sets up the home page of the administrator portion of the website.
	Author: Justin Phillips
*/

require_once '../sessionStarter.php';
require_once './library/adminFunctions.php';
checkUser();

$pageTitle = 'Lego Portal Administrator Home';

$script = array();

$content = 'adminMain.php';

require_once 'template.php';
?>