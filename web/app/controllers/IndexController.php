<?php

class IndexController extends BaseController {

	public function showIndex()
	{

		$data = $this->getBasicData();

		$languageId = Language::locale(App::getLocale())->first()->id;
		$data->signupClause = ConfigurationTexts::language($languageId)->first()->privacyStatement;

		return View::make("public/index", array('data' => $data));

	}

}
