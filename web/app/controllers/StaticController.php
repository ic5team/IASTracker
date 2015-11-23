<?php

class StaticController extends BaseController {

	public function showIC5Info()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		$data = $this->getBasicData();
		$data->url = Config::get('app.url').'/html/AboutIC5Team_'.strtoupper($locale).'.htm';

		return View::make("public/iframe", array('data' => $data));

	}

	public function showIASTrackerInfo()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		$data = $this->getBasicData();
		$data->url = Config::get('app.url').'/html/AboutIASTracker_'.strtoupper($locale).'.htm';

		return View::make("public/iframe", array('data' => $data));

	}

	public function showPrivacyInfo()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		$data = $this->getBasicData();
		$data->url = Config::get('app.url').'/html/PRIVACYSTATEMENTIASTRACKER_'.strtoupper($locale).'.htm';

		return View::make("public/iframe", array('data' => $data));

	}

	public function showTermsAndConditions()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		$data = $this->getBasicData();
		$data->url = Config::get('app.url').'/html/USERAGREEMENTSIASTRACKER_'.strtoupper($locale).'.htm';

		return View::make("public/iframe", array('data' => $data));

	}

}
