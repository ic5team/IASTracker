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

		$elements = getElements($first, $num);
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

		$elements = getElements($first, $num);
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

		$element = $this->getElement($id);
		if(NULL != $element)
			return Response::json($element);

	}

	/**
	* Returns a view of one of the elements
	* @param id The resource id
	* @return Response
	*/
	protected function showResourceView($id)
	{

		$element = getElemens($id);
		return Response::view('adm/IAS/element', array('data' => $element));

	}

	/**
	* Updates the data
	* @param id The resource id
	*/
	protected function updateResource($id)
	{

		$element = getElement($id);

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

		return IAS::orderBy('latinName')
			->skip($first)->take($num)->get();

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

				$obj = $current;
				if(null != $current->portraitImageId)
				{

					$img = IASImage::find($current->portraitImageId);
					$obj->image = $img->URL;
					$obj->imageAttribution = $img->attribution;
					$imgText = IASImageText::withIASAndLanguageId(
						$current->id, $languageId)->first();
					if(null == $imgText)
					{

						$imgText = IASImageText::withIASAndLanguageId(
							$current->id, $defaultLanguageId)->first();

					}
					$obj->imageText = $imgText->text;

					$iasDesc = IASDescription::withIASAndLanguageId(
						$current->id, $languageId)->first();
					if(null == $iasDesc)
					{

						$iasDesc = IASDescription::withIASAndLanguageId(
							$current->id, $defaultLanguageId)->first();

					}
					$obj->name = $iasDesc->name;
					$obj->desc = $iasDesc->shortDescription;
					

					unset($img);
					unset($imgText);
					unset($iasDesc);

				}

				$data[] = $obj;

			}

			unset($ias);

			$taxons = IASTaxon::withLanguageId($languageId)->get();
			if(null == $taxonomies)
				$taxons = IASTaxon::withLanguageId($defaultLanguageId)->get();
			for($i=0; $i<count($taxons); ++$i)
			{

				$taxonomies[$taxons->id] = $taxons->name;

			}
			unset($iasTaxons);

			$output = new stdClass();
			$output->html = View::make("public/filter", array('data' => $data, 
				'taxonomies' => $taxonomies))->render();
			$output->data = $data;

			return json_encode($output);

		}

	}

}
