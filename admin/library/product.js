// JavaScript Document
function viewProduct()
{
	with (window.document.frmListProduct) {
		//if (cboCategory.selectedIndex == 0) {
		//	window.location.href = 'productIndex.php';
		//} else {
			window.location.href = 'productIndex.php';//?catId=' + cboCategory.options[cboCategory.selectedIndex].value;
		//}
	}
}

function checkAddProductForm()
{
	with (window.document.frmAddProduct) {
		if (isEmpty(txtName, 'Enter Product name')) {
			return;
		} else {
			submit();
		}
	}
}

function addProduct()
{
	window.location.href = 'productIndex.php?view=add';
}

function modifyProduct(productId)
{
	window.location.href = 'productIndex.php?view=modify&productId=' + productId;
}

function deleteProduct(productId)
{
	if (confirm('Delete this product?')) {
		window.location.href = 'processProduct.php?action=deleteProduct&productId=' + productId;
	}
}

function deleteImage(productId)
{
	if (confirm('Delete this image')) {
		window.location.href = 'processProduct.php?action=deleteImage&productId=' + productId;
	}
}