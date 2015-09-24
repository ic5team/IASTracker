/*!
	Checks if a value is a valid email
	@param[in] value The value to check
	@return A bool telling us if the value is a correct email or not
*/
function isValidEmail(value)
{

	var ok = false;
 
	if('' != value)
	{
	
		var re = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
		ok = re.test(value.toUpperCase());
 
	}
 
	return ok;

}

/*!
	Checks if a value is a valid password. A valid password is one with a length 
	greater than or equal to 8 characters containing lower and upper 
	case letters and a number and that doesn't contain blank spaces and without 
	accents
	@param[in] value The value to check
	@return A bool telling us if the value is a correct password or not
*/
function isValidPassword(value)
{

	var ok = false;
 
	if('' != value)
	{
	
		var re = /^(?=.*[a-zA-Z])(?=.*\d)[^ ]{8,}$/;
		ok = re.test(value);
 
	}
 
	return ok;

}