<?php

class BaseController extends Controller {

	protected $iLanguageId;

	function __construct() 
	{

		$iLanguageId = Input::has('languageId') ? Input::get('languageId') : 1;

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
			$data->isLogged = true;
			$data->username = $user->username;
			$data->userImage = $user->photoURL;
			$data->userLanguage = $user->languageId;
			$data->isAdmin = $user->isAdmin;
			$data->isExpert = $user->isExpert;
			$data->isValidator = (0 < $user->validators()->count());
			$data->observationNumber = 0;
			$data->verifiedObservations = 0;

			unset($user);

		}

		return $data;

	}

	protected function getPlatformData()
	{

		$data = new stdClass();
		$configData = Configuration::find(0);

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
			$data->languages[] = $obj;

		}


		return $data;

	}

}
