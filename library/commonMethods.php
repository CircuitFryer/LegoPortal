<?php
/*
	File: commonMethods.php, methods common to the whole website including database connections.
	Author: Justin Phillips
*/

//Establish a database connection.
$dbConn = mysql_connect('studentdb.gl.umbc.edu', 'az33255', 'LegoPortal') or die('MySQL connect failed. '. mysql_error());
mysql_select_db('az33255') or die('Cannot select database. ' . mysql_error());

/*
	Executes a sql query and returns the result.
	Precondition: None
	Postcondition: The query has been executed.
	Return: The result of the query.
*/
function query($sql)
{
   $result =  mysql_query($sql) or die(mysql_error());

	return $result;
}

/*
	Returns the array corresponding to result of mysql query.
	Precondition: None
	Postcondition: The array corresponding to query $result has been returned.
	Return: The array of data corresponding to $result.
*/
function fetchArray($result, $resultType = MYSQL_NUM)
{
   return mysql_fetch_array($result, $resultType);
}

/*
	Appends $sql with how many items to fetch at once for page generation.
	Precondition: None
	Postcondition: $sql has been appended for limiting results.
	Return: An updated $sql.
*/
function getPagingQuery($sql, $itemPerPage = 10)
{
	if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
		$page = (int)$_GET['page'];
	} else {
		$page = 1;
	}
	
	// start fetching from this row number
	$offset = ($page - 1) * $itemPerPage;
	
	return $sql . " LIMIT $offset, $itemPerPage";
}

/*
	Generates the paging links to navigate between pages in the store.
	Precondition: None
	Postcondition: Paging link has been created and returned.
	Return: A paging link for navigating.
*/
function getPagingLink($sql, $itemPerPage = 10, $strGet = '')
{
	$result        = query($sql);
	$pagingLink    = '';
	$totalResults  = mysql_num_rows($result);
	$totalPages    = ceil($totalResults / $itemPerPage);
	
	// how many link pages to show
	$numLinks      = 10;

		
	// create the paging links only if we have more than one page of results
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		

		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$pageNumber = (int)$_GET['page'];
		} else {
			$pageNumber = 1;
		}
		
		// print 'previous' link if past page 1
		if ($pageNumber > 1) {
			$page = $pageNumber - 1;
			if ($page > 1) {
				$prev = " <a href=\"$self?page=$page&$strGet/\">[Prev]</a> ";
			} else {
				$prev = " <a href=\"$self?$strGet\">[Prev]</a> ";
			}	
				
			$first = " <a href=\"$self?$strGet\">[First]</a> ";
		} else {
			$prev  = ''; // page one, no backtracking links.
			$first = ''; 
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$page = $pageNumber + 1;
			$next = " <a href=\"$self?page=$page&$strGet\">[Next]</a> ";
			$last = " <a href=\"$self?page=$totalPages&$strGet\">[Last]</a> ";
		} else {
			$next = ''; // last page, no forward links.
			$last = '';
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($page = $start; $page <= $end; $page++)	{
			if ($page == $pageNumber) {
				$pagingLink[] = " $page ";   // no need to create a link to current page
			} else {
				if ($page == 1) {
					$pagingLink[] = " <a href=\"$self?$strGet\">$page</a> ";
				} else {	
					$pagingLink[] = " <a href=\"$self?page=$page&$strGet\">$page</a> ";
				}	
			}
	
		}
		
		$pagingLink = implode(' | ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

/*
	Generates a combobox containing all colors in the database.
	Precondition: None
	Postcondition: A combobox of all colors in the database has been returned.
	Return: A combobox containing all colors in the database.	
*/
function buildOptions()
{	//Gather color data
	$sql = "SELECT ColorID, ColorName FROM Colors ORDER BY ColorName";
	$result = query($sql) or die('Cannot get Product. ' . mysql_error());
	
	$colors = array();
	while($row = mysql_fetch_array($result)) {
		list($id, $name) = $row;

		$colors[] = array('id' => $id, 'name' => $name);	

	}	
	
	// build combo box options
	$list = '';
	foreach ($colors as $key => $value) {
		$name     = $value['name'];
		$id	   = $value['id'];		

		$list .= "<option value=\"$id\">$name</option>\r\n";
	}
	
	return $list;
}

/*
	Checks if required fields have been stored in post.
	Precondition: None
	Postcondition: A boolean of whether all required fields are present has been returned.
	Return: A boolean of whether all required fields are in post.
*/
function checkRequiredPost($requiredField) {
	$numRequired = count($requiredField);
	$keys        = array_keys($_POST);
	
	$allFieldExist  = true;
	for ($i = 0; $i < $numRequired && $allFieldExist; $i++) {
		if (!in_array($requiredField[$i], $keys) || $_POST[$requiredField[$i]] == '') {
			$allFieldExist = false;
		}
	}
	
	return $allFieldExist;
}

/*
	Sets the session error message to $errorMessage.
	Precondition: None
	Postcondition: The session error message has been set to $errorMessage.
*/
function setError($errorMessage)
{
	if (!isset($_SESSION['error'])) {
		$_SESSION['error'] = array();
	}
	
	$_SESSION['error'][] = $errorMessage;

}

/*
	Display the current session error messages.
	Precondition: None
	Postcondition: All current session error messages have been displayed.
*/
function displayError()
{
	if (isset($_SESSION['error']) && count($_SESSION['error'])) {
		$numError = count($_SESSION['error']);
		
		echo '<table id="errorMessage" width="550" align="center" cellpadding="20" cellspacing="0"><tr><td>';
		for ($i = 0; $i < $numError; $i++) {
			echo '&#8226; ' . $_SESSION['error'][$i] . "<br>\r\n";
		}
		echo '</td></tr></table>';
		
		// remove all error messages from session
		$_SESSION['error'] = array();
	}
}
?>