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

	}

}

class MapProviderTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('MapProvider')->insert(array(
			'id'  => 1,
			'url' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png',
			'attribution' => '&copy; <a href=\"http://osm.org/copyright\" title=\"OpenStreetMap\" target=\"_blank\">OpenStreetMap</a> contributors | Tiles Courtesy of <a href=\"http://www.mapquest.com/\" title=\"MapQuest\" target=\"_blank\">MapQuest</a> <img src=\"http://developer.mapquest.com/content/osm/mq_logo.png\" width=\"16\" height=\"16\">',
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
			'url' => 'http://mapcache.icc.cat/map/bases/service?',
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

	}
}

class WMSMapProviderTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('WMSMapProvider')->insert(array(
			'mapProviderId'  => 2,
			'layers' => 'orto',
			'format' => 'image/png',
			'transparent' => true,
			'continuousWorld' => true,
			'crsId' => 1,
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
			'name' => 'FR',
			'locale' => 'fr',
			'flagURL' => 'france.gif',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Languages')->insert(array(
			'id'  => 3,
			'name' => 'EN',
			'locale' => 'en',
			'flagURL' => 'eng.jpg',
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

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
			'text' => 'Mapa topogràfic de l\'ICC',
			'name' => 'Topogràfic ICC',
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
			'photoURL' => 'usuaris/ibesora.png',
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