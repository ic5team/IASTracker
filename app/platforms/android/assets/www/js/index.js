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

			if (((ob.toPage[0].id === "splash") || (ob.toPage[0].id === "screen1") 
				|| (ob.toPage[0].id === "screen2") || (ob.toPage[0].id === "screen3") 
				|| (ob.toPage[0].id === "screen4")) && ob.options.fromPage)
			{

				e.preventDefault();
				history.go(1);

			}

		});

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
				setTimeout(app.closeSplashScreen, 10000);

			}

		}
		
	},
	isConnected: function()
	{

		return (navigator.connection.type != Connection.NONE);

	},
	closeSplashScreen: function()
	{

		var started = window.localStorage.getItem("started");
		var dontRegister = window.localStorage.getItem("dontRegister");
		var userName = window.localStorage.getItem("userName");
		var starred = window.localStorage.getItem("starred");

		var isFirstTime = (null === started);
		var dontRegister = (null !== dontRegister && dontRegister);
		var isUserLogged = (null !== userName);
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

		$("body").pagecontainer("change",'#screen6')

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

		//Login

	},
	completeData: function()
	{

		//Enviar les dades al servidor

	}

};

app.initialize();