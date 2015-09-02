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

	this.separator = '/';
	this.filter = new Object();
	this.filter.name = "IASFilter";
	this.filter.entryPoint = this.APIBaseUrl + this.filter.name;
	this.observations = new Object();
	this.observations.name = "Observations"
	this.observations.entryPoint = this.APIBaseUrl + this.observations.name;
	this.ias = new Object();
	this.ias.entryPoint = this.APIBaseUrl + "IAS";

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
			var auxData = data;

			if(null != id)
			{

				$(id).html(data.html);
				auxData = data.data;

			}

			if(!data.hasOwnProperty('error'))
			{

				doneFunction(auxData);

			}

		})
		.fail(function(jqXHR, textStatus, errorThrown) {

            var status = jqXHR.status;
            asObject.lastErrorMessage = status + ' : ' + errorThrown;
			$(id).html(jqXHR.responseText);            

        });

	return xhr;

}

IASTracker.prototype.getIASMapFilter = function(doneFunction, destinationId)
{

	var completeURL = this.filter.entryPoint;
	var destId = (typeof destinationId === 'undefined') ? null : destinationId;

	return this.AJAXRequest(completeURL, destId, doneFunction, 'GET', {});

}

IASTracker.prototype.getObservations = function(doneFunction, destinationId)
{

	var completeURL = this.observations.entryPoint;
	var destId = (typeof destinationId === 'undefined') ? null : destinationId;

	return this.AJAXRequest(completeURL, destId, doneFunction, 'GET', {});

}

IASTracker.prototype.getIASObservation = function(observationId, doneFunction, destinationId)
{

	var completeURL = this.observations.entryPoint + this.separator + observationId;
	var destId = (typeof destinationId === 'undefined') ? null : destinationId;

	return this.AJAXRequest(completeURL, destId, doneFunction, 'GET', {});

}

IASTracker.prototype.getIAS = function(IASId, doneFunction, destinationId)
{

	var completeURL = this.ias.entryPoint + this.separator + IASId;
	var destId = (typeof destinationId === 'undefined') ? null : destinationId;

	return this.AJAXRequest(completeURL, destId, doneFunction, 'GET', {});

}

IASTracker.prototype.getIASObservations = function(IASId, doneFunction, destinationId)
{

	var completeURL = this.ias.entryPoint + this.separator + IASId + 
		this.separator + this.observations.name;
	var destId = (typeof destinationId === 'undefined') ? null : destinationId;

	return this.AJAXRequest(completeURL, destId, doneFunction, 'GET', {});

}