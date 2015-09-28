<?php

class IndexController extends BaseController {

	public function showIndex()
	{

		$error = '';
		if(Input::has('email') && Input::has('password'))
		{

			if(!Auth::attempt(array('mail' => Input::get('email'), 
				'password' => Input::get('password')), Input::has('forever')))
			{

				$error = Lang::get('ui.wrongUserCredentials');

			}
			else
			{

			}

		}
		else if(Input::has('email') || Input::has('password'))
		{

			$error = Lang::get('ui.missingParameters');

		}

		if(Auth::user())
		{

			$user = Auth::user();
			$lang = $user->languageId;
			$user->resetKey = null;
			$user->lastConnection = new DateTime();
			$user->save();
			App::setLocale(Language::find($lang)->locale);

		}

		$data = $this->getBasicData();
		if('' != $error)
			$data->error = $error;

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

		$mapData = $this->getMapData();
		$data = (object) array_merge((array) $data, (array) $mapData);
		
		$data->externalSources = array();

		$taxonomies = array();
		$taxonChilds = array();
		$taxons = IASTaxon::withLanguageId($languageId)->get();
		if(null == $taxons)
			$taxons = IASTaxon::withLanguageId($defaultLanguageId)->get();
		for($i=0; $i<count($taxons); ++$i)
		{

			$taxonomies[$taxons[$i]->id] = $taxons[$i]->name;
			$taxon = IASTaxon::find($taxons[$i]->id);
			$taxonChilds[$taxons[$i]->id] = $taxon->getChildTaxonsIds();

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
			'shapeNames' => json_encode($shapeNames),
			'taxonChilds' => $taxonChilds));

	}

	public function logout()
	{

		Auth::logout();
		return Redirect::intended('/');

	}

	public function showCookies()
	{

		$data = $this->getBasicData();
		return View::make('public/cookies', array('data' => $data));

	}

	public function getAppMapData()
	{

		return Response::json($this->getMapData());

	}

	public function getLastMapUpdate()
	{

		$lastMap = MapProvider::lastUpdated()->first();

		$obj = new stdClass();
		$obj->lastUpdated = $lastMap->updated_at;
		return Response::json($obj);

	}

}
