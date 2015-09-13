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

		$taxonomyId = Input::has('taxonomyId') ? Input::get('taxonomyId') : -1;
		$fromDate = Input::has('fromDate') ? Input::get('fromDate') : '1970-01-01';
		$toDate = Input::has('toDate') ? Input::get('toDate') : (new DateTime())->format('Y-m-d');
		$stateId = Input::has('stateId') ? Input::get('stateId') : -1;
		$regionId = Input::has('regionId') ? Input::get('regionId') : -1;
		$areaId = Input::has('areaId') ? Input::get('areaId') : -1;

		
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

		$elements = $this->getFilteredElements($first, $num, $taxonomyId, $fromDate, 
			$toDate, $areaIds);

		return Response::json($elements->toJson());

	}

	/**
	* Returns a view with list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return Response
	*/
	protected function showListView($first, $num)
	{

		$elements = $this->getElements($first, $num);
		return Response::view('adm/Obs/list', array('data' => $elements));

	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{

		return Response::view('adm/Obs/create');

	}

	/**
	* Stores the data
	* @throws QueryException if the resource can't be stored
	*/
	protected function newResource()
	{

		$element = new Observation(array());

		$element->touch();
		$element->save();

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

		$element = $this->getElements($id);
		return Response::view('adm/Obs/element', array('data' => $element));

	}

	/**
	* Updates the data
	* @param id The resource id
	*/
	protected function updateResource($id)
	{

		$element = $this->getElement($id);

		//Update the data

		$element->touch();
		$element->save();

	}

	/**
	* Deletes the data
	* @param id The resource id
	*/
	protected function deleteResource($id)
	{

		Observation::destroy($id);

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
	* @param taxonomyId The filtered taxonomy id
	* @param fromDate The starting date of the search interval  
	* @param toDate The ending date of the search interval
	* @param areasId A string with the areas identifiers
	* @return An array of models
	*/
	protected function getFilteredElements($first, $num, $taxonomyId, $fromDate, $toDate,
			$areasId)
	{

		$values = Observation::filtered($taxonomyId, $fromDate, $toDate,
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
