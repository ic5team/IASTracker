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
		$platformData = $this->getPlatformaData();

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

		return $data;

	}

}
