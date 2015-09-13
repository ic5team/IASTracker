<?php

class IndexController extends BaseController {

	public function showIndex()
	{

		$data = $this->getBasicData();
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;

		$languageId = Language::locale(App::getLocale())->first()->id;

		//Get the signup text
		$configTexts = ConfigurationTexts::language($languageId)->first();
		if(null == $configTexts)
		{

			$configTexts = ConfigurationTexts::language($defaultLanguageId)->first();

		}

		$data->signupClause = $configTexts->privacyStatement;

		//Get the CRS
		$data->crsDescriptors = CRS::all()->toJSON();

		//Get the map providers
		$mapProvidersArray = array();
		$mapProviders = MapProvider::idAscending()->get();
		for($i=0; $i<count($mapProviders); ++$i)
		{

			$mapDescriptor = new stdClass();
			$currentMapProvider = $mapProviders[$i];
			$mapTexts = MapProviderText::withMapAndLanguageId(
				$currentMapProvider->id, $languageId)->first();
			if(null != $mapTexts)
			{

				$mapTexts = MapProviderText::withMapAndLanguageId(
					$currentMapProvider->id, $defaultLanguageId)->first();

			}
			$currentMapProvider->name = $mapTexts->name;
			$currentMapProvider->desc = $mapTexts->text;

			$wmsProvider = WMSMapProvider::find($currentMapProvider->id);
			$currentMapProvider->isWMS = (NULL != $wmsProvider);

			if($currentMapProvider->isWMS)
			{

				$currentMapProvider->layers =  $wmsProvider->layers;
				$currentMapProvider->format =  $wmsProvider->format;
				$currentMapProvider->transparent =  $wmsProvider->transparent;
				$currentMapProvider->continuousWorld =  $wmsProvider->continuousWorld;
				$currentMapProvider->crsId =  $wmsProvider->crsId;

			}

			$mapProvidersArray[] = $currentMapProvider;

		}

		$data->mapProviders = json_encode($mapProvidersArray);
		$center = array();
		$center[] = $configuration->centerLat;
		$center[] = $configuration->centerLon;
		$data->center = json_encode($center);
		
		$data->externalSources = array();

		$taxonomies = array();
		$taxons = IASTaxon::withLanguageId($languageId)->get();
		if(null == $taxons)
			$taxons = IASTaxon::withLanguageId($defaultLanguageId)->get();
		for($i=0; $i<count($taxons); ++$i)
		{

			$taxonomies[$taxons[$i]->id] = $taxons[$i]->name;

		}

		$states = State::active(true)->ordered()->get();
		$shapes = Area::zOrder()->get();
		$shapeURLs = array();
		$shapeNames = array();
		for($i=0; $i<count($shapes); ++$i)
		{

			$shapeURLs[] = $shapes[$i]->shapeFileURL;
			$shapeNames[$shapes[$i]->id] = $shapes[$i]->name;

		}

		return View::make("public/index", array('data' => $data, 
			'taxonomies' => $taxonomies, 'states' => $states,
			'shapes' => json_encode($shapeURLs),
			'shapeNames' => json_encode($shapeNames)));

	}

}
