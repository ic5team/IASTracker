<?php

class UserController extends RequestController {

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
		return Response::view('adm/User/list', array('data' => $elements));

	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{

		return Response::view('adm/User/create');

	}

	/**
	* Stores the data
	* @throws QueryException if the resource can't be stored
	*/
	protected function newResource()
	{

		$element = new User(array());

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

			$data = $element;
			$data->obsNum = $element->getObservationsNumber();
			$data->validatedObsNum = $element->getValidatedNumber();
			$data->lastObservation = $element->getLastObservation()[0]->created_at;
			$data->images = $element->getObservationImages();

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;
			$ias = $element->getObservedIAS($languageId, $defaultLanguageId);

			$output = new stdClass();
			$output->html = View::make('public/User/element', array('data' => $data, 'ias' => $ias))->render();
			$output->data = new stdClass();
			$output->data->id = $element->id;

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
		return Response::view('adm/User/element', array('data' => $element));

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

		User::destroy($id);

	}

	/**
	* Gets all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return An array of models
	*/
	protected function getElements($first, $num)
	{

		return User::orderBy('username')
			->skip($first)->take($num)->get();

	}

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	protected function getElement($id)
	{

		return User::find($id);

	}

	protected function getObservations($id)
	{

		if(Request::ajax())
		{

			$elements = Observation::withUserId($id)
				->orderBy('id')->get();

			return Response::json($elements->toJson());

		}

	}

}
