/*
	File: checkout.js, helps assist with checkout to ensure entry form completion.
	Author: Stephanie Schneider.
*/

/*
	Checks to make sure the entire checkout form is filled out
	Precondition: None
	Postcondition: Form filled status has been returned.
	Return: True if form is complete, false otherwise.
*/
function checkShippingAndPaymentInfo()
{
	with (window.document.frmCheckout) {
		if (isEmpty(txtShippingFirstName, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtShippingLastName, 'Enter last name')) {
			return false;
		} else if (isEmpty(txtShippingAddress, 'Enter shipping address')) {
			return false;
		} else if (isEmpty(txtShippingPhone, 'Enter phone number')) {
			return false;
		} else if (isEmpty(txtShippingState, 'Enter shipping address state')) {
			return false;
		} else if (isEmpty(txtShippingCity, 'Enter shipping address city')) {
			return false;
		} else if (isEmpty(txtShippingPostalCode, 'Enter the shipping address postal/zip code')) {
			return false;
		}  else {
			return true;
		}
	}
}
