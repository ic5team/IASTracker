/* ========================================================================
* TurismeActiu API: iastracker.api.js v0.1
* ========================================================================
* Copyright 2014 Alter Sport SCCL.
* ======================================================================== 
*/

function IASTracker(url)
{

	this.version = 1;
	this.APIBaseUrl = url+"v" + this.version + '/';

	this.lastErrorMessage = "";

	this.filter = new Object();
	this.filter.entryPoint = this.APIBaseUrl + "IASFilter";

}

/*!
	Gets the last error message from IASTracker
	@returns The last error message
*/
IASTracker.prototype.getLastErrorMessage = function()
{

	return this.lastErrorMessage;

}

/*!
	Makes an AJAX Request
	@param[in] url URL where the request is made
	@param[in] id Id of the object where the results are shown
	@param[in] method HTTP Request method
	@param[in] values An object with the values to be sent
	@returns The XHTTPRequest object
*/
IASTracker.prototype.AJAXRequest = function(url, id, doneFunction, method, values)
{

	var asObject = this;
	var xhr = $.ajax({
			url: url, 
			type: method, 
			data: values
		})
		.done(function(data, textStatus, jqXHR) {

			data = JSON.parse(data);
			if(!data.hasOwnProperty('error'))
			{

				doneFunction(data.data);

			}

			$(id).html(data.html);

		})
		.fail(function(jqXHR, textStatus, errorThrown) {

            var status = jqXHR.status;
            asObject.lastErrorMessage = status + ' : ' + errorThrown;
			$(id).html(jqXHR.responseText);            

        });

	return xhr;

}

IASTracker.prototype.getIASMapFilter = function(id, doneFunction)
{

	var completeURL = this.filter.entryPoint;

	return this.AJAXRequest(completeURL, id, doneFunction, 'GET', {});

}