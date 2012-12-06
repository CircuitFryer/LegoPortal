/*
	File: product.js; contains functions to help assist in product entry and modification for admin users.
	Author: Stephanie Schneider
*/

/*
	Redirects a user to view the main product listing
	Precondition: None
	Postcondition: Browser has been redirected to main product index.
*/
function viewProduct()
{
	with (window.document.frmListProduct) {
		window.location.href = 'productIndex.php';
	}
}

/*
	Checks to see whether all fields in the add product form are filled.
	Precondition: All fields have been filled.
	Postcondition: Product entry request has been submitted.
*/
function checkAddProductForm()
{
	with (window.document.frmAddProduct) {
		if (isEmpty(txtName, 'Enter product name')) {
			return;
		} else if (isEmpty(mtxDescription, 'Enter product description')) {
			return;
		} else if (isEmpty(txtPrice, 'Enter product price')) {
			return;
		} else if (isEmpty(txtWidth, 'Enter product width in studs')) {
			return;
		} else if (isEmpty(txtLength, 'Enter product length in studs')) {
			return;
		} else if (isEmpty(txtHeight, 'Enter product height in studs')) {
			return;
		} else if (isEmpty(txtWeight, 'Enter product weight')) {
			return;
		} else if (isEmpty(txtQty, 'Enter product quantity in stock')) {
			return;
		} else {
			submit();
		}
	}
}

/*
	Redirects the browser to the add product page.
	Precondition: None
	Postcondition: Browser has been redirected to the product add page.
*/
function addProduct()
{
	window.location.href = 'productIndex.php?view=add';
}

/*
	Redirects the browser to the modify product page for chosen product.
	Precondition: None
	Postcondition: Browser has been redirected to the modify product page.
*/
function modifyProduct(productId)
{
	window.location.href = 'productIndex.php?view=modify&productId=' + productId;
}

/*
	Prompts for confirmation then redirects the browser to the delete product script.
	Precondition: User confirms deletion
	Postcondition: Browser has been redirected and the selected product has been deleted.
*/
function deleteProduct(productId)
{
	if (confirm('Delete this product?')) {
		window.location.href = 'processProduct.php?action=deleteProduct&productId=' + productId;
	}
}
