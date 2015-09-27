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
var urlPublic = 'http://192.168.1.195:4326/IASTracker/';
var imgURL = 'http://192.168.1.195:4326/IASTracker/img/';
var fotosImgURL = 'http://192.168.1.195:4326/IASTracker/img/fotos/';
var app = {
	//Global parameters
	isOnline: false,
	api: null,
	userId: null,
	IASList: null,
	TaxonList: null,
	starredIAS: null,
	iNumDownloadedFiles: 0,
	iDownloadsStarted: 0,
	mLocation: null,
	MapHandler: null,
	OtherMapHandler: null,
	locationImages: null,
	backDisabled: false,
	IASPendingObservations: null,
	isUploadingPendingObservations: false,
	bWaitingIAS: false,
	bWaitingForLocation: false,
	mMarker: null,
	GPSSkip: false,
	waitingForGPSTO: null,
	profileImage: '',

	// Application Constructor
	initialize: function() {
		this.bindEvents();

		$('#screen5').on('pageshow', function(e) {

			app.bWaitingIAS = true;
			$('#waitingIAS').show();
			$('#locatedIAS').hide();
			if(null != app.mLocation)
			{

				api.getIASFromLocation(app.mLocation.coords.latitude, app.mLocation.coords.longitude, app.iasLocated);

			}
		});

		$('#screen6').on('pageshow', function(e) {

			$(".iasBlock").off('click');
			$(".iasBlock").on('click', function(e) {

				app.showIAS($(this).attr('data-pos'), $(this).attr('data-taxonId'), '#screen6');

			});

			$(".iasName").off('click');
			$(".iasName").on('click', function(e) {

				app.starIAS($(this).attr('data-id'));
				return false;

			});
		});

		$('#screen8').on('pageshow', function(e) {

			var to = $(this).attr('scrollTo');

			if('undefined' !== typeof to)
			{
			
				var offset = $('#' + to + '').offset().top;
				$.mobile.silentScroll(offset);

			}

		});

		$('#screen11').on('pageshow', function(e) {

			$('#listCreated').hide();
			$('#createList').show();
			app.bWaitingForLocation = true;
			var mapDescriptors = JSON.parse(window.localStorage.getItem('MapList'));
			var crsDescriptors = JSON.parse(window.localStorage.getItem('MapCRSDescriptors'));
			var mapCenter = JSON.parse(window.localStorage.getItem('MapCenter'));

			if(null != app.OtherMapHandler)
				app.OtherMapHandler.destroy();

			app.OtherMapHandler = new MapHandler("otherAreasMap", mapDescriptors, crsDescriptors, mapCenter);

		});

		$('#screen14').on('pageshow', function(e) {

			var mapDescriptors = JSON.parse(window.localStorage.getItem('MapList'));
			var crsDescriptors = JSON.parse(window.localStorage.getItem('MapCRSDescriptors'));
			var mapCenter = JSON.parse(window.localStorage.getItem('MapCenter'));

			if(app.isUploadingPendingObservations)
				$('#sendingPendingObs').show();
			else
				$('#observationScreen').show();

			$('#obsSentConfirmationScreen').hide();
			$('#obsStoredScreen').hide();
			$('#obsSentErrorScreen').hide();

			if(null != app.MapHandler)
				app.MapHandler.destroy();

			app.MapHandler = new MapHandler("IASObservationMap", mapDescriptors, crsDescriptors, mapCenter);

			
			$('#numberOfSpecies').val(1);
			$('#obsText').val('');
			$('#error-no-gps').hide();

		});

		$('#numberOfSpecies').selectmenu();
		$('#obsText').textinput();
		$('#TakeImageBtn').on('click', function(e) {
			navigator.camera.getPicture( app.onCameraSuccess, app.onCameraError, 
				{
					quality : 75, 
					destinationType : Camera.DestinationType.NATIVE_URI, 
					sourceType : Camera.PictureSourceType.CAMERA, 
					allowEdit : false,
					targetWidth: 1090
				}
			);
		});

		$('#SelectImageBtn').on('click', function(e) {
			navigator.camera.getPicture( app.onCameraSuccess, app.onCameraError, 
				{
					quality : 75, 
					destinationType : Camera.DestinationType.NATIVE_URI, 
					sourceType : Camera.PictureSourceType.PHOTOLIBRARY, 
					allowEdit : false,
					targetWidth: 1090
				}
			);
		});

		$('#addNoteBtn').on('click', function(e) {
			if($('#obsText').is(':visible'))
			{
				$('#obsText').hide();
				$('#addNoteBtn').addClass('ui-icon-carat-d');
				$('#addNoteBtn').removeClass('ui-icon-carat-u');
			}
			else
			{
				$('#obsText').show();
				$('#addNoteBtn').removeClass('ui-icon-carat-d');
				$('#addNoteBtn').addClass('ui-icon-carat-u');
			}
		});

		$(document).on('pagebeforechange', function(e, ob) {

			if (app.backDisabled || 
				(ob.toPage[0].id === "splash" && (ob.options.fromPage && ob.options.fromPage[0].id !== "screen1" 
				&& ob.options.fromPage[0].id !== "screen3" && ob.options.fromPage[0].id !== "screen5"
				 && ob.options.fromPage[0].id !== "screen6")) 
				|| (ob.toPage[0].id === "screen1" && (ob.options.fromPage && ob.options.fromPage[0].id !== "splash")) 
				|| (ob.toPage[0].id === "screen3" && (ob.options.fromPage && ob.options.fromPage[0].id !== "screen2" 
					&& ob.options.fromPage[0].id !== "splash" && ob.options.fromPage[0].id !== "signupScreen")))
			{

				e.preventDefault();
				history.go(1);

			}

		});

		api = new IASTracker(urlPublic);
		app.userId = window.localStorage.getItem('userId');

	},
	iasLocated: function(data)
	{

		if('undefined' !== typeof data)
		{

			var html = '';
			for(var i=0; i<data.length; ++i)
			{

				var div = $('.iasBlock[data-id=' + data[i] +']').clone();

				html += '<div style="width: 50%; display: inline-block; text-align: center;">';
				html += div[0].outerHTML;
				html += '</div>';

			}

			$('#locatedIAS').html(html);

			$('.iasBlock').off('click');
			$(".iasBlock").on('click', function(e) {

				app.showIAS($(this).attr('data-pos'), $(this).attr('data-taxonId'), '#screen8');

			});

			$('.iasName').off('click');
			$(".iasName").on('click', function(e) {

				app.starIAS($(this).attr('data-id'));
				return false;

			});

			$('#waitingIAS').hide();
			$('#locatedIAS').show();
			app.bWaitingIAS = false;

		}

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
		$('#acceptListBtn').on('click', app.listAccepted);
		$('#closeConfirmationScreen').on('click', function(e){ 
			$('#backLinkLocation').click();
		});
		$('#closeObsStoredScreen').on('click', function(e){ 
			$('#backLinkLocation').click();
		});
		$('#closeObsNotSentScreen').on('click', function(e){ 
			$('#obsSentErrorScreen').hide();
		});
		$('#helpBt').on('click', function(e){
			$('#helpSkipBtn').attr('href', "#screen5");
			$("body").pagecontainer("change", '#screen2');
		});
		$('#cbScientificNames').on('click', function(e) 
		{

			var latinName = ($('#cbScientificNames').is(':checked'));
			$('.iasName').each(function() {
				var pos = $(this).attr('data-pos');
				var taxonId = $(this).attr('data-taxonid');
				var ias = app.IASList[taxonId][pos];

				if(latinName)
					$(this).html(ias.latinName);
				else
					$(this).html(ias.description.name);

			});

		});

		$('#userImageIcon').on('click', function(e) {
			navigator.camera.getPicture( function(imageURI) { 
				app.profileImage = imageURI; 
				$('#userImage').attr('src', imageURI); 
				$('#userImageIcon').hide();
				$('#userImage').show();
			}, app.onCameraError, 
				{
					quality : 75, 
					destinationType : Camera.DestinationType.NATIVE_URI, 
					sourceType : Camera.PictureSourceType.PHOTOLIBRARY, 
					allowEdit : false,
					targetWidth: 1090
				}
			);
		});
		$('#userImage').on('click', function(e) {
			navigator.camera.getPicture( function(imageURI) { 
				app.profileImage = imageURI; 
				$('#userImage').attr('src', imageURI); 
			}, app.onCameraError, 
				{
					quality : 75, 
					destinationType : Camera.DestinationType.NATIVE_URI, 
					sourceType : Camera.PictureSourceType.PHOTOLIBRARY, 
					allowEdit : false,
					targetWidth: 1090
				}
			);
		});
		$('#btCompleteData').on('click', app.completeProfile);

	},
	completeProfile: function()
	{

		$('#btCompleteDataText').hide();
		$('#btCompleteDataLdg').show();
		$('#btCompleteData').addClass('ui-disabled');
		$('#input-name').addClass('ui-disabled');
		$('#amIExpert').addClass('ui-disabled');
		$('#languageSelector').addClass('ui-disabled');

		if('' != app.profileImage)
		{

			app.uploadProfileImage();

		}
		else
		{
			app.completeProfileAux();
		}

	},
	uploadProfileImage: function() {

		var url = urlPublic + 'common/ajaxImageUpload.php';
		var imageURI = app.profileImage;
		var options = new FileUploadOptions();
        options.fileKey="image";
        options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
        if(-1 == options.fileName.lastIndexOf('.'))
        	options.fileName += '.jpg';

        options.mimeType="image/jpeg";
        options.chunkedMode = false;

        var ft = new FileTransfer();
        ft.upload(imageURI, url, function(r) {
        		var url = JSON.parse(r.response);
				app.profileImage = url.url;
				app.completeProfileAux();
			}, 
			function(r) {
				console.log(r.code);
			}, 
			options
		);

	},
	completeProfileAux: function()
	{

		var fullName = $('#input-name').val();
		var amIExpert = $('#amIExpert').hasClass('ui-checked');
		var languageSelector = $('#languageSelector').val();
		var token = window.localStorage.getItem('userToken');
		api.addUserData(app.userId, {token: token, name: fullName, 
			isExpert: amIExpert, language: languageSelector, imageURL: app.profileImage}, app.profileUpdated);

	},
	profileUpdated: function() 
	{

		$('#btCompleteDataText').show();
		$('#btCompleteDataLdg').hide();
		$('#btCompleteData').removeClass('ui-disabled');
		$('#input-name').removeClass('ui-disabled');
		$('#amIExpert').removeClass('ui-disabled');
		$('#languageSelector').removeClass('ui-disabled');

	},
	listAccepted: function()
	{

		var val = $('#input-list-name').val();

		if('' != val)
		{

			$('#error-no-listName').hide();
			$('#btStoreListText').hide();
			$('#btStoreListLdg').show();
			$('#acceptListBtn').addClass('ui-disabled');
			var latlng = app.mMarker.marker.getLatLng();
			api.getIASFromLocation(latlng.lat, latlng.lng, app.listAcceptedOk);

		}
		else
		{

			$('#error-no-listName').show();

		}

	},
	listAcceptedOk: function(data)
	{

		var val =  $('#input-list-name').val();

		var lists = window.localStorage.getItem('userLists');

		if(null == lists)
			lists = new Array();
		else
			lists = JSON.parse(lists);

		lists.push({name: val, list: data});
		window.localStorage.setItem('userLists', JSON.stringify(lists));

		//Add menu
		app.addListMenu(lists.length-1, val);
		$('#listCreated').show();
		$('#createList').hide();
		$('#btStoreListText').show();
		$('#btStoreListLdg').hide();
		$('#acceptListBtn').removeClass('ui-disabled');

	},
	addListMenu: function(id, name)
	{

		var menuHtml = '<div class="row menuElement" id="list' + id +'" data-id="' + id +'"><div class="col-md-12"><a href="#screenList" class="scroll">' + name + '</a></div></div>';
		$('#scrollablePanel').append(menuHtml);

		$('#list' + id).on('click', function(e) 
		{

			var lists = JSON.parse(window.localStorage.getItem('userLists'));
			var id = $(this).attr('data-id');
			var data = lists[id];
			$('#listTitle').html(data.name);
			app.viewUserList(data.list, id);

		});

	},
	viewUserList: function(data, id)
	{

		$('#btStoreListText').show();
		$('#btStoreListLdg').hide();
		$('#acceptListBtn').removeClass('ui-disabled');

		if('undefined' !== typeof data)
		{

			var html = '';
			for(var i=0; i<data.length; ++i)
			{

				var div = $('.iasBlock[data-id=' + data[i] +']').clone();

				html += '<div style="width: 50%; display: inline-block; text-align: center;">';
				html += div[0].outerHTML;
				html += '</div>';

			}

			html += '<button id="removeListBtn" class="btn btn-primary" data-id="' + id + '" style="width: 100%;">Remove list</button>';

			$('#listContent').html(html);

			$('#removeListBtn').on('click', function(e) {
				var id = $(this).attr('data-id');
				var lists = JSON.parse(window.localStorage.getItem('userLists'));
				lists.splice(id, 1);
				window.localStorage.setItem('userLists', JSON.stringify(lists));
				$('#list' + id).remove();
				$("body").pagecontainer("change", "#screen5");
			});

			$('.iasBlock').off('click');
			$(".iasBlock").on('click', function(e) {

				app.showIAS($(this).attr('data-pos'), $(this).attr('data-taxonId'), '#screenList');

			});

			$('.iasName').off('click');
			$(".iasName").on('click', function(e) {

				app.starIAS($(this).attr('data-id'));
				return false;

			});

			$('#waitingIAS').hide();
			$('#locatedIAS').show();

		}

		$('#input-name').val('');

	},
	// deviceready Event Handler
	//
	// The scope of 'this' is the event. In order to call the 'receivedEvent'
	// function, we must explicitly call 'app.receivedEvent(...);'
	onDeviceReady: function() {
		options = { enableHighAccuracy: true };
		navigator.geolocation.watchPosition(app.onLocationSuccess, app.onLocationError, options);
		app.IASPendingObservations = JSON.parse(window.localStorage.getItem('pendingObservations'));
		if(null == app.IASPendingObservations)
			app.IASPendingObservations = new Array();

		if(app.isOnline)
			app.uploadPendingObservations();
		
		app.receivedEvent('deviceready');
	},
	uploadPendingObservations: function() {

		if(0 != app.IASPendingObservations.length)
		{

			app.isUploadingPendingObservations = true;
			app.locationImages = app.IASPendingObservations[0].images;
			app.uploadImages(0);

		}

	},
	onLocationSuccess: function(position) {

		app.mLocation = position;

		if(null != app.MapHandler)
			app.MapHandler.setLocation(position.coords);

		if(null != app.waitingForGPSTO)
			clearTimeout(app.waitingForGPSTO);

		if($('#error-no-gps').is(':visible'))
			$('#error-no-gps').hide();

		if(app.waitingForGPS)
		{

			app.waitingForGPS = false;
			app.GPSSkip = true;
			app.closeSplashScreen();

		}

		if(app.bWaitingForLocation)
		{

			app.mMarker = app.OtherMapHandler.createMarker(position.coords.latitude, position.coords.longitude, 
				0, '#FFFFFF', '#FFFFFF', 0.5, {draggable: true, focus:true});
			app.OtherMapHandler.addMarker(app.mMarker);
			app.bWaitingForLocation = false;

		}

	},
	onLocationError: function(error) {

		console.log('Position error: ' + error);

	},
	onOffline: function() {
		app.isOnline = false;
	},
	onOnline: function() {
		app.isOnline = true;
		app.uploadPendingObservations();
	},
	// Update DOM on a Received Event
	receivedEvent: function(id) {

		if('deviceready' == id)
		{

			app.isOnline = isConnected();
			$('#screen2').on('swipeleft', app.onHelpSwipe);
			$('#screen2').on('swiperight', app.onHelpSwipe);
			//Check for updates if there is network connection
			if(app.isOnline)
			{

				//Check for updates
				setTimeout(function() {
					api.getIASLastUpdate(app.IASLastUpdateOk);
					api.getMapLastUpdate(app.MapLastUpdateOk);
				}, 0);

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
	MapLastUpdateOk: function(data)
	{

		var lastUpdated = window.localStorage.getItem("mapLastUpdated");
		if(null == lastUpdated || lastUpdated.date < data.lastUpdated.date)
		{

			api.getMapList(app.MapListUpdated);

		}
		else
		{

			app.MapListUpdated();

		}

	},
	IASListUpdated: function(data)
	{


		if('undefined' !== typeof data)
		{

			if(data.hasOwnProperty('list'))
			{

				window.localStorage.setItem('lastUpdated', data.lastUpdated);
				window.localStorage.setItem('IASList', JSON.stringify(data.list));
				window.localStorage.setItem('TaxonList', JSON.stringify(data.taxons));
				app.downloadData();

			}

		}
		else
		{

			app.postDownload();

		}

	},
	MapListUpdated: function(data)
	{

		if('undefined' !== typeof data)
		{

			if(data.hasOwnProperty('mapProviders'))
			{

				window.localStorage.setItem('mapLastUpdated', data.lastUpdated);
				window.localStorage.setItem('MapList', data.mapProviders);
				window.localStorage.setItem('MapCenter', data.center);
				window.localStorage.setItem('MapCRSDescriptors', data.crsDescriptors);

			}

		}

	},
	postDownload: function()
	{

		var userToken = window.localStorage.getItem('userToken');
		if(null != userToken)
		{

			api.checkUserToken(app.userId, userToken, app.closeSplashScreen);
			$('#userProfile').show();

		}
		else
			app.closeSplashScreen();

	},
	fileDownloaded: function()
	{

		app.iNumDownloadedFiles++;

		if(app.iDownloadsStarted == app.iNumDownloadedFiles)
		{

			app.postDownload();			

		}

	},
	downloadData: function()
	{

		var data = JSON.parse(window.localStorage.getItem('IASList'));
		var keys = Object.keys(data);
		app.iDownloadsStarted = 0;
		app.iNumDownloadedFiles = 0;
		for(var i=0; i<keys.length; ++i)
		{

			keysAux = Object.keys(data[keys[i]]);
			for(var j=0; j<keysAux.length; ++j)
			{

				var currentIAS = data[keys[i]][keysAux[j]];
				app.iDownloadsStarted++;
				downloadFile(imgURL + currentIAS.image.url, 'IASTracker', 'ias'+currentIAS.id, app.fileDownloaded);

			}

		}

	},
	constructWindows: function()
	{

		var screenHtml = '';
		var menuHtml = '';

		if(null != app.TaxonList)
		{

			var keys = Object.keys(app.TaxonList);
			var latinNames = $('#cbScientificNames').is(':checked');
			var path = window.localStorage.getItem('path');

			for(var i=0; i<keys.length; ++i)
			{

				if(app.IASList.hasOwnProperty(keys[i]))
				{

					var rowClass='';
					if((keys.length-1) == i)
						rowClass = 'min-height: 100vh;'

					//Add Taxon to taxon screen
					var taxon = app.TaxonList[keys[i]];
					screenHtml += '<div id="taxon' + 
						taxon.id + '" style="background-color:' + taxon.appOuterColor + ';' + rowClass + '">';
					screenHtml += '<h1>' + taxon.name +'</h1>';

					var ias = app.IASList[keys[i]];
					var iasKeys = Object.keys(ias);
					for(var j=0; j<iasKeys.length; ++j)
					{

						var current = ias[iasKeys[j]];
						var starredClass = 'fa-star-o';

						if((null != app.starredIAS) && (-1 != app.starredIAS.indexOf(current.id.toString())))
							starredClass = 'fa-star';

						var name = 'ias' + current.id +'Name';
						var block = 'ias' + current.id +'Block';

						screenHtml += '<div style="width: 50%; display: inline-block; text-align: center;">';
						screenHtml += '<div class="iasBlock" data-taxonId="' + taxon.id + '" data-id="' + current.id + '" data-pos="' + iasKeys[j] + '" style="background-color:' + taxon.appInnerColor + '; width: 95%; margin-bottom: 10px;">';
						screenHtml += '<img class="iasImage" src="' + path + '/IASTracker/ias' + current.id + '.jpg" />';

						screenHtml += '<div data-taxonId="' + taxon.id + '" data-id="' + current.id + '"" data-pos="' + iasKeys[j] + '" class="iasName">';
						if(latinNames)
							screenHtml += current.latinName;
						else
							screenHtml += current.description.name;
						screenHtml += '<i class="fa ' + starredClass +' IAS' + current.id + 'Icon"></i></div>';
						screenHtml += '</div>';
						screenHtml += '</div>';


					}

					if(0 != (iasKeys.length % 2))
						screenHtml += '<div style="width: 50%; display: inline-block;"></div></div>';

					screenHtml += '</div>';

					//Add taxon to menu
					menuHtml += '<div class="row menuElement"><div class="col-md-12"><a href="#screen8" scrollTo="taxon' + taxon.id + '" class="scroll">' + taxon.name + '</a></div></div>';

				}

			}

		}

		$('#taxonScreen').html(screenHtml);
		$('#myIASRow').after(menuHtml);

		var lists = window.localStorage.getItem('userLists');

		if(null == lists)
			lists = new Array();
		else
			lists = JSON.parse(lists);

		for(var i=0; i<lists.length; ++i)
		{

			var data = lists[i];
			app.addListMenu(i, data.name);

		}

		$("#menuPanel").enhanceWithin().panel();
  		$(".scroll").on("click", function(e) {

			e.preventDefault();
			var dest = this.href.split("#");
			var page = '#' + dest[dest.length-1];
			$(page).attr('scrollTo', $(this).attr('scrollTo'));
			$("body").pagecontainer("change", page, {allowSamePageTransition : true});
			$("menuPanel").panel("close");

		});

  		$('.iasBlock').off('click');
		$(".iasBlock").on('click', function(e) {

			app.showIAS($(this).attr('data-pos'), $(this).attr('data-taxonId'), '#screen8');

		});

		$('.iasName').off('click');
		$(".iasName").on('click', function(e) {

			app.starIAS($(this).attr('data-id'));
			return false;

		});

		app.constructMyIASWindow();

	},
	constructMyIASWindow: function()
	{

		if(null != app.starredIAS)
		{

			var html = '';
			for(var i=0; i<app.starredIAS.length; ++i)
			{

				var div = $('.iasBlock[data-id=' + app.starredIAS[i] +']').clone();

				html += '<div style="width: 50%; display: inline-block; text-align: center;">';
				html += div[0].outerHTML;
				html += '</div>';

			}

			$('#screen6 > div[data-role="content"]').html(html);

			$('.iasBlock').off('click');
			$(".iasBlock").on('click', function(e) {

				app.showIAS($(this).attr('data-pos'), $(this).attr('data-taxonId'), '#screen6');

			});

			$('.iasName').off('click');
			$(".iasName").on('click', function(e) {

				app.starIAS($(this).attr('data-id'));
				return false;

			});

		}

	},
	starIAS: function(id)
	{

		var index = -1;

		if(null != app.starredIAS)
			index = app.starredIAS.indexOf(id);
		else
		{

			app.starredIAS = new Array();

		}

		if(-1 == index)
		{

			$('.IAS' + id + 'Icon').removeClass('fa-star-o');
			$('.IAS' + id + 'Icon').addClass('fa-star');
			var div = $('.iasBlock[data-id=' + id +']').clone();
			var html = '';

			html += '<div style="width: 50%; display: inline-block; text-align: center;">';
			html += div[0].outerHTML;
			html += '</div>';

			$('#screen6 > div[data-role="content"]').append(html);

			app.starredIAS.push(id);

		}
		else
		{

			$('.IAS' + id + 'Icon').removeClass('fa-star');
			$('.IAS' + id + 'Icon').addClass('fa-star-o');
			app.starredIAS.splice(index, 1);
			app.constructMyIASWindow();

		}

		if(0 < app.starredIAS.length)
		{

			$('#myIASRow').show();

		}
		else
		{

			$('#myIASRow').hide();

		}

		window.localStorage.setItem('starred', JSON.stringify(app.starredIAS));

	},
	showIAS: function(pos, taxonId, from)
	{

		var path = window.localStorage.getItem('path');
		var ias = app.IASList[taxonId][pos];
		var taxon = app.TaxonList[taxonId];

		$('#backLink').attr('href', from);
		$('#IASCommonName').html(ias.description.name);
		$('#IASCommonName').css('color', taxon.appInnerColor);
		$('#IASLatinName').html(ias.latinName);
		$('#bigIASImage').attr('src', path + '/IASTracker/ias' + ias.id + '.jpg');
		$('#IASImageText').html(ias.image.text);

		$('#LocateIASButton').css('background-color', taxon.appInnerColor);
		$('#LocateIASButton').off('click');
		$('#LocateIASButton').on('click', function(e){
			app.locateIAS(ias.id, ias.latinName, taxon.appInnerColor);
		});

		$('#IASDescription').html(ias.description.longDescription);

		$("body").pagecontainer("change", "#screen13");

	},
	locateIAS: function(id, name, color)
	{

		app.locationImages = Array();

		$('#backLinkLocation').attr('href', "#screen13");
		$('#LocationCommonName').html(name);
		$('#LocationCommonName').css('color', color);
		$('#SendObservationButton').css('background-color', color);
		$('#SendObservationButton').off('click');
		$('#SendObservationButton').on('click', function(e) {
			app.sendObservation(id);
			return false;
		});

		$("body").pagecontainer("change", "#screen14");

	},
	onCameraSuccess: function(imageURI)
	{

		app.locationImages.push(imageURI);

	},
	onCameraError: function(message)
	{

	},
	sendObservation: function(id)
	{

		if(null != app.mLocation)
		{

			if(app.isOnline)
			{

				app.backDisabled = true;
				$('#error-no-gps').hide();
				$('#addNoteBtn').addClass('ui-disabled');
				$("#obsText").textinput( 'disable' );
				$('#numberOfSpecies').selectmenu('disable');
				$('#TakeImageBtn').addClass('ui-disabled');
				$('#SelectImageBtn').addClass('ui-disabled');
				$('#btSendIASText').hide();
				$('#btSendIASLdg').show();
				$('#SendObservationButton').addClass('ui-disabled');

				app.uploadImages(id);

			}
			else
			{

				$('#observationScreen').hide();
				$('#obsStoredScreen').show();
				$('#error-no-gps').hide();
				var text = $('#obsText').val();
				var number = $('#numberOfSpecies').val();
				var location = JSON.stringify({accuracy: app.mLocation.coords.accuracy, 
					altitude: app.mLocation.coords.altitude, latitude: app.mLocation.coords.latitude, 
					longitude: app.mLocation.coords.longitude});
				app.IASPendingObservations.push({id:id, text: text, number: number, images: app.locationImages, 
					location: location});
				window.localStorage.setItem('pendingObservations', JSON.stringify(app.IASPendingObservations));

			}

		}
		else
		{

			app.waitingForGPSTO = setTimeout(app.checkGPS, 5000);
			$('#error-no-gps').show();

		}

	},
	checkGPS: function()
	{

		options = { enableHighAccuracy: true, timeout: 4000 };
		navigator.geolocation.getCurrentPosition(app.onLocationSuccess, app.onLocationError, options);
		app.waitingForGPSTO = setTimeout(app.checkGPS, 5000);

	},
	uploadImages: function(id)
	{

		app.uploadNextImage(0, id);

	},
	uploadNextImage: function(index, id)
	{

		if(index < app.locationImages.length)
		{
	
			app.uploadImageAux(index, id);

		}
		else
		{

			app.uploadImagesFinished(id);
		}

	},
	uploadImageAux: function(index, id) {

		var url = urlPublic + 'common/obsImageUpload.php';
		var imageURI = app.locationImages[index];
		var options = new FileUploadOptions();
        options.fileKey="image";
        options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
        if(-1 == options.fileName.lastIndexOf('.'))
        	options.fileName += '.jpg';

        options.mimeType="image/jpeg";
        options.chunkedMode = false;

        var ft = new FileTransfer();
        ft.upload(imageURI, url, function(r) {
				app.locationImages[index] = r.response;
				app.uploadNextImage(index+1, id);
			}, 
			function(r) {
				//When an image is selected from the library and the app is restarted
				//the given uri is invalid. The image is discarded
				//TODO: Need to find a way 
				app.locationImages[index] = "";
				app.uploadNextImage(index+1, id);
				console.log(r.code);
			}, 
			options
		);

	},
	uploadImagesFinished: function(id)
	{

		var userToken = window.localStorage.getItem("userToken");
		if(!app.isUploadingPendingObservations)
		{
		
			var text = $('#obsText').val();
			var number = $('#numberOfSpecies').val();
			api.addObservation(id, text, number, app.locationImages, app.mLocation.coords, 
				app.mLocation.coords.altitude, app.mLocation.coords.accuracy, userToken, app.observationSent);

		}
		else
		{

			var current = app.IASPendingObservations[0];
			var location = JSON.parse(current.location);
			api.addObservation(current.id, current.text, current.number, app.locationImages, 
				{longitude: location.longitude, latitude: location.latitude}, 
				location.altitude, location.accuracy, userToken, app.observationSent);

		}

	},
	observationSent: function()
	{

		if(!app.isUploadingPendingObservations)
		{

			$('#addNoteBtn').removeClass('ui-disabled');
			$("#obsText").textinput('enable');
			$('#numberOfSpecies').selectmenu('enable');
			$('#TakeImageBtn').removeClass('ui-disabled');
			$('#SelectImageBtn').removeClass('ui-disabled');
			$('#SendObservationButton').removeClass('ui-disabled');
			$('#btSendIASText').show();
			$('#btSendIASLdg').hide();

			$('#observationScreen').hide();
			$('#obsSentConfirmationScreen').show();

			app.backDisabled = false;

		}
		else
		{

			app.IASPendingObservations.splice(0, 1);
			window.localStorage.setItem('pendingObservations', JSON.stringify(app.IASPendingObservations));

			if(0 != app.IASPendingObservations)
				app.uploadPendingObservations();
			else
			{

				$('#sendingPendingObs').hide();
				$('#observationScreen').show();
				app.isUploadingPendingObservations = false;

			}

		}

	},
	profileImageDownloaded: function(data)
	{

		var path = window.localStorage.getItem('path');
		$('#userImage').attr('src', path + '/IASTracker/user' + app.userId + '.jpg');
		$('#userImage').show();
		$('#userImageIcon').hide();

	},
	closeSplashScreen: function(data)
	{

		app.IASList = JSON.parse(window.localStorage.getItem('IASList'));
		app.TaxonList = JSON.parse(window.localStorage.getItem('TaxonList'));
		app.starredIAS = JSON.parse(window.localStorage.getItem("starred"));
		app.constructWindows();

		if(('undefined' !== typeof data) && (data.hasOwnProperty('error')))
		{

			window.localStorage.setItem('userToken', null);

		}
		else if('undefined' !== typeof data)
		{

			$('#input-name').val(data.name);
			$('#amIExpert').prop('checked', data.amIExpert);
			$('#languageSelector').val(data.languageId);
			downloadFile(fotosImgURL + data.image, 'IASTracker', 'user' + app.userId, app.profileImageDownloaded);

		}

		var started = window.localStorage.getItem("started");
		var dontRegister = window.localStorage.getItem("dontRegister");
		var userToken = window.localStorage.getItem("userToken");

		var noGPS = (null == app.mLocation && !app.GPSSkip);
		var isFirstTime = (null === started);
		var dontRegister = (null !== dontRegister && dontRegister);
		var isUserLogged = (null !== userToken);
		var hasStarred = (null !== app.starredIAS && (0 != app.starredIAS.length))

		if(hasStarred)
		{

			$('#myIASRow').on('click', app.showStarredIAS);
			$('#myIASRow').show();

		}
		else
		{

			$('#myIASRow').hide();

		}

		if(noGPS)
		{

			app.showNoGPSScreen();

		}
		else if(isFirstTime)
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
	showNoGPSScreen: function()
	{

		app.waitingForGPS = true;
		app.waitingForGPSTO = setTimeout(app.checkGPS, 5000);

		$('#noGPSSkipBtn').on('click', function() { 
			app.GPSSkip = true; 
			app.waitingForGPS = false;
			false; app.closeSplashScreen(); 
		});
		$("body").pagecontainer("change",'#noGPSScreen');

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

				window.localStorage.setItem('userId', data.id);
				window.localStorage.setItem('userToken', data.token)
				app.userId = data.id;
				downloadFile(fotosImgURL + data.image, 'IASTracker', 'user' + data.id, app.profileImageDownloaded);
				$('#userProfile').show();
				$('#error-general').hide();
				
				$('#input-name').val(data.fullName);
				if(data.amIExpert)
					$('#amIExpert').prop('checked', true);
				else
					$('#amIExpert').prop('checked', false);

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