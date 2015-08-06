<?php

class IndexController extends BaseController {

	public function index()
	{

		$data = $this->getBasicData();
		$data->js = array("mapVisualization.js", "iastracker.js");

		return View::make("public/index", array('data' => $data));

	}

}
