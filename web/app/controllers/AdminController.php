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
			$validator = IASValidator::userId(Auth::user()->id)->first();
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
				$current->user = User::find($current->userId);
				$data->obs[$i] = $current;

			}

			return View::make("admin/observations", array('data' => $data));

		}
		else
		{

			return Redirect::to('/');

		}

	}

}
