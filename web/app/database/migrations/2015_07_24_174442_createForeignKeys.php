<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('MapProvider', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});
	
		Schema::table('WMSMapProvider', function(Blueprint $table)
		{
			$table->foreign('mapProviderId')->references('id')->on('MapProvider')
				->onDelete('cascade');
			$table->foreign('crsId')->references('id')->on('CRS')
				->onDelete('cascade');
		});

		Schema::table('MapProviderTexts', function(Blueprint $table)
		{
			$table->foreign('mapProviderId')->references('id')->on('MapProvider')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('CRS', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Languages', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('ConfigurationTexts', function(Blueprint $table)
		{

			$table->foreign('languageId')->references('id')->on('Users')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Grid10x10', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASImagesTexts', function(Blueprint $table)
		{
			$table->foreign('IASIId')->references('id')->on('IASImages')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASImages', function(Blueprint $table)
		{
			$table->foreign('IASId')->references('id')->on('IAS')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IAS', function(Blueprint $table)
		{
			$table->foreign('taxonId')->references('id')->on('IASTaxons')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Repositories', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASRelatedDBs', function(Blueprint $table)
		{
			$table->foreign('repoId')->references('id')->on('Repositories')
				->onDelete('cascade');
			$table->foreign('IASId')->references('id')->on('IAS');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASDescriptions', function(Blueprint $table)
		{
			$table->foreign('IASId')->references('id')->on('IAS')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASAreas', function(Blueprint $table)
		{
			$table->foreign('IASId')->references('id')->on('IAS')
				->onDelete('cascade');
			$table->foreign('areaId')->references('id')->on('Areas')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Areas', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASTaxons', function(Blueprint $table)
		{
			$table->foreign('parentTaxonId')->references('id')->on('IASTaxons');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('IASTaxonNames', function(Blueprint $table)
		{
			$table->foreign('taxonId')->references('id')->on('IASTaxons')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('observations', function(Blueprint $table)
		{
			$table->foreign('IASId')->references('id')->on('IAS');
			$table->foreign('userId')->references('id')->on('Users')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('validatorId')->references('userId')->on('Validators')
				->onDelete('set null');
			$table->foreign('statusId')->references('id')->on('Status')
				->onDelete('cascade');
		});

		Schema::table('ObservationAreas', function(Blueprint $table)
		{
			$table->foreign('observationId')->references('id')->on('observations')
				->onDelete('cascade');
			$table->foreign('areaId')->references('id')->on('Areas')
				->onDelete('cascade');
		});

		Schema::table('AreasValidators', function(Blueprint $table)
		{
			$table->foreign('areaId')->references('id')->on('Areas')
				->onDelete('cascade');
			$table->foreign('validatorId')->references('userId')->on('Validators')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('ObservationImages', function(Blueprint $table)
		{
			$table->foreign('observationId')->references('id')->on('observations')
				->onDelete('cascade');
		});

		Schema::table('Status', function(Blueprint $table)
		{
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('StatusTexts', function(Blueprint $table)
		{
			$table->foreign('statusId')->references('id')->on('Status')
				->onDelete('cascade');
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Validators', function(Blueprint $table)
		{
			$table->foreign('userId')->references('id')->on('Users')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('Users', function(Blueprint $table)
		{
			$table->foreign('languageId')->references('id')->on('Languages')
				->onDelete('set null');
		});

		Schema::table('PreferredIAS', function(Blueprint $table)
		{
			$table->foreign('IASId')->references('id')->on('IAS')
				->onDelete('cascade');
			$table->foreign('userId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('RegionAreas', function(Blueprint $table)
		{
			$table->foreign('areaId')->references('id')->on('Areas')
				->onDelete('cascade');
			$table->foreign('regionId')->references('id')->on('regions')
				->onDelete('cascade');
		});

		Schema::table('StateAreas', function(Blueprint $table)
		{
			$table->foreign('areaId')->references('id')->on('Areas')
				->onDelete('cascade');
			$table->foreign('stateId')->references('id')->on('States')
				->onDelete('cascade');
		});

		Schema::table('regions', function(Blueprint $table)
		{
			$table->foreign('stateId')->references('id')->on('States')
				->onDelete('cascade');
			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

		Schema::table('States', function(Blueprint $table)
		{

			$table->foreign('creatorId')->references('id')->on('Users')
				->onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('MapProvider', function(Blueprint $table)
		{
			$table->dropForeign('MapProvider_creatorId_foreign');
		});
	
		Schema::table('WMSMapProvider', function(Blueprint $table)
		{
			$table->dropForeign('WMSMapProvider_mapProviderId_foreign');
			$table->dropForeign('WMSMapProvider_CRSId_foreign');
		});

		Schema::table('MapProviderTexts', function(Blueprint $table)
		{
			$table->dropForeign('MapProviderTexts_mapProviderId_foreign');
			$table->dropForeign('MapProviderTexts_languageId_foreign');
			$table->dropForeign('MapProviderTexts_creatorId_foreign');
		});

		Schema::table('CRS', function(Blueprint $table)
		{
			$table->dropForeign('CRS_creatorId_foreign');
		});

		Schema::table('Languages', function(Blueprint $table)
		{
			$table->dropForeign('Languages_creatorId_foreign');
		});

		Schema::table('ConfigurationTexts', function(Blueprint $table)
		{
			$table->dropForeign('ConfigurationTexts_languageId_foreign');
			$table->dropForeign('ConfigurationTexts_creatorId_foreign');
		});

		Schema::table('Grid10x10', function(Blueprint $table)
		{
			$table->dropForeign('Grid10x10_creatorId_foreign');
		});

		Schema::table('IASImagesTexts', function(Blueprint $table)
		{
			$table->dropForeign('IASImagesTexts_IASIId_foreign');
			$table->dropForeign('IASImagesTexts_languageId_foreign');
			$table->dropForeign('IASImagesTexts_creatorId_foreign');
		});

		Schema::table('IASImages', function(Blueprint $table)
		{
			$table->dropForeign('IASImages_IASId_foreign');
			$table->dropForeign('IASImages_creatorId_foreign');
		});

		Schema::table('IAS', function(Blueprint $table)
		{
			$table->dropForeign('IAS_taxonId_foreign');
			$table->dropForeign('IAS_creatorId_foreign');
		});

		Schema::table('Repositories', function(Blueprint $table)
		{
			$table->dropForeign('Repositories_creatorId_foreign');
		});

		Schema::table('IASRelatedDBs', function(Blueprint $table)
		{
			$table->dropForeign('IASRelatedDBs_repoId_foreign');
			$table->dropForeign('IASRelatedDBs_IASId_foreign');
			$table->dropForeign('IASRelatedDBs_creatorId_foreign');
		});

		Schema::table('IASDescriptions', function(Blueprint $table)
		{
			$table->dropForeign('IASDescriptions_IASId_foreign');
			$table->dropForeign('IASDescriptions_languageId_foreign');
			$table->dropForeign('IASDescriptions_creatorId_foreign');
		});

		Schema::table('IASAreas', function(Blueprint $table)
		{
			$table->dropForeign('IASAreas_IASId_foreign');
			$table->dropForeign('IASAreas_areaId_foreign');
			$table->dropForeign('IASAreas_creatorId_foreign');
		});

		Schema::table('Areas', function(Blueprint $table)
		{
			$table->dropForeign('Areas_creatorId_foreign');
		});

		Schema::table('IASTaxons', function(Blueprint $table)
		{
			$table->dropForeign('IASTaxons_parentTaxonId_foreign');
			$table->dropForeign('IASTaxons_languageId_foreign');
			$table->dropForeign('IASTaxons_creatorId_foreign');
		});

		Schema::table('IASTaxonNames', function(Blueprint $table)
		{

			$table->dropForeign('IASTaxonNames_taxonId_foreign');
			$table->dropForeign('IASTaxonNames_languageId_foreign');
			$table->dropForeign('IASTaxonNames_creatorId_foreign');

		});

		Schema::table('observations', function(Blueprint $table)
		{
			$table->dropForeign('observations_IASRId_foreign');
			$table->dropForeign('observations_userId_foreign');
			$table->dropForeign('observations_languageId_foreign');
			$table->dropForeign('observations_validatorId_foreign');
			$table->dropForeign('observations_statusId_foreign');
		});

		Schema::table('ObservationAreas', function(Blueprint $table)
		{
			$table->dropForeign('ObservationAreas_observationId_foreign');
			$table->dropForeign('ObservationAreas_areaId_foreign');
		});

		Schema::table('IASAreasValidators', function(Blueprint $table)
		{
			$table->dropForeign('IASAreasValidators_IASRId_foreign');
			$table->dropForeign('IASAreasValidators_validatorId_foreign');
			$table->dropForeign('IASAreasValidators_creatorId_foreign');
		});

		Schema::table('ObservationImages', function(Blueprint $table)
		{
			$table->dropForeign('ObservationImages_observationId_foreign');
		});

		Schema::table('Status', function(Blueprint $table)
		{
			$table->dropForeign('Status_creatorId_foreign');
		});

		Schema::table('StatusTexts', function(Blueprint $table)
		{
			$table->dropForeign('StatusTexts_statusId_foreign');
			$table->dropForeign('StatusTexts_languageId_foreign');
			$table->dropForeign('StatusTexts_creatorId_foreign');
		});

		Schema::table('Validators', function(Blueprint $table)
		{
			$table->dropForeign('Validators_userId_foreign');
			$table->dropForeign('Validators_creatorId_foreign');
		});

		Schema::table('Users', function(Blueprint $table)
		{
			$table->dropForeign('Users_languageId_foreign');
		});

		Schema::table('PreferredIAS', function(Blueprint $table)
		{
			$table->dropForeign('PreferredIAS_IASId_foreign');
			$table->dropForeign('PreferredIAS_userId_foreign');
		});

		Schema::table('RegionAreas', function(Blueprint $table)
		{
			$table->dropForeign('RegionAreas_areaId_foreign');
			$table->dropForeign('RegionAreas_regionId_foreign');
		});

		Schema::table('StateAreas', function(Blueprint $table)
		{
			$table->dropForeign('StateAreas_areaId_foreign');
			$table->dropForeign('StateAreas_stateId_foreign');
		});

		Schema::table('regions', function(Blueprint $table)
		{
			$table->dropForeign('regions_stateId_foreign');
			$table->dropForeign('regions_creatorId_foreign');
		});

		Schema::table('States', function(Blueprint $table)
		{

			$table->dropForeign('States_creatorId_foreign');
		});

	}

}
