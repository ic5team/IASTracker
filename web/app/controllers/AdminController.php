<?php

class AdminController extends BaseController {

	public function showUsers()
	{

		if(Auth::check())
		{

			$data = $this->getBasicData();
			$data->users = User::all();

			for($i=0; $i<count($data->users); ++$i)
			{

				$current = $data->users[$i];
				$validator = IASValidator::find($current->id);
				$current->numObs = Observation::withUserId($current->id)->count();
				$current->numValidated = Observation::withUserId($current->id)->validated()->count();
				$current->isValidator = (null != $validator);
				$current->organization = '';
				if(null != $validator)
					$current->organization = $validator->organization;

				$data->users[$i] = $current;

			}

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

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$data = $this->getBasicData();
			$data->obs = array();
			$validator = IASValidator::userId(Auth::user()->id)->first();
			if(null != $validator)
			{

				$areas = AreaValidator::validatorId($validator->id)->get();
				$ids = array();
				for($i=0; $i<count($areas); ++$i)
				{

					$ids[] =$areas[$i]->areaId;

				}

				$mapData = $this->getMapData();
				$data = (object) array_merge((array) $data, (array) $mapData);

				$data->obs = Observation::status(2)->areas($ids)->get();

				for($i=0; $i<count($data->obs); ++$i)
				{

					$current = $data->obs[$i];
					$current->ias = new stdClass();
					$current->ias = IAS::find($current->IASId);
					$current->ias->description = $current->ias->getDescriptionData($languageId, $defaultLanguageId);
					$current->ias->image = $current->ias->getDefaultImageData($languageId, $defaultLanguageId);
					$current->images = ObservationImage::withObservationId($current->id)->get();
					$user = User::find($current->userId);
					$current->user = $user;
					$current->user->observations = $user->getObservationsNumber();
					$current->user->validated = $user->getValidatedNumber();
					$data->obs[$i] = $current;

				}

			}

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
