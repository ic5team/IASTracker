/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
	//Global parameters
	isOnline: false,
	api: null,
	userId: null,

	// Application Constructor
	initialize: function() {
		this.bindEvents();
  		$("#menuPanel").enhanceWithin().panel();

  		$(".scroll").on("click", function(e) {

			e.preventDefault();
			var dest = this.href.split("#");
			var page = '#' + dest[dest.length-1];
			$(page).attr('scrollTo', $(this).attr('scrollTo'));
			$('#titolTaxo').html(this.innerHTML);
			$("body").pagecontainer("change", page, {allowSamePageTransition : true});
			$("menuPanel").panel("close");

		});

		$('#screen8').on('pageshow', function(e) {

			var to = $(this).attr('scrollTo');

			if('undefined' !== typeof to)
			{
			
				var offset = $('#' + to + '').offset().top;
				$.mobile.silentScroll(offset);

			}

		});

		$(document).on('pagebeforechange', function(e, ob) {

			if ((ob.toPage[0].id === "splash" && (ob.options.fromPage && ob.options.fromPage[0].id !== "screen1" 
				&& ob.options.fromPage[0].id !== "screen3" && ob.options.fromPage[0].id !== "screen5"
				 && ob.options.fromPage[0].id !== "screen6")) 
				|| (ob.toPage[0].id === "screen1" && (ob.options.fromPage && ob.options.fromPage[0].id !== "splash")) 
				|| (ob.toPage[0].id === "screen2" && (ob.options.fromPage && ob.options.fromPage[0].id !== "screen1")) 
				|| (ob.toPage[0].id === "screen3" && (ob.options.fromPage && ob.options.fromPage[0].id !== "screen2" && ob.options.fromPage[0].id !== "splash")))
			{

				e.preventDefault();
				history.go(1);

			}

		});

		api = new IASTracker('http://192.168.1.195:4326/IASTracker/');
		userId = window.localStorage.getItem('userId');

	},
	// Bind Event Listeners
	//
	// Bind any events that are required on startup. Common events are:
	// 'load', 'deviceready', 'offline', and 'online'.
	bindEvents: function() {
		document.addEventListener('deviceready', this.onDeviceReady, false);
		document.addEventListener('offline', this.onOffline, false);
		document.addEventListener('online', this.onOnline, false);

		$('#btAgree').on('click', app.termsAgreed);
		$('#btNoNever').on('click', app.neverSignUp);
		$('#btSignIn').on('click', app.SignIn);
		$('#btSignUp').on('click', app.SignUp);
		$('#btCompleteData').on('click', app.completeData);


	},
	// deviceready Event Handler
	//
	// The scope of 'this' is the event. In order to call the 'receivedEvent'
	// function, we must explicitly call 'app.receivedEvent(...);'
	onDeviceReady: function() {
		app.receivedEvent('deviceready');
	},
	onOffline: function() {
		app.isOnline = false;
	},
	onOnline: function() {
		app.isOnline = true;
	},
	// Update DOM on a Received Event
	receivedEvent: function(id) {

		if('deviceready' == id)
		{

			app.isOnline = app.isConnected();
			$('#screen2').on('swipeleft', app.onHelpSwipe);
			$('#screen2').on('swiperight', app.onHelpSwipe);
			//Check for updates if there is network connection
			if(app.isOnline)
			{

				//Check for updates
				api.getIASLastUpdate(app.IASLastUpdateOk);

			}
			else
			{

				app.closeSplashScreen();

			}

		}
		
	},
	IASLastUpdateOk: function(data)
	{

		var lastUpdated = window.localStorage.getItem("lastUpdated");
		if(null == lastUpdated || lastUpdated.date < data.lastUpdated.date)
		{

			api.getIASList(app.IASListUpdated);

		}
		else
		{

			app.IASListUpdated();

		}

	},
	IASListUpdated: function(data)
	{


		if('undefined' !== typeof data)
		{

			if(data.hasOwnProperty('list'))
			{

				window.localStorage.setItem('lastUpdated', data.lastUpdated);
				window.localStorage.setItem('IASList', data.list);
				//TODO: Update windows

			}

		}
		
		var userToken = window.localStorage.getItem('userToken');
		if(null != userToken)
			api.checkUserToken(userId, userToken, app.closeSplashScreen);
		else
			app.closeSplashScreen();


	},
	isConnected: function()
	{

		return (navigator.connection.type != Connection.NONE);

	},
	closeSplashScreen: function(data)
	{

		if(('undefined' !== typeof data) && (data.hasOwnProperty('error')))
			window.localStorage.setItem('userToken', null);

		var started = window.localStorage.getItem("started");
		var dontRegister = window.localStorage.getItem("dontRegister");
		var userToken = window.localStorage.getItem("userToken");
		var starred = window.localStorage.getItem("starred");

		var isFirstTime = (null === started);
		var dontRegister = (null !== dontRegister && dontRegister);
		var isUserLogged = (null !== userToken);
		var hasStarred = (null !== starred && (0 != starred.length))

		if(hasStarred)
		{

			$('#myIASRow').on('click', app.showStarredIAS);
			$('#myIASRow').show();

		}
		else
		{

			$('#myIASRow').hide();

		}

		if(isFirstTime)
		{

			app.showUserAgreement();

		}
		else if(!isUserLogged && !dontRegister)
		{

			app.showUserNotRegistered();

		}
		else if(!isUserLogged && dontRegister)
		{

			app.showIASCurrentLocation();

		}
		else if(!hasStarred)
		{

			app.showIASCurrentLocation();

		}
		else
		{

			app.showStarredIAS();

		}


		

	},
	showUserAgreement: function()
	{

		$("body").pagecontainer("change",'#screen1');

	},
	showUserNotRegistered: function()
	{

		$("body").pagecontainer("change",'#screen3');

	},
	showIASCurrentLocation: function()
	{

		$("body").pagecontainer("change",'#screen5');

	},
	showStarredIAS: function()
	{

		$("body").pagecontainer("change",'#screen6');

	},
	termsAgreed : function()
	{

		window.localStorage.setItem("started", true);

	},
	onHelpSwipe: function(e)
	{

		var found = false;
		$('.helpWindow').each(function(index) {
			if($(this).is(':visible') && !found)
			{

				found = true;
				var next = $(this).attr('next');
				var prev = $(this).attr('prev');
				
				if('swipeleft' == e.type && ('undefined' !== typeof next))
				{

					$(this).hide();
					$('#' + next).show();

				}
				else if('swiperight' == e.type && ('undefined' !== typeof prev))
				{

					$(this).hide();
					$('#' + prev).show();

				}

			}
		});

	},
	neverSignUp: function()
	{

		window.localStorage.setItem("dontRegister", true);

	},
	SignUp: function()
	{

		var email = $('#input-signUpEmail').val();
		var hasError = false;

		if(isValidEmail(email))
		{

			$('#error-signUpEmail').addClass('hidden');
			$('#form-signUpEmail').removeClass('has-error');

		}
		else
		{

			hasError = true;
			$('#error-signUpEmail').removeClass('hidden');
			$('#form-signUpEmail').addClass('has-error');

		}

		if(!hasError)
		{

			$('#btSignUpText').hide();
			$('#btSignUpLdg').show();
			$('#btSignUp').addClass('ui-disabled');
			api.addUser(email, app.SignUpDone);

		}

	},
	SignUpDone: function(data)
	{

		if('undefined' !== typeof data)
		{

			if(data.hasOwnProperty('error'))
			{
			
				$('#btSignUpText').show();
				$('#btSignUpLdg').hide();
				$('#btSignUp').removeClass('ui-disabled');
				$('#error-generalSignUp').show();
				$('#error-general-textSignUp').html(data.error);

			}
			else
			{

				var starred = window.localStorage.getItem("starred");
				var hasStarred = (null !== starred && (0 != starred.length))
				if(hasStarred)
				{

					$("body").pagecontainer("change",'#screen6')

				}
				else
				{

					$("body").pagecontainer("change",'#screen5')

				}

			}

		}

	},
	completeData: function()
	{

		//Enviar les dades al servidor

	},
	SignIn: function()
	{

		if(app.isOnline)
		{

			var email = $('#input-email').val();
			var pw = $('#input-password').val();
			var hasError = false;

			if(isValidEmail(email))
			{

				$('#error-email').addClass('hidden');
				$('#form-email').removeClass('has-error');

			}
			else
			{

				hasError = true;
				$('#error-email').removeClass('hidden');
				$('#form-email').addClass('has-error');

			}

			if('' != pw)
			{

				$('#error-password').addClass('hidden');
				$('#form-password').removeClass('has-error');

			}
			else
			{

				hasError = true;
				$('#error-password').removeClass('hidden');
				$('#form-password').addClass('has-error');

			}

			if(!hasError)
			{

				$('#btSignInText').hide();
				$('#btSignInLdg').show();
				$('#signinSignUpBtn').addClass('ui-disabled');
				$('#notNowBtn').addClass('ui-disabled');
				$('#btNoNever').addClass('ui-disabled');
				$('#btSignIn').addClass('ui-disabled');

				api.signIn(email, pw, app.loginDone);

			}

		}
		else
		{

			app.loginDone({error: 'No internet connection' });

		}

	},
	loginDone: function(data)
	{

		if('undefined' !== typeof data)
		{

			if(data.hasOwnProperty('error'))
			{
			
				$('#btSignInText').show();
				$('#btSignInLdg').hide();
				$('#btSignIn').removeClass('ui-disabled');
				$('#signinSignUpBtn').removeClass('ui-disabled');
				$('#notNowBtn').removeClass('ui-disabled');
				$('#btNoNever').removeClass('ui-disabled');
				$('#error-general').show();
				$('#error-general-text').html(data.error);

			}
			else
			{

				$('#error-general').hide();
				window.localStorage.setItem('userId', data.id);
				window.localStorage.setItem('userToken', data.token)
				$('#input-name').val(data.fullName);
				if(data.amIExpert)
					$('#amIExpertCheckbox').prop('checked', true);
				else
					$('#amIExpertCheckbox').prop('checked', false);

				var starred = window.localStorage.getItem("starred");
				var hasStarred = (null !== starred && (0 != starred.length))
				if(hasStarred)
				{

					$("body").pagecontainer("change",'#screen6')

				}
				else
				{

					$("body").pagecontainer("change",'#screen5')

				}

			}

		}

	}

};

app.initialize();