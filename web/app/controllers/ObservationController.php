<?php

class ObservationController extends RequestController {

	/**
	* Returns a list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @uses $_GET['taxonomyId'] The filtered taxonomy id
	* @uses $_GET['fromDate'] The starting date of the search interval  
	* @uses $_GET['toDate'] The ending date of the search interval
	* @uses $_GET['stateId'] The filtered state id
	* @uses $_GET['regionId'] The filtered region id
	* @uses $_GET['areaId'] The filtered area id
	* @return A JSON Response
	*/
	protected function elements($first, $num)
	{

		$elements = null;

		if(Input::has('draw'))
		{

			$elements = $this->getDataTablesData($first, $num);

		}
		else
		{

			$elements = $this->getFilteredData($first, $num);

		}

		return Response::json($elements);

	}

	protected function getDataTablesData($first, $num)
	{

		if(Auth::check())
		{

			try {

				//Datatable request
				$data = new stdClass();
				$draw = Input::get('draw');
				$search = Input::get('search');
				$orders = Input::get('order');
				$columns = Input::get('columns');
				$viewValidated = 'true' == Input::get('viewValidated');
				$viewDiscarded = 'true' == Input::get('viewDiscarded');
				$viewDeleted = 'true' == Input::get('viewDeleted');
				$viewPending = 'true' == Input::get('viewPending');

				$obs = null;
				$numTotals = 0;

				if(Auth::user()->isAdmin)
				{

					//Show all the observations
					$query = Observation::withDataTableRequest($search, $orders, $columns)
						->statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending);
					$numTotals = Observation::statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending)
						->count();

				}
				else
				{

					$validator = IASValidator::userId(Auth::user()->id)->first();
					if(null != $validator)
					{

						//Show the observations from areas the user can validate
						$areas = AreaValidator::validatorId($validator->id)->get();
						$ids = array();
						for($i=0; $i<count($areas); ++$i)
						{

							$ids[] =$areas[$i]->areaId;

						}

						$query = Observation::withDataTableRequest($search, $orders, $columns)
							->statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending)
							->areas($ids);
						$numTotals = Observation::statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending)
							->areas($ids)->count();

					}
					else
					{

						App::abort(403);

					}

				}

				$obs = $query->skip($first)->take($num)->get();
				$data->draw = intval($draw);
				$data->recordsTotal = $numTotals;
				$languageId = Language::locale(App::getLocale())->first()->id;
				$configuration = Configuration::find(1);
				$defaultLanguageId = $configuration->defaultLanguageId;
				for($i=0; $i<count($obs); ++$i)
				{

					$current = $obs[$i];
					$current->DT_RowId = $current->id;
					$current->observations = new stdClass();
					$current->observations->created_at = $current->created_at->format('Y-m-d H:i:s');
					$current->ias = new stdClass();
					$current->ias = IAS::find($current->IASId);
					$current->ias->description = $current->ias->getDescriptionData($languageId, $defaultLanguageId);
					$current->ias->image = $current->ias->getDefaultImageData($languageId, $defaultLanguageId);
					$current->images = ObservationImage::withObservationId($current->id)->get();

					if(null != $current->deleted_at)
					{

						$current->statusIcon = '';
						$current->statusId = 4;

					}
					else
					{

						$current->statusIcon = $current->icon;

					}
					$user = User::find($current->userId);
					if(null != $user)
					{

						$current->user = $user->name;

					}
					else
					{

						$current->user = Lang::get('ui.userUnknown');
						
					}

					$current->innerHtml = View::make('admin/innerObservation', array('current' => $current))->render();
					$obs[$i] = $current;

				}

				$data->recordsFiltered = count($obs);
				$data->data = $obs;

			}
			catch(Exception $e)
			{

				$data->error = $e->getMessage();

			}

		}
		else
		{

			App::abort(403);

		}

		return $data;

	}

	protected function getFilteredData($first, $num)
	{

		$taxonomyId = Input::has('taxonomyId') ? Input::get('taxonomyId') : -1;
		$fromDate = Input::has('fromDate') ? Input::get('fromDate') : '1970-01-01';
		$toDate = Input::has('toDate') ? Input::get('toDate') : (new DateTime())->format('Y-m-d');
		$stateId = Input::has('stateId') ? Input::get('stateId') : -1;
		$regionId = Input::has('regionId') ? Input::get('regionId') : -1;
		$areaId = Input::has('areaId') ? Input::get('areaId') : -1;

		$taxonsId = array();
		if(-1 != $taxonomyId)
		{

			$taxonsId[] = $taxonomyId;
			$taxon = IASTaxon::find($taxonomyId);
			$childs = $taxon->getChildTaxons();
			for($i=0; $i<count($childs); ++$i)
			{

				$taxonsId[] = $childs[$i]["id"];

			}

		}
		
		$areaIds = array();
		if(-1 != $areaId)
		{

			$area = Area::find($areaId);
			$areaIds[] = $area->id;

		}
		else if(-1 != $regionId)
		{

			$areas = array();
			$areas = RegionArea::withRegionId($regionId)->get();

			for($i=0; $i<count($areas); ++$i)
				$areaIds[] = $areas[$i]->areaId;

		}
		else if(-1 != $stateId)
		{

			$areas = array();
			$areas = StateArea::withStateId($stateId)->get();

			for($i=0; $i<count($areas); ++$i)
				$areaIds[] = $areas[$i]->areaId;

		}
		else
		{

			$areas = Area::all();

			for($i=0; $i<count($areas); ++$i)
				$areaIds[] = $areas[$i]->id;

		}

		$elements = $this->getFilteredElements($first, $num, $taxonsId, $fromDate, 
			$toDate, $areaIds);

		return $elements->toJson();

	}

	/**
	* Returns a view with list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return Response
	*/
	protected function showListView($first, $num)
	{


	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{


	}

	/**
	* Stores the data
	* @throws QueryException if the resource can't be stored
	*/
	protected function newResource()
	{

		$dto = new stdClass();

		if(Input::has('IASId') && Input::has('number') && 
			Input::has('coords'))
		{

			$observationImages = array();
			if(Input::has('observationImages'))
				$observationImages = Input::get('observationImages');

			$description = null;
			if(Input::has('description'))
				$description = Input::get('description');

			$altitude = null;
			if(Input::has('altitude'))
				$altitude = Input::get('altitude');

			$accuracy = null;
			if(Input::has('accuracy'))
				$accuracy = Input::get('accuracy');

			$coords = Input::get('coords');
			$latitude = $coords['latitude'];
			$longitude = $coords['longitude'];
			$images = Input::get('observationImages');
			$userId = null;
			$languageId = null;
			$user = null;

			if(Input::has('token'))
			{

				$user = User::userToken(Input::get('token'))->first();;
				if(null != $user)
				{
				
					$userId = $user->id;
					$languageId = $user->languageId;

				}

			}

			$element = new Observation(array(
				'IASId' => Input::get('IASId'),
				'userId' => $userId,
				'languageId' => $languageId,
				'statusId' => 2,
				'notes' => $description,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'elevation' => $altitude,
				'accuracy' => $accuracy,
				'howMany' => Input::get('number')
			));

			if(null != $user && $user->isExpert)
			{

				$element->isAutoValidated = true;
				$element->statusId = 1;

			}

			$element->touch();
			$element->save();

			for($i=0; $i<count($images); ++$i)
			{

				if("" != $images[$i])
				{

					$image = new ObservationImage(array(
						'observationId' => $element->id,
						'URL' => str_replace('"', '', $images[$i])
					));
					$image->touch();
					$image->save();

				}

			}

			$areas = Area::getAreaContains($latitude, $longitude);
			for($i=0; $i<count($areas); ++$i)
			{

				$obsArea = new ObservationArea(array(
					'observationId' => $element->id,
					'areaId' => $areas[$i]->id,
				));
				$obsArea->touch();
				$obsArea->save();

			}

		}
		else
		{

			$dto->error = Lang::get('ui.missingParameters');

		}

		return Response::json($dto);

	}

	/**
	* Returns one of the elements
	* @param id The resource id
	* @return A JSON Response
	*/
	protected function resource($id)
	{

		$element = $this->getElement($id);

		if(NULL != $element)
		{

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$data = $element;
			$ias = $element->IAS;
			$data->latinName = $ias->latinName;
			$data->description = $ias->getDescriptionData($languageId, $defaultLanguageId);
			$data->taxons = $ias->getTaxons();
			$data->image = $ias->getDefaultImageData($languageId, $defaultLanguageId);
			$data->user = $element->user;
			$data->status = $element->getStatus($languageId, $defaultLanguageId);
			$data->images = $element->observationImages;

			$output = new stdClass();
			$output->html = View::make('public/Obs/element', array('data' => $data))->render();

			return json_encode($output);

		}

	}

	/**
	* Returns a view of one of the elements
	* @param id The resource id
	* @return Response
	*/
	protected function showResourceView($id)
	{

	}

	/**
	* Updates the data
	* @param id The resource id
	*/
	protected function updateResource($id)
	{

		$element = $this->getElement($id);

		if(Input::has('status') && Auth::check())
		{

			$user = Auth::user();
			$element->validatorId = $user->id;
			$element->validatorTS = new DateTime();
			$element->statusId = Input::get('status');
			$element->validationText = Input::get('text');
			$element->touch();
			$element->save();

			return json_encode($id);

		}

	}

	/**
	* Deletes the data
	* @param id The resource id
	*/
	protected function deleteResource($id)
	{

		$obs = Observation::find($id);
		$obs->delete();

	}

	/**
	* Gets all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return An array of models
	*/
	protected function getElements($first, $num)
	{

		return Observation::orderBy('id')
			->skip($first)->take($num)->get();

	}

	/**
	* Gets all the filtered elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @param taxonsId An array with the taxonomies ids
	* @param fromDate The starting date of the search interval  
	* @param toDate The ending date of the search interval
	* @param areasId An array with the areas identifiers
	* @return An array of models
	*/
	protected function getFilteredElements($first, $num, $taxonsId, $fromDate, $toDate,
			$areasId)
	{

		$values = Observation::filtered($taxonsId, $fromDate, $toDate,
			$areasId)->orderBy('observations.id')
			->skip($first)->take($num)->get();

		return $values;

	}

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	protected function getElement($id)
	{

		return Observation::find($id);

	}
	
}
