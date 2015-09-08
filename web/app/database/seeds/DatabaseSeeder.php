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
		$this->call('IASDescriptionsTableSeeder');
		$this->call('IASImagesTableSeeder');
		$this->call('IASImagesTextTableSeeder');
		$this->call('RepositoriesTableSeeder');
		$this->call('IASRelatedDBsTableSeeder');
		$this->call('StatusTableSeeder');
		$this->call('StatusTextsTableSeeder');
		$this->call('ObservationsTableSeeder');
		$this->call('ObservationImagesTableSeeder');

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

class IASTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IAS')->insert(array(
			'id'  => 1,
			'latinName' => 'Agave Americana',
			'taxonId' => 3,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime,
			'defaultImageId' => 11
		));

		DB::table('IAS')->insert(array(
			'id'  => 2,
			'latinName' => 'Rhynchophorus ferrugineus',
			'taxonId' => 5,
			'creatorId' => 1,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime,
			'defaultImageId' => 17
		));

	}
}

class IASDescriptionsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IASDescriptions')->insert(array(
			'id'  => 1,
			'IASId' => 1,
			'languageId' => 1,
			'name' => 'Atzavara',
			'shortDescription' => 'descripció curta',   
			'longDescription' => 'descripció llarga',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASDescriptions')->insert(array(
			'id'  => 2,
			'IASId' => 1,
			'languageId' => 2,
			'name' => 'Agave d\'Amérique',
			'shortDescription' => 'descripció curta FR',   
			'longDescription' => 'descripció llarga FR',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASDescriptions')->insert(array(
			'id'  => 3,
			'IASId' => 1,
			'languageId' => 3,
			'name' => 'Agave',
			'shortDescription' => 'descripció curta EN',   
			'longDescription' => 'descripció llarga EN',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASDescriptions')->insert(array(
			'id'  => 6,
			'IASId' => 2,
			'languageId' => 1,
			'name' => 'Asiatic palm weevil',
			'shortDescription' => "Adults are large, usually over 2 cm (up to 4 cm) long and 1.5 cm wide, with a long curved rostrum (snout) characteristic of weevils. Colour is reddish-brown with a variable number of dark markings on the dorsal surface of the thorax. It’s a bane to palm trees. The head and rostrum comprise about one-third of the total length. ",   
			'longDescription' => '<i class="fa fa-2x fa-arrows-h"></i>Adult weevils measure over 2 cm long and 1.5 cm wide. The average size of an egg is 2.62 mm long and 1,12 mm wide. The larvae can grow up to 3.5 cm long. The pupal case can range in length from 5-9.5 cm and in width from 2.5-4 cm.
<br /><i class="fa fa-2x fa-info"></i>Larvae are legless and creamy white in colour with a hard brown head capsule. Eggs are whitish-yellow, smooth, shiny, cylindrical with rounded ends, slightly narrower at the anterior end. Pupae appear as an elongated oval cocoon made up of fibrous strands. The entire life cycle take about 4 months and may be spent entirely on the host plant. The weevil lays an average of 204 eggs. Signs of attack on the plant itself are distinctive but hard to detect. These include: egg laying notches, cocoons inserted into the base of the palms, an eccentric growing crown, holes at the base of cut palms, symptoms resembling those caused by lack of water such as wilting, desiccation and necrosis of the foliage, and tunnelling within the stems and trunk. Interior of host tree is often destroyed without any detected exterior signs. 
<br /><i class="fa fa-2x fa-map-marker"></i>Asiatic palm weevil is originated from Asia and it has spread across North Africa, Central America, Europe and Oceania. It can be found in desert, natural forests, planted forests and urban areas. It lives in palm trees.',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

	}
}

class IASImagesTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IASImages')->insert(array(
			'id'  => 2,
			'IASId' => 1,
			'URL' => '250px-Agave_americana74.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 4,
			'IASId' => 1,
			'URL' => 'agave americana mediopicta2.jpg',
			'attribution' => 'Google 2',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 6,
			'IASId' => 1,
			'URL' => 'Agave_americana.jpg',
			'attribution' => 'Google 3',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 7,
			'IASId' => 1,
			'URL' => 'agave_americana_20121123_1886627910.jpg',
			'attribution' => 'Google 4',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 9,
			'IASId' => 1,
			'URL' => 'Agave_americana_clump.jpg',
			'attribution' => 'Google 5',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 10,
			'IASId' => 1,
			'URL' => 'Agave_americana_R01.jpg',
			'attribution' => 'Google 6',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 11,
			'IASId' => 1,
			'URL' => 'Agave_americana4.jpg',
			'attribution' => 'Google 7',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 12,
			'IASId' => 1,
			'URL' => 'agave_americana8.jpg',
			'attribution' => 'Google 8',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 13,
			'IASId' => 1,
			'URL' => 'agave-americana.jpg',
			'attribution' => 'Google 9',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 14,
			'IASId' => 1,
			'URL' => 'Agave-americana_century_plant_drought_tolerant_designer_austin_xeriscaping.jpg',
			'attribution' => 'Google 10',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 15,
			'IASId' => 1,
			'URL' => 'baixa.jpg',
			'attribution' => 'Google 11',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 16,
			'IASId' => 1,
			'URL' => 'tumblr_n59h2eWZv91tbnvhqo1_1280.jpg',
			'attribution' => 'Google 12',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 17,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_01.JPG',
			'attribution' => 'Wikimedia Commons - Küchenkraut',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 20,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_02.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 21,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_03.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 22,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_04.JPG',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 23,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_05.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 24,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_06.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASImages')->insert(array(
			'id'  => 25,
			'IASId' => 2,
			'URL' => 'Morrut_Palmeres_07.jpg',
			'attribution' => 'Google',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

	}
}

class IASImagesTextTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('IASImagesTexts')->insert(array(
			'id'  => 1,
			'IASIId' => 17,
			'languageId' => 1,
			'text' => 'Pupal cases opened and show hatched adult weevils',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

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
			'id'  => 3,
			'languageId' => 1,
			'name' => 'Flora',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 4,
			'languageId' => 1,
			'name' => 'Fauna',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		DB::table('IASTaxons')->insert(array(
			'id'  => 5,
			'languageId' => 1,
			'name' => 'Bitxo',
			'creatorId' => 1,
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

	}

}

class ObservationImagesTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('ObservationImages')->insert(array(
			'id'  => 3,
			'observationId' => 4,
			'URL' => 'iasLogo.PNG',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('ObservationImages')->insert(array(
			'id'  => 4,
			'observationId' => 4,
			'URL' => 'ibesora.PNG',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('ObservationImages')->insert(array(
			'id'  => 5,
			'observationId' => 4,
			'URL' => 'mosquit.jpg',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('ObservationImages')->insert(array(
			'id'  => 6,
			'observationId' => 4,
			'URL' => 'pomacea.jpg',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('ObservationImages')->insert(array(
			'id'  => 7,
			'observationId' => 7,
			'URL' => 'Morrut_Palmeres_06.jpg',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('ObservationImages')->insert(array(
			'id'  => 8,
			'observationId' => 7,
			'URL' => 'Morrut_Palmeres_02.jpg',
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

	}
}

class ObservationsTableSeeder extends Seeder {
 
	public function run()
	{
	
		DB::table('Observations')->insert(array(
			'id'  => 4,
			'IASId' => 1,
			'userId' => 1,
			'languageId' => 1,
			'statusId' => 2,
			'notes' => 'Observation text',
			'validatorTS' => new DateTime,
			'latitude' => '42.118900',
			'longitude' => '1.886900',
			'elevation' => '1998.00',
			'accuracy' => 50,
			'created_at' => new DateTime,   
			'updated_at' => new DateTime
		));

		DB::table('Observations')->insert(array(
			'id'  => 7,
			'IASId' => 2,
			'userId' => 1,
			'languageId' => 1,
			'validatorId' => 1,
			'statusId' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut accumsan diam ut quam blandit eleifend. Maecenas dignissim porttitor semper. In aliquet ligula mi, vel tincidunt urna imperdiet sed. Proin fermentum lacus a enim cursus venenatis. Donec ut luctus neque. Sed in ante lacus. Vivamus tristique viverra tortor in tristique. Nullam vulputate odio libero. Aliquam sit amet ex quis diam consequat ultricies. Aliquam semper ultricies ligula, et vehicula nisi varius et. Ut ac vehicula diam. Morbi ut enim at lacus malesuada gravida non id odio. Mauris sit amet euismod massa. In dictum facilisis laoreet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras vel dictum ante.',
			'validatorTS' => new DateTime,
			'latitude' => '42.159000',
			'longitude' => '1.906900',
			'elevation' => '1000.00',
			'accuracy' => 30,
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