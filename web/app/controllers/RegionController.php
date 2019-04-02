<?php

class RegionController extends RequestController {

	/**
	* Returns a list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return A JSON Response
	*/
	protected function elements($first, $num)
	{

		if(Input::has('draw'))
		{

			return $this->getDataTablesData($first, $num);

		}
		else
		{

			return $this->getRegions($first, $num);

		}

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

				$areas = null;
				$numTotals = Area::count();
				$query = Area::withDataTableRequest($search, $orders, $columns);
				$numFiltered = count($query->get());

				$areas = $query->skip($first)->take($num)->get();
				$data->draw = intval($draw);
				$data->recordsTotal = $numTotals;
				$ValidatorUsers = ValidatorUser::all();
				
				for($i=0; $i<count($areas); ++$i)
				{
					
					$aux = new stdClass();
					$current = $areas[$i];
					$aux->DT_RowId = $current->id;

					for($j=0; $j<count($ValidatorUsers); ++$j)
					{

						$av = AreaValidator::WithAreaAndValidatorId($current->id, $ValidatorUsers[$j]->userId)->first();
						$user = User::find($ValidatorUsers[$j]->userId);
						$ValidatorUsers[$j]->fullName = $user->fullName;
						$ValidatorUsers[$j]->isChecked = (null != $av);

					}

					$aux->id = $current->id;
					$aux->name = $current->name;
					$aux->zIndex = $current->zIndex;
					$aux->created_at = $current->created_at->format('Y-m-d H:i:s');

					$aux->innerHtml = View::make('admin/innerArea', array('validators' => $ValidatorUsers, 
						'current' => $current))->render();
					$areas[$i] = $aux;

				}

				$data->recordsFiltered = $numFiltered;
				$data->data = $areas;

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

	protected function getRegions($first, $num)
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
		return Response::view('adm/Regions/list', array('data' => $elements));

	}

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	protected function showCreateForm()
	{

		return Response::view('adm/Regions/create');

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

			if(Input::has('name') && Input::has('zIndex') && 
				Input::has('geom'))
			{

				$element = new Area();

				$element->name = Input::get('name');
				$element->zIndex = Input::get('zIndex');
				$element->geom = Input::get('geom');

				if(Input::has('shapeFile'))
				{

					$element->shapeFileURL = Input::get('shapeFile');

				}

				$element->creatorId = Auth::id();
				$element->touch();
				$element->save();

				$ValidatorUsers = Input::get('ValidatorUsers');
				for($i=0; $i<count($ValidatorUsers); ++$i)
				{

					$val = new AreaValidator();
					$val->areaId = $element->id;
					$val->validatorId = $ValidatorUsers[$i];
					$val->creatorId = Auth::id();
					$val->touch();
					$val->save();

				}

				Area::recomputeIntersections();

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

			$data = $element;

			$output = new stdClass();
			$output->html = View::make('public/Regions/element', array('data' => $data))->render();
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
		return Response::view('adm/Regions/element', array('data' => $element));

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
			$dto->id = $id;

			if(Input::has('name') && Input::has('zIndex') && 
				Input::has('geom'))
			{

				$element = Area::find($id);

				$element->name = Input::get('name');
				$element->zIndex = Input::get('zIndex');
				$element->geom = Input::get('geom');

				if(Input::has('shapeFile'))
				{

					$element->shapeFileURL = Input::get('shapeFile');

				}

				$element->creatorId = Auth::id();
				$element->touch();
				$element->save();

				$originalValidatorUsers = AreaValidator::withAreaId($element->id)->get();
				$idsExistingValidatorUsers = array();
				$ValidatorUsers = Input::get('validators');
				for($i=0; $i<count($ValidatorUsers); ++$i)
				{


					$current = $ValidatorUsers[$i];
					$val = AreaValidator::withAreaAndValidatorId($element->id, $current)->first();
					if(null == $val)
					{

						$val = new AreaValidator();
						$val->areaId = $element->id;
						$val->validatorId = $current;
						$val->creatorId = Auth::id();

					}
					else
					{

						$idsExistingValidatorUsers[] = $current;

					}

					$val->touch();
					$val->save();

				}

				//Delete the ValidatorUsers that were present before but are now deleted
				for($i=0; $i<count($originalValidatorUsers); ++$i)
				{

					if(!in_array($originalValidatorUsers[$i]->validatorId, $idsExistingValidatorUsers))
					{

						AreaValidator::destroy($originalValidatorUsers[$i]->id);

					}

				}

				Area::recomputeIntersections();
				//TODO: Should also update all the Observation - Area relations

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

		Area::destroy($id);

	}

	/**
	* Gets all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return An array of models
	*/
	protected function getElements($first, $num)
	{

		return Region::ordered()
			->skip($first)->take($num)->get();

	}

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	protected function getElement($id)
	{

		return Region::find($id);

	}

	protected function getAreas($id)
	{

		if(Request::ajax())
		{

			$areas = array();
			$areas[-1] = Lang::get('ui.allAreas');

			$languageId = Language::locale(App::getLocale())->first()->id;
			$configuration = Configuration::find(1);
			$defaultLanguageId = $configuration->defaultLanguageId;

			$are = Area::regionId($id)->ordered()->get();
			for($i=0; $i<count($are); ++$i)
			{

				$areas[$are[$i]->id] = $are[$i]->name;

			}
			unset($are);

			$output = new stdClass();
			$output->html = View::make("public/areas", array('areas' => $areas))->render();
			$output->data = new stdClass();
			$output->data->areas = $areas;

			return json_encode($output);

		}

	}

}
