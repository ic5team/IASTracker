<?php

class AdminController extends BaseController {

	public function showIndex()
	{

		if(Auth::check())
		{

			return Redirect::to('admin/observations');

		}
		else
		{

			App::abort(403);

		}

	}

	public function showUsers()
	{

		if(Auth::check() && Auth::user()->isAdmin)
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

			$data->canViewOutOfBounds = false;
			$ias = IASValidator::withValidatorId(Auth::user()->id)->get();
			for($i=0; $i<count($ias); ++$i)
			{

				$data->canViewOutOfBounds = $data->canViewOutOfBounds || $ias[$i]->outOfBounds;

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

		if(Auth::check() && Auth::user()->isAdmin)
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

			$ValidatorUsers = ValidatorUser::all();
			for($j=0; $j<count($ValidatorUsers); ++$j)
			{

				$user = User::find($ValidatorUsers[$j]->userId);
				$ValidatorUsers[$j]->fullName = $user->fullName;

			}

			return View::make("admin/ias", array('data' => $data, 'validators' => $ValidatorUsers));

		}
		else
		{

			App::abort(403);

		}

	}

	public function showAreas()
	{

		if(Auth::check() && Auth::user()->isAdmin)
		{

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$data = $this->getBasicData();
			$validators = ValidatorUser::all();
			for($i=0; $i<count($validators); ++$i)
			{

				$user = User::find($validators[$i]->userId);
				$validators[$i]->fullName = $user->fullName;

			}

			return View::make("admin/areas", array('data' => $data, 'validators' => $validators));

		}
		else
		{

			App::abort(403);

		}

	}

}
