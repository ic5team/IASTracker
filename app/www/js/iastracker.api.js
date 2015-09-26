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
	this.ias = new Object();
	this.ias.entryPoint = this.APIBaseUrl + "IAS";
	this.ias.lastUpdate = 'lastUpdate';
	this.users = new Object();
	this.users.name = "Users";
	this.users.entryPoint = this.APIBaseUrl + this.users.name;
	this.users.login = "login";
	this.users.checkToken = "token";
	this.map = new Object();
	this.map.entryPoint = this.APIBaseUrl + "Maps";
	this.map.lastUpdate = 'lastUpdate';
	this.observations = new Object();
	this.observations.entryPoint = this.APIBaseUrl + "Observations";


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
	@param[in] method HTTP Request method
	@param[in] values An object with the values to be sent
	@returns The XHTTPRequest object
*/
IASTracker.prototype.AJAXRequest = function(url, doneFunction, method, values)
{

	console.log(url);
	var asObject = this;
	var xhr = $.ajax({
			url: url, 
			type: method, 
			data: values
		})
		.done(function(data, textStatus, jqXHR) {

			if('' != data)
			{

				if('object' !== typeof data)
					data = JSON.parse(data);

				if(null != doneFunction)
				{

					doneFunction(data);

				}

			}

		})
		.fail(function(jqXHR, textStatus, errorThrown) {

            var status = jqXHR.status;
            asObject.lastErrorMessage = status + ' : ' + errorThrown;

        });

	return xhr;

}

IASTracker.prototype.addUserData = function(userId, params, doneFunction)
{

	var completeURL = this.users.entryPoint + this.separator + userId;

	return this.AJAXRequest(completeURL, doneFunction, 'PUT', params);

}

IASTracker.prototype.addUser = function(email, doneFunction)
{

	var completeURL = this.users.entryPoint;
	return this.AJAXRequest(completeURL, doneFunction, 'POST', {email : email});

}

IASTracker.prototype.getIASList = function(doneFunction)
{

	var completeURL = this.ias.entryPoint;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {});

}

IASTracker.prototype.getIASLastUpdate = function(doneFunction)
{

	var completeURL = this.ias.entryPoint + this.separator + this.ias.lastUpdate;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {});

}

IASTracker.prototype.getMapLastUpdate = function(doneFunction)
{

	var completeURL = this.map.entryPoint + this.separator + this.map.lastUpdate;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {});

}

IASTracker.prototype.getMapList = function(doneFunction)
{

	var completeURL = this.map.entryPoint;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {});

}

IASTracker.prototype.signIn = function(email, pw, doneFunction)
{

	var completeURL = this.users.entryPoint + this.separator + this.users.login;
	return this.AJAXRequest(completeURL, doneFunction, 'POST', {email: email, password: pw});

}

IASTracker.prototype.checkUserToken = function(id, token, doneFunction)
{

	var completeURL = this.users.entryPoint + this.separator + id + 
		this.separator + this.users.checkToken;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {token: token});

}

IASTracker.prototype.addObservation = function(id, text, number, 
	images, coords, altitude, accuracy, doneFunction)
{

	var completeURL = this.observations.entryPoint;
	return this.AJAXRequest(completeURL, doneFunction, 'POST', {IASId: id, description: text, 
		number: number, observationImages: images, coords: coords, altitude: altitude, 
		accuracy: accuracy});	

}

IASTracker.prototype.getIASFromLocation = function(latitude, longitude, doneFunction)
{

	var completeURL = this.ias.entryPoint;
	return this.AJAXRequest(completeURL, doneFunction, 'GET', {latitude: latitude, 
		longitude: longitude});	

}