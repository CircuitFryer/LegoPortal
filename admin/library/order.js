// JavaScript Document

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

function modifyOrderStatus(orderId)
{
	statusList = window.document.frmOrder.cboOrderStatus;
	status     = statusList.options[statusList.selectedIndex].value;
	window.location.href = 'processOrder.php?action=ship&oid=' + orderId + '&status=' + status;
}
