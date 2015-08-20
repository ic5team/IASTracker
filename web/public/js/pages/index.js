var iasList = null;
var mapHandler = new MapHandler("map", "layersControl", "controls", mapDescriptors, crsDescriptors);
$('.datetimepicker').datetimepicker({
	locale: 'ca',
	format: 'DD/MM/YYYY'
});
api.getIASMapFilter("#iasContents", function(data) { iasList = data; });
