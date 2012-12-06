<?php
/* adminFunctions.php contains function involved in checking that an administrative user is verified and logged in at all times.
   Author: Justin Phillips
*/
require_once "/afs/umbc.edu/users/a/z/az33255/pub/www/CMSC345/library/commonMethods.php";

/*
	Checks to see if a user is logged in or wants to logout.
	Preconditions: None
	Postcondition: User has been redirected appropriately based upon current login status.
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
	Checks to see whether login information supplied corresponds to an account in the database.
	Precondition: The entered username and password are not empty.
	Postcondition: The user has been logged in if a valid login is used.
	Return: An error message if one occurs.
*/
function login()
{
	// Variable to contain error information.
	$errorMessage = '';
	
	//Gather login info from POST
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	
	// Chgeck the precondition.
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// Check if existing user.
		$sql = "SELECT UserID
		        FROM Users 
				WHERE Username = '$userName' AND Password = '$password'";
		$result = query($sql);
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

/*
	Logout a user.
	Precondition: User is logged in.
	Postcondition: User is now logged out.
*/
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