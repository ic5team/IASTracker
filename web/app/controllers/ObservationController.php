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

		if(!Input::has('isDownload'))
		{

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
		else
		{

			return $this->getFilteredData($first, $num);

		}

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
				$numTotals = Observation::count();
				$bIsValidator = false;

				if(Auth::user()->isAdmin)
				{

					//Show all the observations
					$query = Observation::withDataTableRequest($search, $orders, $columns)
						->statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending);
					$numFiltered = count($query->get());

					$validator = IASValidator::userId(Auth::user()->id)->first();
					if(null != $validator)
					{

						$bIsValidator = true;

					}

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
						$numFiltered = count($query->get());
						$bIsValidator = true;

					}
					else
					{

						//Get our observations
						$query = Observation::withDataTableRequest($search, $orders, $columns)
							->statuses($viewValidated, $viewDiscarded, $viewDeleted, $viewPending)
							->withUserId(Auth::user()->id);
						$numFiltered = count($query->get());

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
					$current->canBeValidated = $bIsValidator;
					$current->validateText = Lang::get('ui.validate');
					$current->discardText = Lang::get('ui.discard');
					$current->undoValidateText = Lang::get('ui.undoValidate');

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

					if(null != $current->validatorId)
					{

						$validator = IASValidator::find($current->validatorId);
						if(null != $validator)
						{

							$user = User::withTrashed()->find($validator->userId);
							$current->validatorName = $user->fullName;
							$current->validatorOrg = $validator->organization;

						}

					}

					$current->canDelete = ($current->userId == Auth::user()->id) || $bIsValidator;
					$current->canRotate = ($current->userId == Auth::user()->id) || $bIsValidator;

					$current->innerHtml = View::make('admin/innerObservation', array('current' => $current))->render();
					$obs[$i] = $current;

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

		$elements = $this->getFilteredElements($first, $num, $taxonsId, $fromDate, 
			$toDate, $areaIds);

		if(Input::has('isDownload') && Input::get('isDownload'))
		{

			//Generate the kml file
			return $this->generateKML($elements);

		}
		else
		{

			return $elements->toJson();

		}

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

			$output = $this->buildResource($element, false);
			return json_encode($output);

		}

	}

	protected function buildResource($element, $addData)
	{

		$languageId = Language::locale(App::getLocale())->first()->id;
		$configuration = Configuration::find(1);
		$defaultLanguageId = $configuration->defaultLanguageId;

		$data = $element;
		$ias = $element->IAS;
		$data->latinName = $ias->latinName;
		$data->description = $ias->getDescriptionData($languageId, $defaultLanguageId);
		$data->taxons = $ias->getTaxons($languageId, $defaultLanguageId);
		$data->image = $ias->getDefaultImageData($languageId, $defaultLanguageId);

		if(null != $element->userId)
		{

			$user = User::find($element->userId);
			if(null != $user)
				$data->user = $user;

		}

		if(null != $element->validatorId)
		{

			$validator = IASValidator::find($element->validatorId);
			if(null != $validator)
			{

				$user = User::withTrashed()->find($validator->userId);
				$data->validatorName = $user->fullName;
				$data->validatorOrg = $validator->organization;

			}

		}

		$data->status = $element->getStatus($languageId, $defaultLanguageId);
		$data->images = $element->observationImages;

		$output = new stdClass();
		$output->html = View::make('public/Obs/element', array('data' => $data))->render();

		if($addData)
			$output->data = $data;


		return $output;

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

			$validator = IASValidator::userId(Auth::user()->id)->first();
			if(null != $validator)
			{

				$element->statusId = Input::get('status');
				if(2 != Input::get('status'))
				{

					$user = Auth::user();
					$element->validatorId = $user->id;
					$element->validatorTS = new DateTime();
					$element->validationText = Input::get('text');

				}
				else
				{

					$element->validatorId = null;
					$element->validatorTS = null;
					$element->validationText = null;

				}

				$element->touch();
				$element->save();

				return json_encode($id);

			}

		}

	}

	/**
	* Deletes the data
	* @param id The resource id
	*/
	protected function deleteResource($id)
	{

		if(Auth::check() && Auth::user()->isAdmin)
		{

			$obs = Observation::find($id);
			$obs->delete();

		}

	}

	public function updateImage($id, $imageId)
	{

		if(Input::has('angle') && Auth::check())
		{

			$validator = IASValidator::userId(Auth::user()->id)->first();
			if(null != $validator || Auth::user()->isAdmin)
			{

				//We store the rotation on the database because imagecreatefromjpeg removes exif data
				$image = ObservationImage::find($imageId);
				$image->rotation = Input::get('angle');
				$image->touch();
				$image->save();

				return Response::json(true);

			}

		}

	}

	public function destroyImage($id, $imageId)
	{

		if(Auth::check())
		{

			$obs = Observation::find($id);
			$bIsValidator = false;
			$validator = IASValidator::userId(Auth::user()->id)->first();
			if(null != $validator)
			{

				$bIsValidator = true;

			}

			if($obs->userId == Auth::user()->id || $bIsValidator)
			{

				$image = ObservationImage::find($imageId);
				if($obs->id == $image->observationId)
				{

					unlink('./img/'.$image->URL);
					$image->delete();
					return Response::json(true);

				}

			}

		}

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

	protected function generateKML($observations)
	{

		if(0 == count($observations))
		{

			$data = new stdClass();
			$data->error = Lang::get('ui.noObservations');
			return json_encode($data);

		}
		else
		{

			setcookie('fileDownload', 'true', 0 , '/');
			$folders = array();

			for($i=0; $i<count($observations); ++$i)
			{

				$currentFolder = null;
				$current = $observations[$i];
				$resource = $this->buildResource($current, true);

				if(1 == $current->statusId)	//Only download the validated data
				{

					if(array_key_exists($resource->data->latinName, $folders))
					{

						$currentFolder = $folders[$resource->data->latinName];

					}
					else
					{

						$currentFolder = array();

					}

					$currentFolder[] = $resource;
					$folders[$resource->data->latinName] = $currentFolder;

				}

			}

			$kml = '<?xml version="1.0" encoding="UTF-8"?>
					<kml xmlns="http://www.opengis.net/kml/2.2">
	  					<Document>
							<name>IASTracker Observations</name>
							<open>1</open>
							<description>Observations from IC5Team\'s IASTracker project at iastracker.ic5team.org</description>
							<Folder>
	  							<name>Validated Observations</name>
							';

			$keys = array_keys($folders);
			for($i=0; $i<count($folders); ++$i)
			{

				$currentFolder = $folders[$keys[$i]];
				$kml .= '		<Folder>
									<name>'.$keys[$i].'</name>
	  								';
				for($j=0; $j<count($currentFolder); ++$j)
				{

					$current = $currentFolder[$j];
					$kml .= '		<Placemark>
										<name>'.(property_exists($current->data, 'user') ? $current->data->user->username : '').' '.$current->data->created_at.'</name>
	        							<visibility>1</visibility>
	        							<aux>234</aux>
	        							<description><![CDATA[ <table width="800">'.$current->html.'</table>]]></description>
										<Point>
											<coordinates>'.$current->data->longitude.','.$current->data->latitude.',0</coordinates>
										</Point>
									</Placemark>
						';

				}

				$kml .= '		</Folder>
						';

			}

			$kml .= '		</Folder>
						</Document>
					</kml>';

			$resp = Response::make($kml);
			$resp->header('Content-Type', 'application/vnd.google-earth.kml+xml');

			return $resp;

		}

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
