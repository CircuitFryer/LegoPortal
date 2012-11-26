<?php

require_once "/afs/umbc.edu/users/a/z/az33255/pub/www/CMSC345/library/commonMethods.php";

/*
	check login
*/
function checkUser()
{
	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['legoportal_user_id'])) {
		header('Location: ./adminLogin.php');
		exit;
	}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		logout();
	}
}

/*
	
*/
function login()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';
	
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sql = "SELECT UserID
		        FROM Users 
				WHERE Username = '$userName' AND Password = '$password'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) == 1) {
			$row = mysql_fetch_assoc($result);
			$_SESSION['legoportal_user_id'] = $row['UserID'];

			header('Location: ./adminIndex.php');
			exit;
		} else {
			$errorMessage = 'Bad login';
		}		
			
	}
	
	return $errorMessage;
}
function logout()
{
	if (isset($_SESSION['legoportal_user_id'])) {
		unset($_SESSION['legoportal_user_id']);
		session_unregister('legoportal_user_id');
	}
		
	header('Location: ./adminLogin.php');
	exit;
}
?>