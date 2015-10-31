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

		if(Input::has('latitude') && Input::has('longitude'))
		{

			return $this->getIASByLocation();

		}
		else
		{

			return $this->getIAS($first, $num);

		}

	}

	protected function getIASByLocation()
	{

		$latitude = Input::get('latitude');
		$longitude = Input::geT('longitude');

		$areas = Area::getAreaContains($latitude, $longitude);
		$vec = array();

		for($i=0; $i<count($areas); ++$i)
		{

			$ias = IASArea::iASByArea($areas[$i]->id)->get();
			for($j=0; $j<count($ias); ++$j)
			{

				$current = $ias[$j];
				if(FALSE === array_search($current->IASId, $vec))
					$vec[] = $current->IASId;

			}

		}

		return Response::json($vec);

	}

	protected function getIAS($first, $num)
	{

		$languageId = Language::locale(App::getLocale())->first()->id;
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;

		$elements = $this->getElements($first, $num);
		$numElements = count($elements);

		$taxons = IASTaxon::all();
		$numTaxons = count($taxons);

		$data = new stdClass();
		$data->list = array();
		$data->taxons = array();
		$lastUpdated = null;
		for($i=0; $i<$numElements; ++$i)
		{

			$aux = new stdClass();
			$element = $elements[$i];
			$aux->description = $element->getDescriptionData($languageId, $defaultLanguageId);
			$aux->latinName = $element->latinName;
			$aux->taxons = $element->taxonId;
			$aux->image = $element->getDefaultImageData($languageId, $defaultLanguageId);
			$aux->images = $element->getImageData($languageId, $defaultLanguageId);
			$aux->id = $element->id;
			$aux->relatedDBs = $element->getRelatedDBs();

			if(!array_key_exists($aux->taxons, $data->list))
				$data->list[$aux->taxons] = array();

			$data->list[$aux->taxons][] = $aux;

			if(null == $lastUpdated)
				$lastUpdated = $element->updated_at;
			else
				$lastUpdated = ($element->updated_at > $lastUpdated) ? $element->updated_at : $lastUpdated;

		}

		for($i=0; $i<$numTaxons; ++$i)
		{

			$element = $taxons[$i];
			$data->taxons[$element->id] = $element;

			$lastUpdated = ($element->updated_at > $lastUpdated) ? $element->updated_at : $lastUpdated;

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

		if(Auth::check())
		{

			$dto = new stdClass();

			if(Input::has('latinName') && Input::has('taxon') && 
				Input::has('descriptions'))
			{

				$element = new IAS();

				$element->latinName = Input::get('latinName');
				$element->taxonId = Input::get('taxon');
				$element->creatorId = Auth::id();
				$element->touch();
				$element->save();

				$descriptions = Input::get('descriptions');
				for($i=0; $i<count($descriptions); ++$i)
				{


					$current = $descriptions[$i];
					$iasDescription = new IASDescription();
					$iasDescription->IASId = $element->id;
					$iasDescription->languageId = $current->id;
					$iasDescription->name = $current->common;
					$iasDescription->shortDescription = $current->shortDesc;
					$iasDescription->sizeLongDescription = $current->sizeDesc;
					$iasDescription->infoLongDescription = $current->infoDesc;
					$iasDescription->habitatLongDescription = $current->infoHabitat;
					$iasDescription->confuseLongDescription = $current->infoConfuse;
					$iasDescription->creatorId = Auth::id();
					$iasDescription->touch();
					$iasDescription->save();

				}

				$portaitImageId = -1;
				$images = Input::get('images');
				for($i=0; $i<count($images); ++$i)
				{

					$current = $images[$i];
					$iasImage = new IASImage();
					$iasImage->IASId = $element->id;
					$iasImage->URL = $element->url;
					$iasImage->attribution = $element->attribution;
					$iasImage->order = 1;	//TODO: Input order from the administration panel
					$iasImage->creatorId = Auth::id();

					$iasImage->touch();
					$iasImage->save();

					if(-1 == $portaitImageId)
						$portaitImageId = $iasImage->id;

					for($k=0; $k<count($current->langs); ++$k)
					{

						$lang = $current->langs[$k];
						$iasImageText = new IASImageText();
						$iasImageText->IASIId = $iasImage->id;
						$iasImageText->languageId = $lang->id;
						$iasImageText->text = $lang->text;
						$iasImageText->creatorId = Auth::id();

						$iasImageText->touch();
						$iasImageText->save();

					}

				}

				if(-1 != $portaitImageId)
				{

					$element->defaultImageId = $portaitImageId;
					$element->save();

				}

				for($i=0; $i<count($areas); ++$i)
				{


					$current = $areas[$i];
					$area = new IASArea();
					$area->IASId = $element->id;
					$area->areaId = $current;
					$area->orderId = 1;	//TODO: Input order from the administration panel
					$area->creatorId = Auth::id();
					$area->touch();
					$area->save();

				}

				//TODO: Input repostitories and related DBs from the administration panel

			}
			else
			{

				$dto->error = Lang::get('ui.missingParameters');

			}

			return Response::json($dto);

		}

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
		$lastTaxon = IASTaxon::lastUpdated()->first();

		$obj = new stdClass();
		$obj->lastUpdated = ($lastIAS->updated_at > $lastTaxon->updated_at) ? $lastIAS->updated_at : $lastTaxon->updated_at;
		return Response::json($obj);

	}

}
