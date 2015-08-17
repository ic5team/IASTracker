<?php

class IndexController extends BaseController {

	public function showIndex()
	{

		$data = $this->getBasicData();

		$languageId = Language::locale(App::getLocale())->first()->id;

		//Get the signup text
		$data->signupClause = ConfigurationTexts::language($languageId)->first()->privacyStatement;

		//Get the CRS
		$data->crsDescriptors = CRS::all()->toJSON();

		//Get the map providers
		$mapProvidersArray = array();
		$mapProviders = MapProvider::all();
		for($i=0; $i<count($mapProviders); ++$i)
		{

			$mapDescriptor = new stdClass();
			$currentMapProvider = $mapProviders[$i];
			$wmsProvider = WMSMapProvider::find($currentMapProvider->id);
			$currentMapProvider->isWMS = (NULL != $wmsProvider);

			if($currentMapProvider->isWMS)
			{

				$currentMapProvider =  (object) array_merge((array) $currentMapProvider, (array) $wmsProvider);

			}

			$mapProvidersArray[] = $currentMapProvider;

		}

		$data->mapProviders = json_encode($mapProvidersArray);

		return View::make("public/index", array('data' => $data));

	}

}
