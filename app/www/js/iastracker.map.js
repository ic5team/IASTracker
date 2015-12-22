/* ========================================================================
* Map handler object
* ========================================================================
* 2015 Alter Sport SCCL.
* ======================================================================== 
*/

function MapHandler(mapId, mapDescriptors, crsDescriptors, mapCenter, layersControlId, controlsId, observationsControlId)
{

	var self = this;
	this.baseMaps = new Object();
	this.overlayMaps = new Object();
	this.markersLayer = L.layerGroup();
	this.crs = this.constructCRS(crsDescriptors);
	this.layers = this.constructMapLayers(mapDescriptors);
	this.locationCircle = null;

	this.map = L.map(mapId, {
		layers: this.layers[0].leafletData,
		worldCopyJump: true,
		center: mapCenter,
		zoom: 2,
	});

	this.markersLayer.addTo(this.map);
	var collapsed = ('undefined' == layersControlId || null == layersControlId);

	this.controls = L.control.layers(this.baseMaps, this.overlayMaps, 
		{collapsed: collapsed, autoZIndex: false});
	this.controls.addTo(this.map);
	L.control.scale().addTo(this.map);

	if('undefined' !== typeof layersControlId)
	{

		$(this.controls._container).remove();
		$('#'+layersControlId).html(this.controls.onAdd(this.map));

	}

	this.map.layers = this.layers;
	this.map.on('overlayremove', function(event) {
		var found = false;
		for(var i=0; this.layers.length && !found; ++i)
		{

			found = (this.layers[i].leafletData == event.layer);
			if(found && !this.layers[i].isModifying)
				this.layers[i].isActive = false;

		}

	});

	this.map.on('overlayadd', function(event) {
		var found = false;
		for(var i=0; this.layers.length && !found; ++i)
		{

			found = (this.layers[i].leafletData == event.layer);
			if(found && !this.layers[i].isModifying)
				this.layers[i].isActive = true;

		}
	});

	this.map.on('moveend', function(e) {
		self.computeLayers(e);
	});
	this.map.on('zoomend', function(e) {
		self.computeLayers(e);
	});

	this.computeLayers();

	this.map.locate({setView: true, maxZoom: 16});

	this.map.on('baselayerchange', this.closeLayerControl);
	this.map.on('overlayadd', this.closeLayerControl);
	this.map.on('overlayremove', this.closeLayerControl);

}

MapHandler.prototype.closeLayerControl = function()
{

	$(".leaflet-control-layers-expanded").removeClass("leaflet-control-layers-expanded")

}

MapHandler.prototype.setLocation = function(e)
{

	if(null != this.locationCircle)
		this.map.removeLayer(this.locationCircle);

    var radius = e.accuracy / 2;
    this.locationCircle = L.circle([e.latitude, e.longitude], radius);
    this.locationCircle.addTo(this.map);
    this.map.setView([e.latitude, e.longitude]);

}

MapHandler.prototype.showControls = function()
{

	this.controls.addTo(this.map);

}

MapHandler.prototype.removeControls = function()
{

	this.controls.removeLayer(this.map);

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

		if(undefined !== currentMap.tms)
			options.tms = currentMap.tms;

		if(undefined !== currentMap.styles)
			options.styles = currentMap.styles;

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

			this.overlayMaps[this.generateName(currentMap)] = mapLayer.leafletData;

		}
		else
		{

			this.baseMaps[this.generateName(currentMap)] = mapLayer.leafletData;

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
		mapLayer.isActive = false;
		mapLayer.desc = currentMap.desc;

		ret.push(mapLayer);

	}

	return ret;

}

MapHandler.prototype.generateName= function(map)
{

	return map.name;

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

					if(currentLayer.isActive)
					{

						this.layers[i].isModifying = true;
						this.map.addLayer(currentLayer.leafletData);
						this.layers[i].isModifying = false;

					}

					this.controls.addOverlay(currentLayer.leafletData, this.generateName(currentLayer));
					this.layers[i].isVisible = true;

				}

			}
			else
			{
			
				if(currentLayer.isVisible)
				{

					if(currentLayer.isActive)
					{

						this.layers[i].isModifying = true;
						this.map.removeLayer(currentLayer.leafletData);
						this.layers[i].isModifying = false;

					}

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

	if('undefined' == typeof options)
		options = {};

	if('undefined' !== typeof icon)
	{
	
		options.icon = icon;

	}

	if(null != cbFunction)
		options.cbFunction = cbFunction;

	marker = L.marker([lat, lon], options);

	var circle = L.circle([lat, lon], accuracy, circleOptions);


	return {marker : marker, circle: circle};

}

MapHandler.prototype.addMarker = function(markerObj, setView)
{

	this.markersLayer.addLayer(markerObj.marker);
	this.markersLayer.addLayer(markerObj.circle);

	if(setView)
	{

		this.map.setView(markerObj.marker._latlng, 16, {animate: true});

	}

}

MapHandler.prototype.removeMarker = function(markerObj)
{

	this.markersLayer.removeLayer(markerObj.marker);
	this.markersLayer.removeLayer(markerObj.circle);

}

MapHandler.prototype.addLayer = function(layer)
{

	layer.addTo(this.map);

}

MapHandler.prototype.removeLayer = function(layer)
{

	this.map.removeLayer(layer);

}

MapHandler.prototype.destroy = function()
{

	this.map.remove();

}