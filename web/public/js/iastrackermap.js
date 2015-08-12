/* ========================================================================
* Map handler object
* ========================================================================
* 2015 Alter Sport SCCL.
* ======================================================================== 
*/

function MapHandler(mapId, layersControlId, controlsId, mapDescriptors, crsDescriptors)
{

	this.baseMaps = new Object();
	this.overlayMaps = new Object();
	this.crs = this.constructCRS(crsDescriptors);
	this.layers = this.constructMapLayers(mapDescriptors);

	this.map = L.map(mapId, {
		layers: this.layers.leafletData[0],
		continuousWorld: true,
		worldCopyJump: false,
		center: center,
		zoom: 2,
	});

	this.controls = L.control.layers(this.baseMaps, this.overlayMaps, 
		{collapsed: false, autoZIndex: false});
	this.controls.addTo(this.map);
	this.controls._container.remove();
	$(layersControlId).html(this.controls.onAdd(this.map));
	this.map.on('moveend', this.computeLayers);
	this.map.on('zoomend', this.computeLayers);

	$(controlsId).draggable({
		start: function() {
			this.map.dragging.disable();
		},
		stop: function() {
			this.map.dragging.enable();
		}
	});

}

MapHandler.prototype.constructCRS = function(crsDescriptors)
{

	//Construct de coordinate reference systems
	var ret = new Array();
	for(var i=0; i<crsDescriptors.length; ++i)
	{

		var currentCRS = crsDescriptors[i];
		var options = new Object();

		if(undefined !== crsDescriptors.origin)
			options.origin = crsDescriptors.origin;

		if(undefined !== crsDescriptors.transformation)
			options.transformation = crsDescriptors.transformation;

		if(undefined !== crsDescriptors.scales)
			options.scales = crsDescriptors.scales;

		if(undefined !== crsDescriptors.resolutions)
			options.resolutions = crsDescriptors.resolutions;

		if(undefined !== crsDescriptors.bounds)
			options.bounds = crsDescriptors.bounds;

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

		if(undefined !== currentMap.attribution)
			options.attribution = currentMap.attribution;

		if(undefined !== currentMap.zIndex)
			options.zIndex = currentMap.zIndex;

		if(undefined !== currentMap.subdomains)
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

		mapLayer.bounds = L.latLngBounds(
			L.latLng(currentMap.SWBoundLat, currentMap.SWBoundLon),
			L.latLng(currentMap.NEBoundLat, currentMap.NEBoundLon)
		);

		mapLayer.zMin = currentMap.minZoom;
		mapLayer.zMax = currentMap.maxZoom;
		mapLayer.name = currentMap.name;

		ret.push_back(mapLayer);

	}

	return ret;

}

MapHandler.prototype.computeLayers = function(e)
{

	var z = map.getZoom();
	var bounds = map.getBounds();

	for(var i=0; i<this.layers.length; ++i)
	{

		var currentLayer = this.layers[i];
		var intersects = bounds.intersects(currentLayer.bounds);

		if((z >= currentLayer.zMin && z <= currentLayer.zMax) && intersects)
		{

			this.controls.addOverlay(currentLayer.leafletData, currentLayer.name);

		}
		else
		{
		
			this.controls.removeLayer(currentLayer.leafletData);

		}

	}

}

MapHandler.prototype.addMarker = function(lat, lon, accuracy, color, fillColor, opacity)
{

	var circle = L.circle([lat, lon], accuracy, 
		{
			color: color,
			fillColor: fillColor,
			fillOpacity: opacity
		}).addTo(this.map);

	var marker = L.marker([lat, lon]).addTo(this.map);

}
