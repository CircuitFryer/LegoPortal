/*
	File: order.js; contains functions to help assist in order processing for admin users.
	Author: Stephanie Schneider
*/
/*
	Redirects a user to view detailed information on a selected order.
	Precondition: None
	Postcondition: User has been redirected to the appropriate order page, returned to orderIndex itself otherwise.
*/
function viewOrder()
{
	statusList = window.document.frmOrderList.cboOrderStatus;
	status     = statusList.options[statusList.selectedIndex].value;	
	
	if (status != '') {
		window.location.href = 'orderIndex.php?status=' + status;
	} else {
		window.location.href = 'orderIndex.php';
	}
}

/*
	Redirects the browser to update an orders' shipping status based upon selected value.
	Precondition: None
	Postcondition: Order status has been updated.
*/
function modifyOrderStatus(orderId)
{
	statusList = window.document.frmOrder.cboOrderStatus;
	status     = statusList.options[statusList.selectedIndex].value;

	window.location.href = 'processOrder.php?action=modify&oid=' + orderId + '&status=' + status;
}
