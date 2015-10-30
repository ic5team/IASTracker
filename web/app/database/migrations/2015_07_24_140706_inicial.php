<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inicial extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('MapProvider', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('url', 255);
			$table->text('attribution')->nullable();
			$table->string('subdomains', 255)->nullable();
			$table->integer('zIndex')->unsigned()->nullable();
			$table->decimal('SWBoundLat','9','6')->nullable();
			$table->decimal('SWBoundLon','9','6')->nullable();
			$table->decimal('NEBoundLat','9','6')->nullable();
			$table->decimal('NEBoundLon','9','6')->nullable();
			$table->integer('minZoom')->unsigned()->nullable();
			$table->integer('maxZoom')->unsigned()->nullable();
			$table->boolean('isOverlay');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});
	
		Schema::create('WMSMapProvider', function(Blueprint $table)
		{
			$table->integer('mapProviderId')->unsigned();
			$table->string('styles', 255);
			$table->string('layers', 255);
			$table->string('format', 255);
			$table->boolean('transparent');
			$table->boolean('continuousWorld');
			$table->integer('crsId')->unsigned()->nullable();
			$table->timestamps();
			$table->unique(array('mapProviderId'));
		});

		Schema::create('MapProviderTexts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mapProviderId')->unsigned()->nullable();
			$table->integer('languageId')->unsigned()->nullable();
			$table->text('text');
			$table->string('name', 255);
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('CRS', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 255);
			$table->string('proj4def', 255);
			$table->string('origin', 255)->nullable();
			$table->string('transformation', 255)->nullable();
			$table->string('scales', 255)->nullable();
			$table->string('resolutions', 255)->nullable();
			$table->string('bounds', 255)->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('Languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 255);
			$table->string('locale', 255);
			$table->string('flagURL', 255);
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('ConfigurationTexts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('privacyStatement');
			$table->text('acknowledgment');
			$table->text('description');
			$table->integer('languageId')->unsigned()->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('Configuration', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('logoURL', 255);
			$table->string('logoAlt', 255);
			$table->string('webName', 255);
			$table->decimal('centerLat','9','6');
			$table->decimal('centerLon','9','6');
			$table->integer('defaultLanguageId')->unsigned();
			$table->timestamps();
		});

		Schema::create('Grid10x10', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IASImagesTexts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASIId')->unsigned();
			$table->integer('languageId')->unsigned();
			$table->text('text');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IASImages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASId')->unsigned();
			$table->string('URL', 255);
			$table->text('attribution');
			$table->integer('order');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IAS', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('latinName',255);
			$table->integer('taxonId')->unsigned();
			$table->timestamps();
			$table->integer('defaultImageId')->unsigned()->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->softDeletes();
		});

		Schema::create('Repositories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',255);
			$table->string('URL',255);
			$table->text('description')->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IASRelatedDBs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('repoId')->unsigned();
			$table->integer('IASId')->unsigned();
			$table->string('URL', 255);
			$table->string('name', 255);
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IASDescriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASId')->unsigned();
			$table->integer('languageId')->unsigned();
			$table->string('name', 255);
			$table->text('shortDescription');
			$table->text('sizeLongDescription')->nullable();
			$table->text('infoLongDescription')->nullable();
			$table->text('habitatLongDescription')->nullable();
			$table->text('confuseLongDescription')->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('IASAreas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASId')->unsigned();
			$table->integer('areaId')->unsigned();
			$table->integer('orderId')->unsigned();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('Areas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('shapeFileURL', 255);
			$table->string('name', 255);
			$table->integer('zIndex');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('regions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 255);
			$table->integer('stateId')->unsigned()->nullable();
			$table->boolean('isActive');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('RegionAreas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('areaId')->unsigned();
			$table->integer('regionId')->unsigned();
			$table->timestamps();
		});

		Schema::create('States', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 255);
			$table->string('cntr_id', 20);
			$table->boolean('isActive');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('StateAreas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('areaId')->unsigned();
			$table->integer('stateId')->unsigned();
			$table->timestamps();
		});

		Schema::create('IASTaxons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('languageId')->unsigned();
			$table->string('name', 255);
			$table->string('appInnerColor', 25)->nullable();
			$table->string('appOuterColor', 25)->nullable();
			$table->integer('parentTaxonId')->unsigned()->nullable();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('observations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASId')->unsigned();
			$table->integer('userId')->unsigned()->nullable();
			$table->integer('languageId')->unsigned()->nullable();
			$table->integer('validatorId')->unsigned()->nullable();
			$table->text('validationText')->unsigned()->nullable();
			$table->integer('statusId')->unsigned();
			$table->boolean('isAutoValidated')->nullable();
			$table->text('notes')->nullable();
			$table->timestamp('validatorTS')->nullable();
			$table->decimal('latitude', 9, 6);
			$table->decimal('longitude', 9, 6);
			$table->decimal('elevation', 6, 2)->nullable();
			$table->decimal('accuracy', 6, 2)->nullable();
			$table->integer('howMany')->unsigned();
			$table->timestamps();

		});

		Schema::create('AreasValidators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('areaId')->unsigned();
			$table->integer('validatorId')->unsigned();
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('ObservationAreas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('observationId')->unsigned();
			$table->integer('areaId')->unsigned();
			$table->timestamps();
		});

		Schema::create('ObservationImages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('observationId')->unsigned();
			$table->string('URL', 255);
			$table->timestamps();
		});

		Schema::create('Status', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('icon', 255);
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('StatusTexts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('statusId')->unsigned();
			$table->integer('languageId')->unsigned();
			$table->text('text');
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
		});

		Schema::create('Validators', function(Blueprint $table)
		{
			$table->integer('userId')->unsigned();
			$table->string('organization', 255);
			$table->integer('creatorId')->unsigned()->nullable();
			$table->timestamps();
			$table->unique(array('userId'));
		});

		Schema::create('Users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('languageId')->unsigned()->nullable();
			$table->string('username', 255)->nullable();
			$table->string('password', 255)->nullable();
			$table->string('mail', 255);
			$table->string('fullName', 255)->nullable();
			$table->boolean('isActive');
			$table->string('activationKey', 255)->nullable();
			$table->string('resetKey', 255)->nullable();
			$table->string('appKey', 255)->nullable();
			$table->string('photoURL', 255)->nullable();
			$table->rememberToken();
			$table->boolean('amIExpert');
			$table->boolean('isExpert');
			$table->boolean('isAdmin');
			$table->timestamp('lastConnection');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('PreferredIAS', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('IASId')->unsigned();
			$table->integer('userId')->unsigned();
			$table->timestamps();
		});

		DB::statement('CREATE EXTENSION postgis');
		DB::statement("SELECT AddGeometryColumn ('regions','geom',4326,'MULTIPOLYGON',2)");
		DB::statement("SELECT AddGeometryColumn ('Areas','geom',4326,'MULTIPOLYGON',2)");
		DB::statement("SELECT AddGeometryColumn ('States','geom',4326,'MULTIPOLYGON',2)");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('MapProvider');
		Schema::drop('WMSMapProvider');
		Schema::drop('MapProviderTexts');
		Schema::drop('CRS');
		Schema::drop('Languages');
		Schema::drop('ConfigurationTexts');
		Schema::drop('Configuration');
		Schema::drop('Grid10x10');
		Schema::drop('IASImagesTexts');
		Schema::drop('IASImages');
		Schema::drop('IAS');
		Schema::drop('Repositories');
		Schema::drop('IASRelatedDBs');
		Schema::drop('IASDescriptions');
		Schema::drop('IASAreas');
		Schema::drop('Areas');
		Schema::drop('regions');
		Schema::drop('RegionAreas');
		Schema::drop('States');
		Schema::drop('StateAreas');
		Schema::drop('IASTaxons');
		Schema::drop('observations');
		Schema::drop('IASAreasValidators');
		Schema::drop('ObservationAreas');
		Schema::drop('ObservationImages');
		Schema::drop('Status');
		Schema::drop('StatusTexts');
		Schema::drop('Validators');
		Schema::drop('Users');
		Schema::drop('PreferredIAS');

	}

}
