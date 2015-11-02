<?php

class AdminController extends BaseController {

	public function showUsers()
	{

		if(Auth::check())
		{

			$data = $this->getBasicData();
			return View::make("admin/users", array('data' => $data));

		}
		else
		{

			App::abort(403);

		}

	}

	public function showObservations()
	{

		if(Auth::check())
		{

			$data = $this->getBasicData();
			$mapData = $this->getMapData();
			$data = (object) array_merge((array) $data, (array) $mapData);

			return View::make("admin/observations", array('data' => $data));

		}
		else
		{

			App::abort(403);

		}

	}

	public function showIAS()
	{

		if(Auth::check())
		{

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$data = $this->getBasicData();
			$data->defaultLanguageId = $defaultLanguageId;
			$data->areas = Area::all();
			$data->ias = IAS::all();
			$data->taxons = IASTaxon::withLanguageId($languageId)->get();
			if(null == $data->taxons)
				$data->taxons = IASTaxon::withLanguageId($defaultLanguageId)->get();
			for($i=0; $i<count($data->ias); ++$i)
			{

				$current = $data->ias[$i];
				$current->description = $current->getDescriptionData($languageId, $defaultLanguageId);
				$current->image = $current->getDefaultImageData($languageId, $defaultLanguageId);
				$data->ias[$i] = $current;

			}

			return View::make("admin/ias", array('data' => $data));

		}
		else
		{

			App::abort(403);

		}

	}

	public function showAreas()
	{

		if(Auth::check())
		{

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$data = $this->getBasicData();
			$data->areas = Area::all();
			$data->validators = User::all();	//TODO: Han de ser només els validadors

			return View::make("admin/areas", array('data' => $data));

		}
		else
		{

			App::abort(403);

		}

	}

}
