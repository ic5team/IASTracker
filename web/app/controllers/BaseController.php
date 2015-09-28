<?php

class BaseController extends Controller {


	function __construct() 
	{

		if(Input::has('lang'))
		{

			App::setLocale(Input::get('lang'));

		}

	}

	public function getBasicData()
	{

		$userData = $this->getLoggedUserData();
		$platformData = $this->getPlatformData();

		return (object) array_merge((array) $userData, (array) $platformData);

	}

	protected function getLoggedUserData()
	{

		$data = new stdClass();
		$data->isLogged = false;
		$data->isAdmin = false;

		if(Auth::check())
		{

			$user = Auth::user();
			if($user->isActive)
			{

				$data->isLogged = true;
				$data->username = $user->username;
				$data->userImage = $user->photoURL;
				$data->userLanguage = $user->languageId;
				$data->isAdmin = $user->isAdmin;
				$data->amIExpert = $user->amIExpert;
				$data->isExpert = $user->isExpert;
				$data->fullName = $user->fullName;
				$data->observationNumber = 0;
				$data->verifiedObservations = 0;
				$data->verifiedObservationsPC = 0;
				$data->usrId = $user->id;
				$data->isComplete = (null != $user->fullName);

			}
			else
				Auth::logout();

			unset($user);

		}

		return $data;

	}

	protected function getPlatformData()
	{

		$data = new stdClass();
		$configData = Configuration::find(1);

		$data->logo = $configData->logoURL;
		$data->logoAlt = $configData->logoAlt;
		$data->webName = $configData->webName;
		$data->description = $configData->description;

		unset($configData);
		
		$data->languages = array();
		$languages = Language::idAscending()->get();
		$numLanguages = count($languages);
		for($i=0; $i<$numLanguages; ++$i)
		{

			$obj = new stdClass();
			$obj->locale = $languages[$i]->locale;
			$obj->img = $languages[$i]->flagURL;
			$obj->name = $languages[$i]->name;
			$obj->id = $languages[$i]->id;
			$data->languages[] = $obj;

		}

		return $data;

	}

	protected function getMapData()
	{

		$data = new stdClasS();
		$lastMap = MapProvider::lastUpdated()->first();
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;
		$languageId = Language::locale(App::getLocale())->first()->id;

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
			if(null == $mapTexts)
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

				$currentMapProvider->styles = $wmsProvider->styles;
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

		$data->lastUpdated = $lastMap->updated_at;

		return $data;

	}

}
