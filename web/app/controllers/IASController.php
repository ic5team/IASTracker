<?php

class IASController extends RequestController {

	/**
	* Returns a list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return A JSON Response
	*/
	protected function elements($first, $num)
	{

		$languageId = Language::locale(App::getLocale())->first()->id;
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;

		$elements = $this->getElements($first, $num);
		$numElements = count($elements);

		$data = new stdClass();
		$data->list = array();
		$lastUpdated = null;
		for($i=0; $i<$numElements; ++$i)
		{

			$aux = new stdClass();
			$element = $elements[$i];
			$aux->description = $element->getDescriptionData($languageId, $defaultLanguageId);
			$aux->latinName = $element->latinName;
			$aux->taxons = $element->taxonId;
			$aux->image = $element->getDefaultImageData($languageId, $defaultLanguageId);
			$aux->relatedDBs = $element->getRelatedDBs();
			$data->list[] = $aux;

			if(null == $lastUpdated)
				$lastUpdated = $element->created_at;
			else
				$lastUpdated = ($element->created_at > $lastUpdated) ? $element->created_at : $lastUpdated;

		}

		$data->lastUpdated = $lastUpdated;

		return json_encode($data);

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
		return Response::view('adm/IAS/list', array('data' => $elements));

	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{

		return Response::view('adm/IAS/create');

	}

	/**
	* Stores the data
	* @throws QueryException if the resource can't be stored
	*/
	protected function newResource()
	{

		$element = new IAS(array());

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

			$data->description = $element->getDescriptionData($languageId, $defaultLanguageId);
			$data->latinName = $element->latinName;
			$data->taxons = $element->getTaxons();
			$data->image = $element->getDefaultImageData($languageId, $defaultLanguageId);
			$data->relatedDBs = $element->getRelatedDBs();
			$data->images = $element->getImageData($languageId, $defaultLanguageId);

			$output = new stdClass();
			$output->html = View::make('public/IAS/element', array('data' => $data))->render();
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
		return Response::view('adm/IAS/element', array('data' => $element));

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

		return IAS::orderByTaxon()->orderByName()->get();

	}

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	protected function getElement($id)
	{

		return IAS::find($id);

	}

	protected function getFilter()
	{

		if(Request::ajax())
		{

			$data = array();
			$taxonomies = array();
			$taxonomies[-1] = Lang::get('ui.taxonomiesAll');

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$ias = IAS::all();
			for($i=0; $i<count($ias); ++$i)
			{

				$current = $ias[$i];
				$obj = new stdClass();

				$obj->image = $current->getDefaultImageData($languageId, $defaultLanguageId);
				$obj->description = $current->getDescriptionData($languageId, $defaultLanguageId);
				$obj->latinName = $current->latinName;
				$obj->id = $current->id;
				$obj->taxonId = $current->taxonId;

				$data[] = $obj;

			}

			unset($ias);

			$taxons = IASTaxon::withLanguageId($languageId)->get();
			if(null == $taxons)
				$taxons = IASTaxon::withLanguageId($defaultLanguageId)->get();
			for($i=0; $i<count($taxons); ++$i)
			{

				$taxonomies[$taxons[$i]->id] = $taxons[$i]->name;

			}
			unset($taxons);

			$output = new stdClass();
			$output->html = View::make("public/filter", array('data' => $data, 
				'taxonomies' => $taxonomies))->render();
			$output->data = $data;

			return json_encode($output);

		}

	}

	protected function getObservations($id)
	{

		if(Request::ajax())
		{

			$elements = Observation::withIASId($id)
				->orderBy('id')->get();

			return Response::json($elements->toJson());

		}

	}

	protected function getLastUpdate()
	{

		$lastIAS = IAS::lastUpdated()->first();
		$obj = new stdClass();
		$obj->lastUpdated = $lastIAS->created_at;
		return Response::json($obj);

	}

}
