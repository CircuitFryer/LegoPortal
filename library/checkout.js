/* doubt this is needed after today, since we only need 1 set of info, will leave for now.

function setPaymentInfo(isChecked)
{
	with (window.document.frmCheckout) {
		if (isChecked) {
			txtPaymentFirstName.value  = txtShippingFirstName.value;
			txtPaymentLastName.value   = txtShippingLastName.value;
			txtPaymentAddress1.value   = txtShippingAddress1.value;
			txtPaymentAddress2.value   = txtShippingAddress2.value;
			txtPaymentPhone.value      = txtShippingPhone.value;
			txtPaymentState.value      = txtShippingState.value;			
			txtPaymentCity.value       = txtShippingCity.value;
			txtPaymentPostalCode.value = txtShippingPostalCode.value;
			
			txtPaymentFirstName.readOnly  = true;
			txtPaymentLastName.readOnly   = true;
			txtPaymentAddress1.readOnly   = true;
			txtPaymentAddress2.readOnly   = true;
			txtPaymentPhone.readOnly      = true;
			txtPaymentState.readOnly      = true;			
			txtPaymentCity.readOnly       = true;
			txtPaymentPostalCode.readOnly = true;			
		} else {
			txtPaymentFirstName.readOnly  = false;
			txtPaymentLastName.readOnly   = false;
			txtPaymentAddress1.readOnly   = false;
			txtPaymentAddress2.readOnly   = false;
			txtPaymentPhone.readOnly      = false;
			txtPaymentState.readOnly      = false;			
			txtPaymentCity.readOnly       = false;
			txtPaymentPostalCode.readOnly = false;			
		}
	}
}

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
