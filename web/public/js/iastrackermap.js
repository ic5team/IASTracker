/* ========================================================================
* Map handler object
* ========================================================================
* 2015 Alter Sport SCCL.
* ======================================================================== 
*/

function MapHandler(mapId, mapDescriptors, crsDescriptors, layersControlId, controlsId, observationsControlId)
{

	var self = this;
	this.baseMaps = new Object();
	this.overlayMaps = new Object();
	this.crs = this.constructCRS(crsDescriptors);
	this.layers = this.constructMapLayers(mapDescriptors);

	this.map = L.map(mapId, {
		layers: this.layers[0].leafletData,
		worldCopyJump: true,
		center: mapCenter,
		zoom: 2,
	});

	this.controls = L.control.layers(this.baseMaps, this.overlayMaps, 
		{collapsed: false, autoZIndex: false});
	this.controls.addTo(this.map);

	if('undefined' !== typeof layersControlId)
	{

		this.controls._container.remove();
		$('#'+layersControlId).html(this.controls.onAdd(this.map));

	}

	this.map.on('moveend', function(e) {
		self.computeLayers(e)
	});
	this.map.on('zoomend', function(e) {
		self.computeLayers(e)
	});

	this.computeLayers();

	if('undefined' !== typeof controlsId)
	{

		L.DomEvent.disableClickPropagation(L.DomUtil.get(controlsId));
		$('#'+controlsId).draggable();

	}

	if('undefined' !== typeof observationsControlId)
	{

		L.DomEvent.disableClickPropagation(L.DomUtil.get(observationsControlId));
		$('#'+observationsControlId).draggable();

	}

}

MapHandler.prototype.constructCRS = function(crsDescriptors)
{

	//Construct de coordinate reference systems
	var ret = new Array();
	for(var i=0; i<crsDescriptors.length; ++i)
	{

		var currentCRS = crsDescriptors[i];
		var options = new Object();

		if(undefined !== currentCRS.origin &&
			null !== currentCRS.origin)
			options.origin = currentCRS.origin;

		if(undefined !== currentCRS.transformation &&
			null !== currentCRS.transformation)
			options.transformation = currentCRS.transformation;

		if(undefined !== currentCRS.scales &&
			null !== currentCRS.scales)
			options.scales = currentCRS.scales;

		if(undefined !== currentCRS.resolutions &&
			null !== currentCRS.resolutions)
			options.resolutions = JSON.parse(currentCRS.resolutions);

		if(undefined !== currentCRS.bounds)
			options.bounds = currentCRS.bounds;

		ret[currentCRS.id] = new L.Proj.CRS(currentCRS.code, 
			currentCRS.proj4def, options);
			
	}

	return ret;

}

MapHandler.prototype.constructMapLayers = function(mapDescriptors)
{

	//Construct de map layers array
	var ret = new Array();
	for(var i=0; i<mapDescriptors.length; ++i)
	{

		var currentMap = mapDescriptors[i];
		var mapLayer = new Object();
		var options = new Object();

		if(undefined !== currentMap.layers)
			options.layers = currentMap.layers;

		if(undefined !== currentMap.format)
			options.format = currentMap.format;

		if(undefined !== currentMap.transparent)
			options.transparent = currentMap.transparent;

		if(undefined !== currentMap.crsId)
			options.crs = this.crs[currentMap.crsId];

		if(undefined !== currentMap.continuousWorld)
			options.continuousWorld = currentMap.continuousWorld;

		if(undefined !== currentMap.attribution && 
			null !== currentMap.attribution)
			options.attribution = currentMap.attribution;

		if(undefined !== currentMap.zIndex && 
			null !== currentMap.zIndex)
			options.zIndex = currentMap.zIndex;

		if(undefined !== currentMap.subdomains && 
			null !== currentMap.subdomains)
			options.subdomains = currentMap.subdomains;

		if(currentMap.isWMS)
		{

			mapLayer.leafletData = L.tileLayer.wms(currentMap.url, options);

		}
		else
		{

			mapLayer.leafletData = L.tileLayer(currentMap.url, options);

		}

		if(currentMap.isOverlay)
		{

			this.overlayMaps[currentMap.name] = mapLayer.leafletData;

		}
		else
		{

			this.baseMaps[currentMap.name] = mapLayer.leafletData;

		}

		if(undefined !== currentMap.SWBoundLat  && 
			null !== currentMap.SWBoundLat)
		{

			mapLayer.bounds = L.latLngBounds(
				L.latLng(currentMap.SWBoundLat, currentMap.SWBoundLon),
				L.latLng(currentMap.NEBoundLat, currentMap.NEBoundLon)
			);

		}
		else
		{

			mapLayer.bounds = null;

		}

		mapLayer.zMin = currentMap.minZoom;
		mapLayer.zMax = currentMap.maxZoom;
		mapLayer.name = currentMap.name;
		mapLayer.isVisible = true;

		ret.push(mapLayer);

	}

	return ret;

}

MapHandler.prototype.computeLayers = function(e)
{

	var z = this.map.getZoom();
	var bounds = this.map.getBounds();

	for(var i=0; i<this.layers.length; ++i)
	{

		var currentLayer = this.layers[i];

		if(null != currentLayer.bounds)
		{

			var intersects = bounds.intersects(currentLayer.bounds);

			if((z >= currentLayer.zMin && z <= currentLayer.zMax) && intersects)
			{

				if(!currentLayer.isVisible)
				{

					this.controls.addOverlay(currentLayer.leafletData, currentLayer.name);
					this.layers[i].isVisible = true;

				}

			}
			else
			{
			
				if(currentLayer.isVisible)
				{

					this.controls.removeLayer(currentLayer.leafletData);
					this.layers[i].isVisible = false;

				}

			}

		}

	}

}

MapHandler.prototype.createMarker = function(lat, lon, accuracy, color, fillColor, 
	opacity, options, callback, icon)
{

	var cbFunction = (typeof callback !== 'undefined' ? callback : null);

	var circleOptions = {
			color: color,
			fillColor: fillColor,
			fillOpacity: opacity
		};

	var marker;

	if('undefined' !== typeof icon)
	{
	
		options.icon = icon;

	}

	marker = L.marker([lat, lon], options);

	var circle = L.circle([lat, lon], accuracy, circleOptions);

	if(null != cbFunction)
		marker.on('click', cbFunction);

	return {marker : marker, circle: circle};

}

MapHandler.prototype.addMarker = function(markerObj)
{

	markerObj.marker.addTo(this.map);
	markerObj.circle.addTo(this.map);

}

MapHandler.prototype.removeMarker = function(markerObj)
{

	map.removeLayer(markerObj.marker);
	map.removeLayer(markerObj.circle);

}
