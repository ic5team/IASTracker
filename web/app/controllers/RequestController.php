<?php

abstract class RequestController extends BaseController {

	/**
	* Returns a list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return A JSON Response
	*/
	abstract protected function elements($first, $num);

	/**
	* Returns a view with list of all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return Response
	*/
	abstract protected function showListView($first, $num);

	/**
	* Returns a view with the create element form
	* @return Response
	*/
	abstract protected function showCreateForm();

	/**
	* Stores the data
	* @return Response
	*/
	abstract protected function newResource();

	/**
	* Returns one of the elements
	* @return A JSON Response
	*/
	abstract protected function resource($id);

	/**
	* Returns a view of one of the elements
	* @return Response
	*/
	abstract protected function showResourceView($id);

	/**
	* Updates the data
	* @return Response
	*/
	abstract protected function updateResource($id);

	/**
	* Deletes the data
	* @return Response
	*/
	abstract protected function deleteResource($id);

	/**
	* Gets all the elements
	* @param first The first element of the listing
	* @param num The number of elements on the list
	* @return An array of models
	*/
	abstract protected function getElements($first, $num);

	/**
	* Gets an element
	* @param id The identifier of the element
	* @return A model
	*/
	abstract protected function getElement($id);

	/**
	* Function called when a request is not accepted
	* @return Response
	*/
	public function requestNotAccepted()
	{

		return Response::make('errors/badRequest', 401);

	}

	/**
	 * Display a listing of the resource. If it's an AJAX request the result
	 * is a JSON response
	 * @uses $_GET['first'] The first element on the listing
	 * @uses $_GET['num'] The number of elements on the listing
	 * @return Response
	 */
	public function index()
	{
		
		$first = Input::has('first') ? Input::get('first') : 0;
		$num = Input::has('num') ? Input::get('num') : PHP_INT_MAX;

		//if(Request::ajax())
		//{

			return $this->elements($first, $num);

		//}
		//else
		//{

		//	return $this->showListView($first, $num);

		//}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		if(Request::ajax())
		{

			return $this->requestNotAccepted();

		}
		else
		{

			return $this->showCreateForm();

		}

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		try {

			return $this->newResource();

		}
		catch(Illuminate\Database\QueryException $e)
		{

			return Response::json(array('ok' => 0, 'msg' => Lang::get('errors.errorCreatingElement'), 
				'internalMsg' => $e->getMessage()));

		}

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		if(Request::ajax())
		{

			return $this->resource($id);

		}
		else
		{

			return $this->showResourceView($id);

		}

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
		//All the editing is done on the client
		return $this->requestNotAccepted();

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		try {

			return $this->updateResource($id);

		}
		catch(Illuminate\Database\QueryException $e)
		{

			return Response::json(array('ok' => 0, 'msg' => Lang::get('errors.errorUpdatingElement'), 
				'internalMsg' => $e->getMessage()));

		}

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		if(Request::ajax())
		{

			try {

				$this->deleteResource($id);
				return Response::json(array('ok' => 1));

			}
			catch(Illuminate\Database\QueryException $e)
			{

				return Response::json(array('ok' => 0, 'msg' => Lang::get('errors.errorDeletingElement'), 
					'internalMsg' => $e->getMessage()));

			}

		}
		else
		{

			return $this->requestNotAccepted();

		}

	}

}
