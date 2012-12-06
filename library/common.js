/*
	File: common.js, javascript helper functions common to the whole website.
	Author: Stephanie Schneider.
*/

/*
	Strips whitespace from the beginning and end of a string
	Precondition: None
	Postcondition: A version of str has been returned free of unnecessary whitespace.
	Return: str minus excess whitespace.
*/
function trim(str)
{
	return str.replace(/^\s+|\s+$/g,'');
}


/*
	Makes sure all entry into numeric forms correspond to a number.
	Precondition: None
	Postcondition: Data has been forced to be numeric.
*/
function checkNumber(textBox)
{
	while (textBox.value.length > 0 && isNaN(textBox.value)) {
		textBox.value = textBox.value.substring(0, textBox.value.length - 1)
	}
	
	textBox.value = trim(textBox.value);
	if (textBox.value.length == 0) {
		textBox.value = 0;		
	} else {
		textBox.value = parseDouble(textBox.value);
	}

}

/*
	Check if a field is empty, displays an alert if so.
	Precondtion: None
	Postcondition: The corresponding notice has been given if necessary.
	Return: A boolean whether the field is empty.
*/
function isEmpty(formElement, message) {
	formElement.value = trim(formElement.value);
	
	_isEmpty = false;
	if (formElement.value == '') {
		_isEmpty = true;
		alert(message);
		formElement.focus();
	}
	
	return _isEmpty;
}

/*
	Select a given element in a combobox as the default.
	Precondition: None
	Postcondition: The selected value has been established as the default value.
*/
function setSelect(listElement, listValue)
{
	for (i=0; i < listElement.options.length; i++) {
		if (listElement.options[i].value == listValue)	{
			listElement.selectedIndex = i;
		}
	}	
}
