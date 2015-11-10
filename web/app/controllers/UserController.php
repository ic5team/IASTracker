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

		if(Auth::check() && Auth::user()->isAdmin)
		{

			$elements = $this->getElements($first, $num);
			return Response::json($elements);

		}
		else
		{

			App::abort(403);

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
			$userId = User::idDESC()->first()->id;
			$element = new User(array(
				'id' => $userId+1,
				'languageId' => Language::locale(App::getLocale())->first()->id,
				'mail' => $inMail,
				'isActive' => false,
				'activationKey' => $token,
				'amIExpert' => false,
				'isExpert' => false,
				'isAdmin' => false,
				'lastConnection' => new DateTime()));

			$element->touch();
			$element->save();

			Mail::send('emails.welcome', array('token' => $token, 'user' => $inMail), function($message) use ($inMail)
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
		else if(Input::has('token') && Input::has('pw1') 
			&& Input::has('pw2') )
		{

			$out = $this->setResetPassword($element);

		}
		else if(Input::has('language')
			&& Input::has('isExpert'))
		{

			if(Input::has('token'))
			{

				$user = User::userToken(Input::get('token'))->first();
				if((null != $user) && ($id == $user->id))
				{

					$out = $this->setUserData($element);

				}

			}
			else if(Auth::check() && ($id == Auth::user()->id))
			{

				$out = $this->setUserData($element);

			}

		}
		else if(Input::has('expert') 
			&& Input::has('validator')
			&& Input::has('admin'))
		{

			$isValidator = Input::get('validator');
			$element->isExpert = Input::get('expert');
			$element->isAdmin = Input::get('admin');
			$element->touch();
			$element->save();

			$val = IASValidator::userId($element->id)->first();
			if("true" == $isValidator)
			{

				if(null == $val)
				{

					$val = new IASValidator(array(
						'userId' => $element->id,
						'organization' => Input::get('organization'),
						'creatorId' => Auth::id(),
						'created_at' => new DateTime(),
						'updated_at' => new DateTime()));

				}
				else
				{

					$val->organization = Input::get('organization');

				}

				$val->touch();
				$val->save();

			}
			else
			{

				if(null != $val)
					$val->delete();

			}

			$out = $element->id;

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

	protected function setResetPassword($element)
	{

		$out = new stdClass();
		$token = Input::get('token');
		$pw1 = Input::get('pw1');
		$pw2 = Input::get('pw2');

		if(($element->resetKey == $token) 
			&& ($pw1 == $pw2))
		{

			$element->password = Hash::make($pw1);
			$element->resetKey = null;
			$element->lastConnection = new DateTime();
			$element->touch();
			$element->save();

			$out->html = View::make('public/User/passwordChanged')->render();

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
		$name = $element->fullName; 
		$language = Input::get('language');
		$isExpert = Input::get('isExpert');
		$image = Input::get('imageURL');
		$dbPhotoName = $element->photoURL;

		if(Input::has('name'))
			$name = Input::get('name');

		if(Input::has('imageURL'))
		{

			if(false !== strpos($image, 'uploads'))
			{

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

					$dbPhotoName = $e->getMessage(); //$element->photoURL;

				}

			}
			else
			{

				$dbPhotoName = $element->photoURL;

			}

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

		$query = null;
		$data = new stdClass();
		if(Input::has('draw'))
		{

			try {

				//Datatable request
				$draw = Input::get('draw');
				$search = Input::get('search');
				$orders = Input::get('order');
				$columns = Input::get('columns');
				$data->recordsFiltered = count(User::withDataTableRequest($search, $orders, $columns)->get());
				$users = User::withDataTableRequest($search, $orders, $columns)->skip($first)->take($num)->get();
				$data->draw = intval($draw);
				$data->recordsTotal = User::count();
				for($i=0; $i<count($users); ++$i)
				{

					$current = $users[$i];
					$current->DT_RowId = $current->id;
					$current->photoURL = Config::get('app.urlImgThumbs').$current->photoURL;
					$current->observationNumber = $current->getObservationsNumber();
					$current->validatedNumber = $current->getValidatedNumber();
					$validator = IASValidator::userId($current->id)->first();
					$current->isValidator = false;
					if(null != $validator)
					{

						$current->isValidator = true;
						$current->organization = $validator->organization;

					}

					$users[$i] = $current;

				}

				$data->data = $users;

			}
			catch(Exception $e)
			{

				$data->error = $e->getMessage();

			}

		}
		else
		{

			$data = User::orderBy('username')
				->skip($first)->take($num)->get();

		}

		return $data;

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

	public function remind()
	{

		$email = Input::get('email');
		$data = $this->getBasicData();

		$user = User::email($email)->first();
		$dto = new stdClass();

		if($user != NULL)
		{

			$token = str_random(40);
			$user->resetKey = $token;
			$user->touch();
			$user->save();

			Mail::send('emails.auth.reminder', array('token' => $token, 'user' => $email), function($message) use ($email)
			{

				$message->to($email, '')->subject(Lang::get('email.passwordReminderSubject').'!');

			});

		}
		else
		{

			$dto->error = Lang::get('ui.notUsedEmail');

		}

		return Response::json($dto);

	}

	public function resetPassword()
	{

		$token = Input::get('token');
		$user = NULL;
		if(Input::has('token'))
			$user = User::resetKey($token)->first();

		$data = $this->getBasicData();
		if(NULL == $user)
		{

			if(Auth::check())
			{

				$user = Auth::user();

				$token = str_random(40);
				$user->resetKey = $token;
				$user->save();

			}

		}

		if($user != NULL)
		{

			$lang = Language::find($user->languageId);
			App::setLocale($lang->locale);
			return View::make("public/reset", array('data' => $data,
				'token' => $token, 'userId' => $user->id));

		}
		else
		{

			App::abort(403);

		}

	}

	public function login()
	{

		$obj = new stdClass();
		if(!Auth::attempt(array('mail' => Input::get('email'), 
			'password' => Input::get('password')), true))
		{

			$obj->error = Lang::get('ui.wrongUserCredentials');

		}

		if(Auth::user())
		{

			$user = Auth::user();
			$obj->token = str_random(40);
			$obj->id = $user->id;
			$obj->nick = $user->username;
			$obj->image = $user->photoURL;
			$obj->fullName = $user->fullName;
			$obj->amIExpert = $user->amIExpert;
			$user->appKey = $obj->token;
			$user->lastConnection = new DateTime();
			$user->save();

		}
		
		return Response::json($obj);

	}

	public function checkUserToken($id)
	{

		$user = User::userToken(Input::get('token'))->first();
		
		$data = new stdClass();
		
		if(null == $user)
			$data->error = true;
		else if($user->id != $id)
			$data->error = true;
		else
		{

			$data->name = $user->fullName;
			$data->image = $user->photoURL;
			$data->amIExpert = $user->amIExpert;
			$data->languageId = $user->languageId;

		}
		
		//TODO: Check if token has expired

		return Response::json($data);

	}

}
