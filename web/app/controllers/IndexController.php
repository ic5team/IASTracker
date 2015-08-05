<?php

class IndexController extends BaseController {

	/**
	 * Display a listing of the resource. If it's an AJAX request the result
	 * is a JSON response
	 * @uses $_GET['first'] The first element on the listing
	 * @uses $_GET['num'] The number of elements on the listing
	 * @return Response
	 */
	public function index()
	{

		$data = $this->getBasicData();
		

	}

}
