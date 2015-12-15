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
		else if(Input::has('draw'))
		{

			return $this->getDataTablesData($first, $num);

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

	protected function getDataTablesData($first, $num)
	{

		if(Auth::check() && Auth::user()->isAdmin)
		{

			try {

				//Datatable request
				$data = new stdClass();
				$draw = Input::get('draw');
				$search = Input::get('search');
				$orders = Input::get('order');
				$columns = Input::get('columns');

				$ias = null;
				$numTotals = IAS::count();
				$query = IAS::withDataTableRequest($search, $orders, $columns);
				$numFiltered = count($query->get());

				$ias = $query->skip($first)->take($num)->get();
				$data->draw = intval($draw);
				$data->recordsTotal = $numTotals;

				$languageId = Language::locale(App::getLocale())->first()->id;
				$configuration = Configuration::find(1);
				$defaultLanguageId = $configuration->defaultLanguageId;
				$languages = Language::all();
				$taxons = IASTaxon::all();
				$areas = Area::all();

				for($i=0; $i<count($taxons); ++$i)
				{

					$element = $taxons[$i];
					$element->name = $taxons[$i]->getName($languageId, $defaultLanguageId);
					$taxons[$element->id] = $element;

				}
				
				for($i=0; $i<count($ias); ++$i)
				{
					
					$aux = new stdClass();
					$current = $ias[$i];
					$aux->DT_RowId = $current->id;
					$desc = array();

					for($j=0; $j<count($languages); ++$j)
					{

						$iasDesc = IASDescription::withIASAndLanguageId(
							$current->id, $languages[$j]->id)->first();

						$descObj = new stdClass();
						if(null == $iasDesc)
						{

							$descObj->name = '';
							$descObj->shortDescription = '';
							$descObj->sizeDescription = '';
							$descObj->infoDescription = '';
							$descObj->habitatDescription = '';
							$descObj->confuseDescription = '';

						}
						else
						{

							$descObj->name = $iasDesc->name;
							$descObj->shortDescription = $iasDesc->shortDescription;
							$descObj->sizeDescription = $iasDesc->sizeLongDescription;
							$descObj->infoDescription = $iasDesc->infoLongDescription;
							$descObj->habitatDescription = $iasDesc->habitatLongDescription;
							$descObj->confuseDescription = $iasDesc->confuseLongDescription;

						}

						$desc[$languages[$j]->id] = $descObj;

					}

					$current->description = $desc;

					$aux->id = $current->id;
					$aux->latinName = $current->latinName;
					$aux->name = $current->description[$languageId]->name;
					if('' == $aux->name)
						$aux->name = $current->description[$defaultLanguageId]->name;

					$images = IASImage::withIASId($current->id)->get();
					$imgs = array();
					for($j=0; $j<count($images); ++$j)
					{

						$obj = new stdClass();
						$img = $images[$j];

						$obj->id = $img->id;
						$obj->order = $img->order;
						$obj->url = $img->URL;
						$obj->attribution = $img->attribution;
						$obj->texts = array();
						
						for($k=0; $k<count($languages); ++$k)
						{

							$imgText = IASImageText::withIASImageAndLanguageId(
								$img->id, $languages[$k]->id)->first();
							
							if(null != $imgText)
								$obj->texts[$languages[$k]->id] = $imgText->text;
							else
								$obj->texts[$languages[$k]->id] = "";

						}

						$imgs[] = $obj;

					}

					$current->images = $imgs;

					$areasIAS = IASArea::areasByIAS($current->id)->get();
					$areasIds = array();
					for($j=0; $j<count($areasIAS); ++$j)
						$areasIds[] = $areasIAS[$j]->areaId;

					for($j=0; $j<count($areas); ++$j)
					{

						$areas[$j]->hasIAS = in_array($areas[$j]->id, $areasIds);

					}

					$taxon = IASTaxon::withTaxonAndLanguageId($current->taxonId, $languageId)->first();
					if(null == $taxon)
						$taxon = IASTaxon::withTaxonAndLanguageId($current->taxonId, $defaultLanguageId)->first();
					$aux->taxonName = $taxon->name;
					$aux->created_at = $current->created_at->format('Y-m-d H:i:s');

					$aux->innerHtml = View::make('admin/innerIAS', array('taxons' => $taxons, 'languages' => $languages, 'areas' => $areas,
						'current' => $current))->render();
					$obs[$i] = $aux;

				}

				$data->recordsFiltered = $numFiltered;
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

		return Response::json($data);

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
			$aux->descriptions = $element->getDescriptionsData($defaultLanguageId);
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
			$element->name = $taxons[$i]->getName($languageId, $defaultLanguageId);
			$element->names = $taxons[$i]->getNames($defaultLanguageId);
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

		if(Auth::check() && Auth::user()->isAdmin)
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
			$data->taxons = $element->getTaxons($languageId, $defaultLanguageId);
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

		if(Auth::check() && Auth::user()->isAdmin)
		{

			$dto = new stdClass();

			if(Input::has('latinName') && Input::has('taxon') && 
				Input::has('descriptions'))
			{

				$element = IAS::find($id);

				$element->latinName = Input::get('latinName');
				$element->taxonId = Input::get('taxon');
				$element->creatorId = Auth::id();
				$element->touch();
				$element->save();

				$descriptions = Input::get('descriptions');
				for($i=0; $i<count($descriptions); ++$i)
				{

					$current = $descriptions[$i];
					$iasDescription = IASDescription::withIASAndLanguageId($id, $current['id'])->first();
					$iasDescription->name = $current['common'];
					$iasDescription->shortDescription = $current['shortDesc'];
					$iasDescription->sizeLongDescription = $current['sizeDesc'];
					$iasDescription->infoLongDescription = $current['infoDesc'];
					$iasDescription->habitatLongDescription = $current['infoHabitat'];
					$iasDescription->confuseLongDescription = $current['infoConfuse'];
					$iasDescription->creatorId = Auth::id();
					$iasDescription->touch();
					$iasDescription->save();

				}

				$portaitImageId = -1;
				$images = Input::get('images');
				$originalImages = IASImage::withIASId($element->id)->get();
				$idsExistingImages = array();
				for($i=0; $i<count($images); ++$i)
				{

					$current = $images[$i];
					$iasImage = null;
					if(array_key_exists('id', $current))
					{

						$iasImage = IASImage::find($current['id']);
						$idsExistingImages[] = $current['id'];

					}
					else
					{

						$iasImage = new IASImage();
						$iasImage->IASId = $element->id;

					}

					$iasImage->URL = str_replace('"', '', $current['url']);
					$iasImage->attribution = $current['attribution'];
					$iasImage->order = $current['order'];
					$iasImage->creatorId = Auth::id();

					$iasImage->touch();
					$iasImage->save();

					if(1 == $current['order'])
						$portaitImageId = $iasImage->id;

					if(-1 == $portaitImageId)
						$portaitImageId = $iasImage->id;

					for($k=0; $k<count($current['langs']); ++$k)
					{

						$lang = $current['langs'][$k];
						$iasImageText = IASImageText::withIASImageAndLanguageId($iasImage->id, $lang['id'])->first();
						if(null == $iasImageText)
							$iasImageText = new IASImageText();

						$iasImageText->IASIId = $iasImage->id;
						$iasImageText->languageId = $lang['id'];
						$iasImageText->text = $lang['text'];
						$iasImageText->creatorId = Auth::id();

						$iasImageText->touch();
						$iasImageText->save();

					}

				}

				//Delete the images that were present before but are deleted
				for($i=0; $i<count($originalImages); ++$i)
				{

					if(!in_array($originalImages[$i]->id, $idsExistingImages))
						IASImage::destroy($originalImages[$i]->id);

				}

				if(-1 != $portaitImageId)
				{

					$element->defaultImageId = $portaitImageId;
					$element->save();

				}

				$originalAreas = IASArea::areasByIAS($element->id)->get();
				$idsExistingAreas = array();
				$areas = Input::get('areas');
				for($i=0; $i<count($areas); ++$i)
				{


					$current = $areas[$i];
					$area = IASArea::withIASAndAreaId($element->id, $current)->first();
					if(null == $area)
					{

						$area = new IASArea();
						$area->IASId = $element->id;
						$area->areaId = $current;
						$area->orderId = 1;	//TODO: Input order from the administration panel
						$area->creatorId = Auth::id();
						$area->touch();
						$area->save();

					}
					else
					{

						$idsExistingAreas[] = $current;

					}

				}

				//Delete the images that were present before but are deleted
				for($i=0; $i<count($originalAreas); ++$i)
				{

					if(!in_array($originalAreas[$i]->areaId, $idsExistingAreas))
						IASArea::destroy($originalAreas[$i]->id);

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
		$lastArea = IASArea::lastUpdated()->first();
		$lastDescription = IASDescription::lastUpdated()->first();
		$lastImage = IASImage::lastUpdated()->first();
		$lastImageText = IASImageText::lastUpdated()->first();
		$lastTaxonName = IASTaxonName::lastUpdated()->first();
		$lastRelatedDBs = IASRelatedDB::lastUpdated()->first();

		$obj = new stdClass();
		$obj->lastUpdated = $lastIAS->updated_at;

		if($obj->lastUpdated < $lastTaxon->updated_at)
			$obj->lastUpdated = $lastTaxon->updated_at;

		if($obj->lastUpdated < $lastArea->updated_at)
			$obj->lastUpdated = $lastArea->updated_at;

		if($obj->lastUpdated < $lastDescription->updated_at)
			$obj->lastUpdated = $lastDescription->updated_at;

		if($obj->lastUpdated < $lastImage->updated_at)
			$obj->lastUpdated = $lastImage->updated_at;

		if($obj->lastUpdated < $lastImageText->updated_at)
			$obj->lastUpdated = $lastImageText->updated_at;

		if($obj->lastUpdated < $lastTaxonName->updated_at)
			$obj->lastUpdated = $lastTaxonName->updated_at;

		if($obj->lastUpdated < $lastRelatedDBs->updated_at)
			$obj->lastUpdated = $lastRelatedDBs->updated_at;

		return Response::json($obj);

	}

}
