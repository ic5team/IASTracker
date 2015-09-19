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

		$inMail = Input::get('email');
		$params = array();
		$paramAttribs = array();
		$dto = new stdClass();

		if(Input::has('email'))
		{

			$params['mail'] = $inMail;
			$paramAttribs['mail'] = 'required|email|unique:Users,mail';

		}

		$validator = Validator::make($params, $paramAttribs);

		if($validator->fails())
		{

			$dto->error = $validator->messages()->first();

		}
		else
		{

			$token = str_random(40);
			$element = new User(array('languageId' => Language::locale(App::getLocale())->first()->id,
				'mail' => $inMail,
				'isActive' => false,
				'activationKey' => $token,
				'amIExpert' => false,
				'isExpert' => false,
				'isAdmin' => false,
				'lastConnection' => new DateTime()));

			$element->touch();
			$element->save();

			Mail::send('emails.welcome', array('token' => $token), function($message) use ($inMail)
			{

				$message->to($inMail, '')->subject(Lang::get('email.welcomeSubject').'!');

			});

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

		$out = new stdClass();
		$element = $this->getElement($id);
		$view = '';

		if(Input::has('token') && Input::has('pw1') 
			&& Input::has('pw2') && Input::has('nick'))
		{

			$out = $this->setPassword($element);

		}
		else if(Input::has('name') && Input::has('language')
			&& Input::has('isExpert') && Input::has('imageURL'))
		{

			if(Auth::check() && ($id == Auth::user()->id))
				$out = $this->setUserData($element);

		}

		return json_encode($out);

	}

	protected function setPassword($element)
	{

		$out = new stdClass();
		$token = Input::get('token');
		$pw1 = Input::get('pw1');
		$pw2 = Input::get('pw2');
		$nick = Input::get('nick');

		if(($element->activationKey == $token) 
			&& ($pw1 == $pw2))
		{

			$user = User::nickname($nick)->first();
			if(null == $user)
			{

				$element->password = Hash::make($pw1);
				$element->username = $nick;
				$element->isActive = true;
				$element->activationKey = null;
				$element->lastConnection = new DateTime();
				$element->touch();
				$element->save();

				Auth::login($element);
				$out->html = View::make('public/User/activated')->render();

			}
			else
			{

				$out->html = View::make('public/User/noActivated', 
					array('message' => Lang::get('ui.duplicatedNick')))->render();

			}

		}
		else if($pw1 == $pw2)
		{

			$out->html = View::make('public/User/noActivated', 
					array('message' => Lang::get('ui.invalidToken')))->render();

		}
		else
		{

			$out->html = View::make('public/User/noActivated', 
					array('message' => Lang::get('ui.pwMismatch')))->render();

		}

		return $out;

	}

	protected function setUserData($element)
	{

		$out = new stdClass();
		$name = Input::get('name');
		$language = Input::get('language');
		$isExpert = Input::get('isExpert');
		$image = Input::get('imageURL');

		//Move the image
		$originalName = explode("/", $image);
		$originalName = $originalName[count($originalName) - 1];
		$desinationFolder = '/users/';

		$nameParts = explode(".", $originalName);
		$ext = strtoupper($nameParts[count($nameParts)-1]);

		$dbPhotoName = $desinationFolder.'u'.$element->id.'.'.$ext;

		$thumbsPath = './img/thumbs/';
		$photosPath = './img/fotos/';
		$pathThumbDesti = $thumbsPath.$dbPhotoName;
		$pathGranDesti = $photosPath.$dbPhotoName;

		try 
		{

			rename("./img/uploads/grans/".$originalName,$pathGranDesti);
			rename("./img/uploads/thumbs/".$originalName,$pathThumbDesti);

		}
		catch(Exception $e)
		{

			$dbPhotoName = $element->photoURL;

		}

		$element->fullName = $name;
		$element->languageId = $language;
		$element->amIExpert = $isExpert;
		$element->photoURL = $dbPhotoName;
		$element->lastConnection = new DateTime();
		$element->touch();
		$element->save();

		return $out;

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

	public function activate()
	{

		$token = Input::get('token');
		$data = $this->getBasicData();

		$user = User::activationKey($token)->first();

		if ($user != NULL && !$user->isActive)
		{

			$lang = Language::find($user->languageId);
			App::setLocale($lang->locale);
			return View::make("public/activate", array('data' => $data,
				'token' => $token, 'userId' => $user->id));

		}
		else
		{

			App::abort(403);

		}
	}

}
