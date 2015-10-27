<?php

class StaticController extends Controller {

	public function showIC5Info()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		return Redirect::to(Config::get('app.url').'/html/AboutIC5Team_'.strtoupper($locale).'.htm');

	}

	public function showIASTrackerInfo()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		return Redirect::to(Config::get('app.url').'/html/AboutIASTracker_'.strtoupper($locale).'.htm');

	}

	public function showPrivacyInfo()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		return Redirect::to(Config::get('app.url').'/html/PRIVACYSTATEMENTIASTRACKER_'.strtoupper($locale).'.htm');

	}

	public function showTermsAndConditions()
	{

		$locale = 'en';
		if(Input::has('lang'))
			$locale = Input::get('lang');

		return Redirect::to(Config::get('app.url').'/html/USERAGREEMENTSIASTRACKER_'.strtoupper($locale).'.htm');

	}

}
