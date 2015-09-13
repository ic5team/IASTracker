<?php

class StateController extends RequestController {

	/**
	* Returns a list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return A JSON Response
	*/
	protected function elements($first, $num)
	{

		$elements = $this->getElements($first, $num);
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
		return Response::view('adm/States/list', array('data' => $elements));

	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{

		return Response::view('adm/States/create');

	}

	/**
	* Stores the data
	* @throws QueryException if the resource can't be stored
	*/
	protected function newResource()
	{

		$element = new State(array());

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

		$languageId = Language::locale(App::getLocale())->first()->id;
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;

		$data = new stdClass();
		$element = $this->getElement($id);

		if(null != $element)
		{

			$data = $element;

			$output = new stdClass();
			$output->html = View::make('public/States/element', array('data' => $data))->render();
			$output->data = $id;

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
		return Response::view('adm/States/element', array('data' => $element));

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

		IAS::destroy($id);

	}

	/**
	* Gets all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return An array of models
	*/
	protected function getElements($first, $num)
	{

		return State::ordered()
			->skip($first)->take($num)->get();

	}

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	protected function getElement($id)
	{

		return State::find($id);

	}

	protected function getRegions($id)
	{

		if(Request::ajax())
		{

			$regions = array();
			$regions[-1] = Lang::get('ui.allRegions');
			$areas = array();
			$areas[-1] = Lang::get('ui.allAreas');

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$reg = Region::active(true)->stateId($id)->ordered()->get();
			for($i=0; $i<count($reg); ++$i)
			{

				$regions[$reg[$i]->id] = $reg[$i]->name;

			}
			unset($reg);

			$are = Area::stateId($id)->ordered()->get();
			for($i=0; $i<count($are); ++$i)
			{

				$areas[$are[$i]->id] = $are[$i]->name;

			}
			unset($are);

			$output = new stdClass();
			$output->html = View::make("public/regions", array('regions' => $regions, 
				'areas' => $areas))->render();
			$output->data = new stdClass();
			$output->data->regions = $regions;
			$output->data->areas = $areas;

			return json_encode($output);

		}

	}

}
