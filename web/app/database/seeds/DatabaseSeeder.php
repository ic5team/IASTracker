<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('LanguagesTableSeeder');
		$this->call('MapProviderTableSeeder');
		$this->call('MapProviderTextsTableSeeder');
		$this->call('CRSTableSeeder');
		$this->call('WMSMapProviderTableSeeder');
		$this->call('ValidatorsTableSeeder');
		$this->call('ConfigurationTableSeeder');
		$this->call('ConfigurationTextsTableSeeder');
		$this->call('IASTaxonsTableSeeder');
		$this->call('IASTableSeeder');
		$this->call('IASImagesTextTableSeeder');
		$this->call('RepositoriesTableSeeder');
		$this->call('IASRelatedDBsTableSeeder');
		$this->call('StatusTableSeeder');
		$this->call('StatusTextsTableSeeder');

	}

}

class MapProviderTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('MapProvider')->insert(array(
			'id'  => 1,
			'url' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png',
			'attribution' => '&copy; <a href="http://osm.org/copyright" title="OpenStreetMap" target="_blank">OpenStreetMap</a> contributors | Tiles Courtesy of <a href="http://www.mapquest.com/" title="MapQuest" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" width="16" height="16">',
			'zIndex' => 1,
			'SWBoundLat' => null,
			'SWBoundLon' => null,
			'NEBoundLat' => null,
			'NEBoundLon' => null,
			'minZoom' => null,
			'maxZoom' => null,
			'creatorId' => 1,
			'subdomains' => '1234',
			'isOverlay' => false,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 2,
			'url' => 'http://geoserveis.icc.cat/icc_ndvicolor/wms/service?',
			'attribution' => 'Institut Cartogràfic i Geològic de Catalunya -ICGC',
			'zIndex' => 2,
			'SWBoundLat' => '40.48456',
			'SWBoundLon' => '0.02884',
			'NEBoundLat' => '42.91822',
			'NEBoundLon' => '3.46619',
			'minZoom' => 17,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 3,
			'url' => 'http://land.discomap.eea.europa.eu/arcgis/services/Land/CLC2006_Dyna_LAEA/MapServer/WMSServer?',
			'attribution' => 'European Environment Agency (EEA)',
			'zIndex' => 2,
			'SWBoundLat' => '23.401584',
			'SWBoundLon' => '-48.213097',
			'NEBoundLat' => '72.062365',
			'NEBoundLon' => '63.874419',
			'minZoom' => 5,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 4,
			'url' => 'http://geoserveis.icc.cat/icc_mapesbase/wms/service?',
			'attribution' => 'Institut Cartogràfic i Geològic de Catalunya -ICGC',
			'zIndex' => 2,
			'SWBoundLat' => '40.48456',
			'SWBoundLon' => '0.02884',
			'NEBoundLat' => '42.91822',
			'NEBoundLon' => '3.46619',
			'minZoom' => 5,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 5,
			'url' => 'http://geoserveis.icc.cat/icc_mapesbase/wms/service?',
			'attribution' => 'Institut Cartogràfic i Geològic de Catalunya -ICGC',
			'zIndex' => 2,
			'SWBoundLat' => '40.48456',
			'SWBoundLon' => '0.02884',
			'NEBoundLat' => '42.91822',
			'NEBoundLon' => '3.46619',
			'minZoom' => 5,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 6,
			'url' => 'http://geo.agiv.be/inspire/wms/Orthobeeldvorming?',
			'attribution' => 'Geopunt.be',
			'zIndex' => 2,
			'SWBoundLat' => '50.64',
			'SWBoundLon' => '2.52',
			'NEBoundLat' => '51.51',
			'NEBoundLon' => '5.94',
			'minZoom' => 5,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 7,
			'url' => 'http://geoservices.wallonie.be/arcgis/services/IMAGERIE/ORTHO_LAST/MapServer/WMSServer?',
			'attribution' => 'Geopunt.be',
			'zIndex' => 2,
			'SWBoundLat' => '49.474629',
			'SWBoundLon' => '2.835011',
			'NEBoundLat' => '50.822978',
			'NEBoundLon' => '6.438924',
			'minZoom' => 5,
			'maxZoom' => 18,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 8,
			'url' => 'http://neowms.sci.gsfc.nasa.gov/wms/wms?',
			'attribution' => 'Remote sensing imagery from NASA Earth Observations (NEO)',
			'zIndex' => 2,
			'SWBoundLat' => null,
			'SWBoundLon' => null,
			'NEBoundLat' => null,
			'NEBoundLon' => null,
			'minZoom' => null,
			'maxZoom' => null,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProvider')->insert(array(
			'id'  => 9,
			'url' => 'http://neowms.sci.gsfc.nasa.gov/wms/wms?',
			'attribution' => 'Remote sensing imagery from NASA Earth Observations (NEO)',
			'zIndex' => 2,
			'SWBoundLat' => null,
			'SWBoundLon' => null,
			'NEBoundLat' => null,
			'NEBoundLon' => null,
			'minZoom' => null,
			'maxZoom' => null,
			'creatorId' => 1,
			'subdomains' => null,
			'isOverlay' => true,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class WMSMapProviderTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 2,
			'styles' => '',
			'layers' => 'ox3dndvi2014',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 3,
			'styles' => '',
			'layers' => '14,13,11,10,8,7,5,4,2,1',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 4,
			'styles' => '',
			'layers' => 'orto25c',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 5,
			'styles' => '',
			'layers' => 'mtc5m',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 6,
			'styles' => '',
			'layers' => 'OMZ09VLRGB',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 7,
			'styles' => '',
			'layers' => '0',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 8,
			'styles' => '',
			'layers' => 'SRTM_RAMP2_TOPO',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 2,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 9,
			'styles' => '',
			'layers' => 'MOD13A2_E_NDVI',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 2,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class CRSTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('CRS')->insert(array(
			'id'  => 1,
			'code' => 'EPSG:25831',
			'proj4def' => '+proj=utm +zone=31 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
			'origin' => null,
			'transformation' => null,
			'scales' => null,
			'resolutions' => '[1100,550,275,100,50,25,10,5,2,1,0.5,0.25]',
			'bounds' => null,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('CRS')->insert(array(
			'id'  => 2,
			'code' => 'EPSG:4326',
			'proj4def' => '+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs ',
			'origin' => null,
			'transformation' => null,
			'scales' => null,
			'resolutions' => '[1100,550,275,100,50,25,10,5,2,1,0.5,0.25]',
			'bounds' => null,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class LanguagesTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Languages')->insert(array(
			'id'  => 1,
			'name' => 'CAT',
			'locale' => 'ca',
			'flagURL' => 'cat.png',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Languages')->insert(array(
			'id'  => 2,
			'name' => 'ES',
			'locale' => 'es',
			'flagURL' => 'es.png',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Languages')->insert(array(
			'id'  => 3,
			'name' => 'FR',
			'locale' => 'fr',
			'flagURL' => 'france.gif',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Languages')->insert(array(
			'id'  => 4,
			'name' => 'EN',
			'locale' => 'en',
			'flagURL' => 'eng.jpg',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::statement('UPDATE "Users" SET "languageId"=1');

	}
}

class MapProviderTextsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('MapProviderTexts')->insert(array(
			'id'  => 1,
			'mapProviderId' => 1, 
			'languageId' => 1,
			'text' => 'Mapa d\'OSM',
			'name' => 'OSM',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 2,
			'mapProviderId' => 2, 
			'languageId' => 1,
			'text' => 'Catalunya NDVI. 2014',
			'name' => 'Catalunya NDVI. 2014',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 3,
			'mapProviderId' => 3, 
			'languageId' => 1,
			'text' => 'CORINE Landcover (CLC)',
			'name' => 'CORINE Landcover (CLC)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 4,
			'mapProviderId' => 4, 
			'languageId' => 1,
			'text' => 'Ortofoto de Catalunya 1:2.500',
			'name' => 'Ortofoto de Catalunya 1:2.500',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 5,
			'mapProviderId' => 5, 
			'languageId' => 1,
			'text' => 'Mapa topogràfic de Catalunya 1:5000',
			'name' => 'Mapa topogràfic de Catalunya 1:5000',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 6,
			'mapProviderId' => 6, 
			'languageId' => 1,
			'text' => 'Ortofoto 2009 Flandes color',
			'name' => 'Ortofoto 2009 Flandes color',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 7,
			'mapProviderId' => 7, 
			'languageId' => 1,
			'text' => 'Ortofoto 2012-2013 Valonia color 25m pixel',
			'name' => 'Ortofoto 2012-2013 Valonia color 25m pixel',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 8,
			'mapProviderId' => 1, 
			'languageId' => 2,
			'text' => 'OSM',
			'name' => 'OSM',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 9,
			'mapProviderId' => 2, 
			'languageId' => 2,
			'text' => 'Indice de vegetación (NDVI)',
			'name' => 'Indice de vegetación (NDVI)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 10,
			'mapProviderId' => 3, 
			'languageId' => 2,
			'text' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'name' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 11,
			'mapProviderId' => 4, 
			'languageId' => 2,
			'text' => 'Ortofoto de Cataluña 1: 2.500',
			'name' => 'Ortofoto de Cataluña 1: 2.500',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 12,
			'mapProviderId' => 5, 
			'languageId' => 2,
			'text' => 'Mapa topográfico de Cataluña 1: 5000',
			'name' => 'Mapa topográfico de Cataluña 1: 5000',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 13,
			'mapProviderId' => 6, 
			'languageId' => 2,
			'text' => 'Ortofoto 2009 Flandes color',
			'name' => 'Ortofoto 2009 Flandes color',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 14,
			'mapProviderId' => 7, 
			'languageId' => 2,
			'text' => 'Ortofoto 2012-2013 Valonia color 25m pixel',
			'name' => 'Ortofoto 2012-2013 Valonia color 25m pixel',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 15,
			'mapProviderId' => 1, 
			'languageId' => 3,
			'text' => 'OSM',
			'name' => 'OSM',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 16,
			'mapProviderId' => 2, 
			'languageId' => 3,
			'text' => 'Indice de végétation (NDVI)',
			'name' => 'Indice de végétation (NDVI)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 17,
			'mapProviderId' => 3, 
			'languageId' => 3,
			'text' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'name' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 18,
			'mapProviderId' => 4, 
			'languageId' => 3,
			'text' => 'Orthophoto de la Catalogne 1: 2 500',
			'name' => 'Orthophoto de la Catalogne 1: 2 500',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 19,
			'mapProviderId' => 5, 
			'languageId' => 3,
			'text' => 'Carte topographique de Catalogne 1: 5 000',
			'name' => 'Carte topographique de Catalogne 1: 5 000',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 20,
			'mapProviderId' => 6, 
			'languageId' => 3,
			'text' => 'Orthophoto Flandre 2009 couleur',
			'name' => 'Orthophoto Flandre 2009 couleur',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 21,
			'mapProviderId' => 7, 
			'languageId' => 3,
			'text' => 'Ortho Wallonie 2012-13 couleur 25m pixel',
			'name' => 'Ortho Wallonie 2012-13 couleur 25m pixel',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 22,
			'mapProviderId' => 1, 
			'languageId' => 4,
			'text' => 'OSM',
			'name' => 'OSM',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 23,
			'mapProviderId' => 2, 
			'languageId' => 4,
			'text' => 'Vegetation Index [NDVI]',
			'name' => 'Vegetation Index [NDVI]',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 24,
			'mapProviderId' => 3, 
			'languageId' => 4,
			'text' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'name' => 'Corine Land cover 2006 (CLC2006)LAEA',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 25,
			'mapProviderId' => 4, 
			'languageId' => 4,
			'text' => 'Orthofoto of Catalonia 1: 2 500',
			'name' => 'Orthofoto of Catalonia 1: 2 500',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 26,
			'mapProviderId' => 5, 
			'languageId' => 4,
			'text' => 'Topographic map of Catalonia 1: 5000',
			'name' => 'Topographic map of Catalonia 1: 5000',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 27,
			'mapProviderId' => 6, 
			'languageId' => 4,
			'text' => 'Ortho 2009 Flanders color',
			'name' => 'Ortho 2009 Flanders color',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 28,
			'mapProviderId' => 7, 
			'languageId' => 4,
			'text' => 'Ortho Wallonie 2012-13 color 25m pixel',
			'name' => 'Ortho Wallonie 2012-13 color 25m pixel',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 29,
			'mapProviderId' => 8, 
			'languageId' => 1,
			'text' => 'Topografia',
			'name' => 'Topografia',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 30,
			'mapProviderId' => 8, 
			'languageId' => 2,
			'text' => 'Topografía',
			'name' => 'Topografía',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 31,
			'mapProviderId' => 8, 
			'languageId' => 3,
			'text' => 'Topographie',
			'name' => 'Topographie',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 32,
			'mapProviderId' => 8, 
			'languageId' => 4,
			'text' => 'Topography',
			'name' => 'Topography',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 33,
			'mapProviderId' => 9, 
			'languageId' => 1,
			'text' => 'Índex de vegetació (NDVI)',
			'name' => 'Índex de vegetació (NDVI)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 34,
			'mapProviderId' => 9, 
			'languageId' => 2,
			'text' => 'Indice de vegetación (NDVI)',
			'name' => 'Indice de vegetación (NDVI)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 35,
			'mapProviderId' => 9, 
			'languageId' => 3,
			'text' => 'Indice de végétation (NDVI)',
			'name' => 'Indice de végétation (NDVI)',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('MapProviderTexts')->insert(array(
			'id'  => 36,
			'mapProviderId' => 8, 
			'languageId' => 4,
			'text' => 'Vegetation Index [NDVI]',
			'name' => 'Vegetation Index [NDVI]',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class UsersTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Users')->insert(array(
			'id'  => 1,
			'languageId' => null,
			'username' => 'ibesora',
			'password' => Hash::make('12345678'),
			'mail' => 'isaac@altersport.cat',
			'fullName' => 'Isaac Besora i Vilardaga',
			'isActive' => 1,
			'activationKey' => null,
			'photoURL' => 'users/user.png',
			'remember_token' => null,
			'amIExpert' => 1,
			'isExpert' => 1,
			'isAdmin' => 1,
			'lastConnection' => new DateTime,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class ValidatorsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Validators')->insert(array(
			'userId'  => 1,
			'organization' => 'Alter Sport',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class ConfigurationTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Configuration')->insert(array(
			'id'  => 1,
			'logoURL' => 'iasLogo.PNG',
			'logoAlt' => 'Logo IASTracker',
			'webName' => 'IASTracker',
			'centerLat' => '41.82045',
			'centerLon' => '1.54907',
			'defaultLanguageId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class ConfigurationTextsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('ConfigurationTexts')->insert(array(
			'id'  => 1,
			'privacyStatement' => 'Text de privacitat',
			'acknowledgment' => 'Text de credits',
			'description' => 'Text de sobre nosaltres',
			'languageId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class IASTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IAS')->insert(array(
			'id'  => 1,
			'latinName' => 'Agave americana',
			'taxonId' => 0,
			'defaultImageId' => 3,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 2,
			'latinName' => 'Ailanthus altissima',
			'taxonId' => 0,
			'defaultImageId' => 7,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 3,
			'latinName' => 'Carpobrotus spp.',
			'taxonId' => 0,
			'defaultImageId' => 15,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 4,
			'latinName' => 'Cortaderia selloana',
			'taxonId' => 0,
			'defaultImageId' => 60,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 5,
			'latinName' => 'Cotoneaster horizontalis',
			'taxonId' => 0,
			'defaultImageId' => 33,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 6,
			'latinName' => 'Estrilda astrild',
			'taxonId' => 6,
			'defaultImageId' => 10,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 7,
			'latinName' => 'Dreissena polymorpha',
			'taxonId' => 4,
			'defaultImageId' => 36,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 8,
			'latinName' => 'Pomacea insularum',
			'taxonId' => 4,
			'defaultImageId' => 38,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 9,
			'latinName' => 'Psittacula eupatria',
			'taxonId' => 6,
			'defaultImageId' => 40,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 10,
			'latinName' => 'Heracleum mantegazzianum',
			'taxonId' => 0,
			'defaultImageId' => 42,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 11,
			'latinName' => 'Senecio angulatus',
			'taxonId' => 0,
			'defaultImageId' => 29,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 12,
			'latinName' => 'Myiopsitta monachus',
			'taxonId' => 6,
			'defaultImageId' => 26,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 13,
			'latinName' => 'Psittacula krameri',
			'taxonId' => 6,
			'defaultImageId' => 32,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 14,
			'latinName' => 'Myocastor coypus',
			'taxonId' => 7,
			'defaultImageId' => 45,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 15,
			'latinName' => 'Opuntia spp.',
			'taxonId' => 0,
			'defaultImageId' => 28,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 16,
			'latinName' => 'Phytolacca americana',
			'taxonId' => 0,
			'defaultImageId' => 58,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 17,
			'latinName' => 'Neovison vison',
			'taxonId' => 7,
			'defaultImageId' => 50,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 18,
			'latinName' => 'Procyon lotor',
			'taxonId' => 7,
			'defaultImageId' => 54,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('IAS')->insert(array(
			'id'  => 19,
			'latinName' => 'Rhynchophorus ferrugineus',
			'taxonId' => 3,
			'defaultImageId' => 19,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class IASImagesTextTableSeeder extends Seeder {
 
	public function run()
	{
	

	}

}

class IASRelatedDBsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IASRelatedDBs')->insert(array(
			'id'  => 1,
			'repoId' => 1,
			'IASId' => 1,
			'URL' => 'http://relatedDB.url',
			'name' => 'related1',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASRelatedDBs')->insert(array(
			'id'  => 2,
			'repoId' => 1,
			'IASId' => 1,
			'URL' => 'http://relatedDB2.url',
			'name' => 'related2',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

	}

}

class IASTaxonsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IASTaxons')->insert(array(
			'id'  => 0,
			'languageId' => 1,
			'name' => 'Flora',
			'appInnerColor' => 'rgba(0,255,153,0.5)',
			'appOuterColor' => 'rgba(153,255,51,0.7)',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 1,
			'languageId' => 1,
			'name' => 'Animals',
			'appInnerColor' => '#ED1C24',
			'appOuterColor' => '#F15A24',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 2,
			'languageId' => 1,
			'name' => 'Invertebrats no artròpodes',
			'appInnerColor' => 'rgba(41,171,226,0.5)',
			'appOuterColor' => 'rgba(0,255,255,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 3,
			'languageId' => 1,
			'name' => 'Artròpodes no crustacis',
			'appInnerColor' => 'rgba(237,28,36,0.5)',
			'appOuterColor' => 'rgba(241,90,36,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 4,
			'languageId' => 1,
			'name' => 'Crustacis',
			'appInnerColor' => 'rgba(51,51,255,0.5)',
			'appOuterColor' => 'rgba(0,153,255,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 5,
			'languageId' => 1,
			'name' => 'Rèptils',
			'appInnerColor' => 'rgba(255,153,102,0.5)',
			'appOuterColor' => 'rgba(255,255,51,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 6,
			'languageId' => 1,
			'name' => 'Aus',
			'appInnerColor' => 'rgba(153,102,255,0.5)',
			'appOuterColor' => 'rgba(153,153,255,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 7,
			'languageId' => 1,
			'name' => 'Mamífers',
			'appInnerColor' => 'rgba(117,76,36,0.5)',
			'appOuterColor' => 'rgba(198,156,109,0.7)',
			'parentTaxonId' => 1,
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

	}

}

class RepositoriesTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Repositories')->insert(array(
			'id'  => 1,
			'name' => 'Repo1',
			'URL' => 'repo1URL',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}

}

class StatusTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Status')->insert(array(
			'id'  => 1,
			'icon' => 'fa fa-2x fa-check',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Status')->insert(array(
			'id'  => 2,
			'icon' => 'fa fa-2x fa-warning',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Status')->insert(array(
			'id'  => 3,
			'icon' => 'fa fa-2x fa-cross',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}

}

class StatusTextsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('StatusTexts')->insert(array(
			'id'  => 1,
			'statusId' => 1,
			'languageId' => 1,
			'text' => 'Validat',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('StatusTexts')->insert(array(
			'id'  => 2,
			'statusId' => 2,
			'languageId' => 1,
			'text' => 'Pendent',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('StatusTexts')->insert(array(
			'id'  => 3,
			'statusId' => 3,
			'languageId' => 1,
			'text' => 'No validat',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}

}